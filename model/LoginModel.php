<?php

class LoginModel
{

    private $db;
    private $cookies;
    private $Session;

    private $cookieName = "Loginview::CookieName";
    private $cookiePassword = "Loginview::CookieName";

    public function __construct()
    {
        $this->cookies = new Cookies();
        $this->db = new Database();
        $this->Session = new Session();
    }

    public function validateCredentialsToDB(Credentials $creds)
    {
        $response = new StatusMessage;

        if ($this->db->authenticate($creds)) {
            $response->setMessageState(true);
            $response->setMessageString("");
            return $response;
        }

        $response->setMessageState(false);
        $response->setMessageString("Wrong name or password");

        return $response;
    }

    public function login(Credentials $credentials)
    {
        $this->Session->login();
        $this->cookies->setUsername($username);
    }

    public function logout(Credentials $credentials)
    {
        $this->Session->logout();
        $this->cookies->removeCookies();
    }

    public function checkIfLoggedInByCookies(Credentials $credentials)
    {
        $this->cookies = new Cookies();
        // Return a statusmessage object, with outcome and message string if manipulated?
        $username = $credentials->getUsername();
        $cookieName = $this->cookieName;
        $cookieUsername = $this->cookies->getUsernameIfExist();

        if ($username == $cookieUsername && $username != "") {
            return true;
        } else {
            return false;
        }
    }

    public function getNotesIfExist(string $username)
    {
        if ($this->db->checkIfUserExist($username))
        {
            $noteArray = $this->db->getNotes($username);
            return $noteArray;
        } 
        else
        {
            $emptyNote = new Note("", "", 0);
            array_push($noteArray, $emptyNote);
            return $noteArray;
        }
    }

    public function addNote(string $content, string $username)
    {
        // $username = $this->credentials->getUsername();
        $this->db->addNote($content, $username);
    }
    public function removeNote(int $idToBeRemoved)
    {
        $this->db->removeNote($idToBeRemoved);
    }

}
