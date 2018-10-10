<?php

/*
A class to keep credential pairs
 */
class Credentials
{

    private $username = "";
    private $password = "";
    private $passwordRepeat = "";
    private $cookieString = "";
    private $cookiePassword = "";
    private $statusMessage = "";
    private $keepLoggedIn = false;
    private $POST;
    private $session;
    private $cookies;

    public function __construct($username, $password, $keepLoggedIn, $cookieString, $cookiePassword, $passwordRepeat, $statusMessage)
    {
        $this->username = $username;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
        $this->cookieString = $cookieString;
        $this->cookiePassword = $cookiePassword;
        $this->keepLoggedIn = $keepLoggedIn;
        $this->statusMessage = $statusMessage;
        $this->POST = new POST();
        $this->session = new Session();
        $this->cookies = new Cookies();
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function getUsernameSanitized(): string 
    {
        return strip_tags($this->username);
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getPasswordRepeat()
    {
        return $this->passwordRepeat;
    }
    public function getKeepLoggedIn()
    {
        return $this->keepLoggedIn;
    }
    public function getCookieString()
    {
        return $this->cookieString;
    }
    public function getCookiePassword()
    {
        return $this->cookiePassword;
    }
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }
    public function setStatusMessage($message)
    {
        $this->statusMessage = $message;
    }

    // Checks if the credential object is having the right format
    public function validateCredentialFormat()
    {
        $returnMessage = new StatusMessage();

        // Check if username exists
        if (!strlen($this->username) > 0) {
            $returnMessage->setMessageState(false);
            $returnMessage->setMessageString("Username is missing");
            return $returnMessage;
        }

        // Check if password exists
        if (!strlen($this->password) > 0) {
            $returnMessage->setMessageState(false);
            $returnMessage->setMessageString("Password is missing");
            return $returnMessage;
        } else {
            $returnMessage->setMessageState(true);
            return $returnMessage;
        }
    }

    public function getCredentials(): void 
    {
        // $username = $this->getUsernameIfExist();
        // $password = $this->getPasswordIfExist();
        // $passwordRepeat = $this->getPasswordRepeatIfExist();
        // $keep = $this->getKeepIfExist();
        // $cookieUsername = $this->getCookieUsernameIfExist();
        // $cookiePassword = $this->getCookiePasswordIfExist();
        $this->username = $this->getUsernameIfExist();
        $this->password = $this->getPasswordIfExist();
        $this->passwordRepeat = $this->getPasswordRepeatIfExist();
        $this->keep = $this->getKeepIfExist();
        $this->cookieUsername = $this->getCookieUsernameIfExist();
        $this->cookiePassword = $this->getCookiePasswordIfExist();
        // Byt till $this->username = getUsername etc.. setCredentials?
    }

    private function getUsernameIfExist(): string
    {
        if ($this->POST->returnUsernameIfExist() != "")
        {
            return $this->POST->getUsernameIfExist();
        } else if ($this->session->getUsernameIfExist() != "")
        {
            return $this->session->getUsernameIfExist();
        } else {
            return "";
        }
    }
    private function getPasswordIfExist(): string
    {
        if ($this->POST->getPasswordIfExist() != "")
        {
            return $this->POST->getPasswordIfExist();
        } else if ($this->session->getPasswordIfExist() != "")
        {
            return $this->session->getPasswordIfExist();
        } else {
            return "";
        }
    }
    private function getPasswordRepeatIfExist(): string
    {
        return $this->POST->getPasswordRepeatIfExist();
    }
    private function getKeepIfExist(): string
    {
        return $this->POST->getKeepIfExist();
    }
    private function getCookieUsernameIfExist(): string
    {
        return $this->cookies->getUsernameIfExist();
    }
    private function getCookiePasswordIfExist(): string
    {
        return $this->cookies->getPasswordIfExist();
    }
}
