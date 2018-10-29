<?php

class LoginController
{
    private $Session;
    private $POST;
    private $credentials;
    private $cookies;

    public function __construct($v, $dtv, $lv, $lm)
    {
        $this->LoginView = $v;
        $this->DateTimeView = $dtv;
        $this->LayoutView = $lv;
        $this->LoginModel = $lm;
        $this->session = new Session();
        $this->POST = new POST();
        $this->credentials = new Credentials();
        $this->cookies = new Cookies();
        session_start();
    }

    public function render(ResponseObject $statusFromMain): void
    {
        $this->credentials->fetchCredentials();
        $response = $this->checkIfLoggedIn();
        $noteArray = array();

        if ($statusFromMain->getWasSuccessful())
        {
            $noteArray = $this->LoginModel->getNotesIfExist($this->credentials->getUsername());
        }
        else
        {
            $emptyNote = new Note("", "", 0);
            array_push($noteArray, $emptyNote);
        }
        

        if ($statusFromMain->getMessage() != "")
        {
            $response->setMessage($statusFromMain->getMessage());
        }

        $html = $this->LoginView->returnHTML($response, $noteArray);

        $this->LayoutView->render($response, $html);
    }

    private function checkIfLoggedIn(): ResponseObject
    {
        $response = new ResponseObject();

        if ($this->session->checkIfLoggedInBySession())
        {
            $response->setWasSuccessful(true);
        }

        if (!$response->getWasSuccessful() && $this->cookies->checkIfLoggedInByCookies($this->credentials))
        {
            $response->setWasSuccessful(true);
            $response->setMessage("Welcome back with cookie");
        }
        return $response;
    }

    public function login(): void
    {
        $this->credentials->fetchCredentials();
        $this->session->login();
        $this->session->setUsername($this->credentials->getUsername());
        $this->cookies->setCookieUsername($this->credentials->getUsername());
        $this->cookies->setCookiePassword($this->credentials->getPassword());
    }
    public function logout(): void
    {
        $this->session->logout();
        $this->cookies->removeCookies();
    }

    public function userTriedToLogin(): ResponseObject
    {
        $response = new ResponseObject();
        $this->credentials->fetchCredentials();

        $response = $this->credentials->validateCredentialFormat();

        if ($response->getWasSuccessful())
        {
            $response = $this->LoginModel->validateCredentialsToDB($this->credentials);

            if ($response->getWasSuccessful() && !$this->session->checkIfLoggedinBySession())
            {
                $response->setMessage("Welcome");
                $response->setWasSuccessful(true);
            }
        }
        return $response;
    }

    public function removeOrAddNote(): void
    {
        $response = new ResponseObject();
        $username = $this->credentials->getUsernameIfExist();

        if ($this->POST->userWantsToAddNote())
        {
            $noteTextToBeAdded = $this->POST->getAddNoteContent();
            $noteUserToBeAdded = $this->credentials->getUsernameIfExist();

            $this->LoginModel->addNote($noteTextToBeAdded, $noteUserToBeAdded);
            
            $response->setMessage("Note added.");
            $response->setWasSuccessful(true);
            $this->render($response);
        } 
        else 
        {

            $noteIdToBeRemoved = $this->POST->getRemoveNoteContent();
            $this->LoginModel->removeNote($noteIdToBeRemoved);
            $response->setWasSuccessful(true);
            $response->setMessage("Note deleted.");
            $this->render($response);
        }
    }

}
