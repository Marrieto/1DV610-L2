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

    public function __construct($username, $password, $keepLoggedIn, $cookieString, $cookiePassword, $passwordRepeat, $statusMessage)
    {
        $this->username = $username;
        $this->password = $password;
        $this->passwordRepeat = $passwordRepeat;
        $this->cookieString = $cookieString;
        $this->cookiePassword = $cookiePassword;
        $this->keepLoggedIn = $keepLoggedIn;
        $this->statusMessage = $statusMessage;
    }

    public function getUsername()
    {
        return $this->username;
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

}
