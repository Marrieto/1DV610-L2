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
    private $ResponseObject = "";
    private $keepLoggedIn = false;
    private $POST;
    private $session;
    private $cookies;

    public function __construct()
    {
        $this->username = "";
        $this->password = "";
        $this->passwordRepeat = "";
        $this->cookieString = "";
        $this->cookiePassword = "";
        $this->keepLoggedIn = false;
        $this->ResponseObject = "";
        $this->POST = new POST();
        $this->session = new Session();
        $this->cookies = new Cookies();
    }

    // public function validateCredentialFormat(): ResponseObject
    public function validateCredentialFormat(): void
    {
        // $returnMessage = new ResponseObject();
        // var_dump($this);

        if (!strlen($this->username) > 0) {
            throw new Exception('Username is missing');
            // $returnMessage->setSuccessful(false);
            // $returnMessage->setMessage("Username is missing");
            // return $returnMessage;
        }

        if (!strlen($this->password) > 0) {
            throw new Exception('Password is missing');
            // $returnMessage->setSuccessful(false);
            // $returnMessage->setMessage("Password is missing");
            // return $returnMessage;
        } //else {
        //     $returnMessage->setSuccessful(true);
        //     return $returnMessage;
        // }
    }
    
    public function fetchCredentials(): void 
    {
        $this->username = $this->getUsernameIfExist();
        $this->password = $this->getPasswordIfExist();
        $this->passwordRepeat = $this->getPasswordRepeatIfExist();
        $this->keep = $this->getKeepIfExist();
        $this->cookieUsername = $this->getCookieUsernameIfExist();
        $this->cookiePassword = $this->getCookiePasswordIfExist();
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
    
    public function getUsernameIfExist(): string
    {
        if ($this->POST->getUsernameIfExist() != "")
        {
            return $this->POST->getUsernameIfExist();
        } else if ($this->session->getUsernameIfExist() != "")
        {
            return $this->session->getUsernameIfExist();
        } else {
            return "";
        }
    }
    
    private function getPasswordRepeatIfExist(): string
    {
        return $this->POST->getPasswordRepeatIfExist();
    }

    public function getUsername(): string
    {
        return $this->username;
    }
    public function getUsernameSanitized(): string 
    {
        return strip_tags($this->username);
    }
    public function getPassword(): string
    {
        return $this->password;
    }
    public function getPasswordRepeat(): string
    {
        return $this->passwordRepeat;
    }
    public function getKeepLoggedIn(): bool
    {
        return $this->keepLoggedIn;
    }
    public function getCookieString(): string
    {
        return $this->cookieString;
    }
    public function getCookiePassword(): string
    {
        return $this->cookiePassword;
    }
    public function getResponseObject(): string
    {
        return $this->ResponseObject;
    }
    public function setResponseObject($message): void
    {
        $this->ResponseObject = $message;
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
