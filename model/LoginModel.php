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

    public function validateCredentialsToDB(Credentials $creds): void
    {

        if (!$this->db->authenticate($creds)) {
            throw new Exception('Wrong name or password');
        }

    }

    public function login(Credentials $credentials): void
    {
        $this->Session->login();
        $this->cookies->setUsername($username);
    }

    public function logout(Credentials $credentials): void
    {
        $this->Session->logout();
        $this->cookies->removeCookies();
    }

    public function checkIfLoggedInByCookies(Credentials $credentials): bool
    {
        $this->cookies = new Cookies();

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

    public function addNote(string $content, string $username): void
    {
        try 
        {
            $this->validateNoteContent($content);
            $this->db->addNote($content, $username);
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }
    }

    public function removeNote(int $idToBeRemoved, string $username): ResponseObject
    {
        $response = new ResponseObject();
        $noteUser = $this->db->findNoteUser($idToBeRemoved);

        try
        {
            $this->checkIfUserMatches($username, $noteUser);
            $this->db->removeNote($idToBeRemoved);
        }
        catch (Exception $e)
        {
            $response->setMessage($e->getMessage());
            $response->setSuccessful(false);
            return $response;
        }

        $response->setMessage('Note deleted.');
        $response->setSuccessful(true);

        return $response;
        // $this->db->removeNote($idToBeRemoved);
    }

    private function validateNoteContent(string $content): void
    {
        if (strlen($content) == 0) 
        {
            throw new Exception('Cannot add an empty note!');
        }
        if (strlen($content) > 500)
        {
            throw new Exception('Note cannot be longer than 500 characters!');
        }
        if (strip_tags($content) !== $content)
        {
            throw new Exception('Code is not allowed to be subbmitted to a note!');
        }
    }

    private function checkIfUserMatches($username1, $username2)
    {
        if($username1 !== $username2)
        {
            throw new Exception('Remove note error: no note with that ID found.');
        }
    }

}
