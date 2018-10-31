<?php

class LoginController
{
    private $Session;
    private $POST;
    private $Credentials;
    private $Cookies;

    public function __construct($v, $lv, $lm)
    {
        $this->LoginView = $v;
        $this->LayoutView = $lv;
        $this->LoginModel = $lm;

        $this->Session = new Session();
        $this->POST = new POST();
        $this->Credentials = new Credentials();
        $this->Cookies = new Cookies();

        Session_start();
    }

    public function render(ResponseObject $statusFromMain): void
    {
        $renderObject = new ResponseObject();
        $this->Credentials->fetchCredentials();
        // $renderObject = $this->checkIfLoggedIn();
        $renderObject->setSuccessful($this->checkIfLoggedIn());
        $noteArray = array();

        if ($statusFromMain->getMessage() != "")
        {
            $renderObject->setMessage($statusFromMain->getMessage());
        }

        // if ($statusFromMain->wasSuccessful())
        if ($renderObject->wasSuccessful())
        {
            $noteArray = $this->LoginModel->getNotesIfExist($this->Credentials->getUsername());
        }
        else
        {
            $emptyNote = new Note("", "", 0);
            array_push($noteArray, $emptyNote);
        }
        



        $html = $this->LoginView->returnHTML($renderObject, $noteArray);

        $this->LayoutView->render($renderObject, $html);
    }

    private function checkIfLoggedIn(): bool
    {
        // $response = new ResponseObject();
        // if ($this->Session->checkIfLoggedInBySession())
        // {
        //     $response->setSuccessful(true);
        // }
        // if (!$response->wasSuccessful() && $this->Cookies->checkIfLoggedInByCookies($this->Credentials))
        // {
        //     $response->setSuccessful(true);
        //     $response->setMessage("Welcome back with cookie");
        // }
        // return $response;
        return $this->Session->checkIfLoggedInBySession();
    }

    public function login(): void
    {
        $this->Credentials->fetchCredentials();
        $this->Session->login();
        $this->Session->setUsername($this->Credentials->getUsername());
        $this->Cookies->setCookieUsername($this->Credentials->getUsername());
        $this->Cookies->setCookiePassword($this->Credentials->getPassword());
    }
    public function logout(): void
    {
        $this->Session->logout();
        $this->Cookies->removeCookies();
    }

    public function tryToLogin(): ResponseObject
    {
        $response = new ResponseObject();
        // $response->setMessage("");

        $this->Credentials->fetchCredentials();

        try 
        {
            $this->Credentials->validateCredentialFormat();
            $this->LoginModel->validateCredentialsToDB($this->Credentials);
        }
        catch (Exception $e)
        {
            $response->setSuccessful(false);
            $response->setMessage($e->getMessage());
            return $response;
        }
        
        if (!$this->Session->checkIfLoggedInBySession())
        {
            $response->setMessage('Welcome');
            $this->login();
        }

        return $response;

        //$response = $this->Credentials->validateCredentialFormat();
        // if ($response->wasSuccessful())
        // {
        //     // try 
        //     // {
        //     //     $this->LoginModel->validateCredentialsToDB($this->Credentials);
        //     // }
        //     // catch (Exception $e)
        //     // {
        //     //     $response->setSuccesful(false);
        //     // }
        //     $response = $this->LoginModel->validateCredentialsToDB($this->Credentials);
        //     if ($response->wasSuccessful() && !$this->Session->checkIfLoggedinBySession())
        //     {
        //         $response->setMessage("Welcome");
        //         $this->login();
        //     }
        // }
        // return $response;
    }

    public function tryToLogout(): ResponseObject
    {
        $response = new ResponseObject();

        if ($this->Session->checkIfLoggedInBySession())
        {
            $response->setMessage('Bye bye!');
            $this->logout();
        }

        return $response;
    }

    public function removeOrAddNote(): ResponseObject
    {
        $response = new ResponseObject();
        $username = $this->Credentials->getUsernameIfExist();

        if ($this->POST->userWantsToAddNote())
        {
            $noteTextToBeAdded = $this->POST->getAddNoteContent();
            $noteUserToBeAdded = $this->Credentials->getUsernameIfExist();
            $response->setMessage("Note added.");
            $response->setSuccessful(true);

            try 
            {
                $this->LoginModel->addNote($noteTextToBeAdded, $noteUserToBeAdded);
            }
            catch (Exception $e)
            {
                $response->setMessage($e->getMessage());
            }
            
            return $response;
            // $this->render($response);
        } 
        else 
        {

            $noteIdToBeRemoved = $this->POST->getRemoveNoteContent();
            $this->LoginModel->removeNote($noteIdToBeRemoved);
            $response->setSuccessful(true);
            $response->setMessage("Note deleted.");
            $this->render($response);
        }
    }

}
