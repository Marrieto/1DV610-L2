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

    public function render(StatusMessage $statusFromMain): void
    {
        $this->credentials->fetchCredentials();
        $response = $this->checkIfLoggedIn();
        $noteArray = array();

        if ($statusFromMain->getMessageState())
        {
            $noteArray = $this->LoginModel->getNotesIfExist($this->credentials->getUsername());
        }
        else
        {
            $emptyNote = new Note("", "", 0);
            array_push($noteArray, $emptyNote);
        }
        

        if ($statusFromMain->getMessageString() != "")
        {
            $response->setMessageString($statusFromMain->getMessageString());
        }

        $html = $this->LoginView->returnHTML($response, $noteArray);

        $this->LayoutView->render($response, $html);
    }

    private function checkIfLoggedIn(): StatusMessage
    {
        $response = new StatusMessage();

        if ($this->session->checkIfLoggedInBySession())
        {
            $response->setMessageState(true);
        }

        if (!$response->getMessageState() && $this->cookies->checkIfLoggedInByCookies($this->credentials))
        {
            $response->setMessageState(true);
            $response->setMessageString("Welcome back with cookie");
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

    public function userTriedToLogin(): StatusMessage
    {
        $response = new StatusMessage();
        $this->credentials->fetchCredentials();

        $response = $this->credentials->validateCredentialFormat();

        if ($response->getMessageState())
        {
            $response = $this->LoginModel->validateCredentialsToDB($this->credentials);

            if ($response->getMessageState() && !$this->session->checkIfLoggedinBySession())
            {
                $response->setMessageString("Welcome");
                $response->setMessageState(true);
            }
        }
        return $response;
    }

    public function removeOrAddNote(): StatusMessage
    {
        $response = new StatusMessage();
        $username = $this->credentials->getUsernameIfExist();

        if ($this->POST->userWantsToAddNote())
        {
            $noteTextToBeAdded = $this->POST->getAddNoteContent();
            $noteUserToBeAdded = $this->credentials->getUsernameIfExist();

            $this->LoginModel->addNote($noteTextToBeAdded, $noteUserToBeAdded);
            
            $response->setMessageString("Note added.");
            $response->setMessageState(true);
            $this->render($response);
        } 
        else 
        {

            $noteIdToBeRemoved = $this->POST->getRemoveNoteContent();
            $this->LoginModel->removeNote($noteIdToBeRemoved);
            $response->setMessageState(true);
            $response->setMessageString("Note deleted.");
            $this->render($response);
        }
    }

}
