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

    public function render(StatusMessage $statusFromMain)
    {
        $this->credentials->getCredentials();
        $response = $this->checkIfLoggedIn();
        $noteArray = $this->LoginModel->getNotesIfExist($this->credentials->getUsername());

        if ($statusFromMain->getMessageString() != "")
        {
            $response->setMessageString($statusFromMain->getMessageString());
        }

        $html = $this->LoginView->returnHTML($response, $noteArray);

        $this->LayoutView->render($response, $html);
    }

    private function checkIfLoggedIn()
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

    public function login()
    {
        $this->credentials->getCredentials();
        $this->session->login();
        $this->session->setUsername($this->credentials->getUsername());
        $this->cookies->setCookieUsername($this->credentials->getUsername());
        $this->cookies->setCookiePassword($this->credentials->getPassword());
    }
    public function logout()
    {
        $this->session->logout();
        $this->cookies->removeCookies();
    }

    public function userTriedToLogin()
    {
        $response = new StatusMessage();
        $this->credentials->getCredentials();

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

    public function removeOrAddNote()
    {
        $response = new StatusMessage();
        $username = $this->credentials->getUsernameIfExist();

        if ($this->POST->userWantsToAddNote())
        {
            // Lägg till vart posten ska gå, skriv sedan klart här nere
            $noteTextToBeAdded = $this->POST->getAddNoteContent();
            $noteUserToBeAdded = $this->credentials->getUsernameIfExist();

            $this->LoginModel->addNote($noteTextToBeAdded, $noteUserToBeAdded);
            
            // Render using this login with status message
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
