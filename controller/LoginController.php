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
        $responseObject = new ResponseObject();
        $this->Credentials->fetchCredentials();
    
        $responseObject->setSuccessful($this->checkIfLoggedIn());
        $noteArray = array();

        if ($statusFromMain->getMessage() != "")
        {
            $responseObject->setMessage($statusFromMain->getMessage());
        }

        if ($responseObject->wasSuccessful())
        {
            $noteArray = $this->LoginModel->getNotesIfExist($this->Credentials->getUsername());
        }
        else
        {
            $emptyNote = new Note("", "", 0);
            array_push($noteArray, $emptyNote);
        }
        
        $html = $this->LoginView->returnHTML($responseObject, $noteArray);

        $this->LayoutView->render($responseObject, $html);
    }

    private function checkIfLoggedIn(): bool
    {
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

        $this->Credentials->fetchCredentials();

        try 
        {
            $this->Credentials->credentialsExist();
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
        $username = $this->Credentials->getUsernameIfExist();

        if ($this->POST->userWantsToAddNote())
        {
            $noteTextToBeAdded = $this->POST->getAddNoteContent();
            $response = $this->LoginModel->addNote($noteTextToBeAdded, $username);

            return $response;
        } 
        else 
        {
            $noteIdToBeRemoved = $this->POST->getRemoveNoteId();
            $response = $this->LoginModel->removeNote($noteIdToBeRemoved, $username);

            return $response;
        }
    }

}
