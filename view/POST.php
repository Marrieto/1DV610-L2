<?php

class POST
{
    private static $loginString = "LoginView::Login";
    private static $logoutString = "LoginView::Logout";
    private static $registerName = "RegisterView::Register";
    // private static $registerUsername = 'RegisterView::UserName';
    //private static $registerUsername = 'LoginView::UserName';
    //private static $registerPassword = 'LoginView::Password';
    // private static $registerPassword = 'RegisterView::Password';
    private static $registerPasswordRepeat = 'RegisterView::PasswordRepeat';
    private static $registerMessageId = 'RegisterView::Message';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private $viewNames;
    // TODO: use ViewVariables object instead of static strings
    public function __construct()
    {
        $this->viewNames = new ViewVariables();
    }

    public function userWantToLogin(): bool
    {
        return isset($_POST[self::$loginString]);
    }

    public function userWantToLogout(): bool
    {
        return isset($_POST[self::$logoutString]);
    }

    public function requestMethodIsPOST(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function userTriedToRegister()
    {
        if (isset($_POST[self::$registerName])) {
            return true;
        } else {
            return false;
        }
    }

    // public function returnRegisterName(): string
    // {
    //     return self::$registerName;
    // }

    // public function returnRegisterUsername(): string
    // {
    //     return self::$registerUsername;
    // }

    public function getUsernameIfExist(): string
    {
        if (isset($_POST[$this->viewNames->getLUsername()])) 
        {
            return $_POST[$this->viewNames->getLUsername()];
        } else if (isset($_POST[$this->viewNames->getRUsername()]))
        {
            return $_POST[$this->viewNames->getRUsername()];
        }
        else {return "";}
    }
    public function getPasswordIfExist(): string
    {
        if (isset($_POST[$this->viewNames->getLPassword()])) 
        {
            return $_POST[$this->viewNames->getLPassword()];
        } else if (isset($_POST[$this->viewNames->getRPassword()]))
        {
            return $_POST[$this->viewNames->getRPassword()];
        } 
        else {return "";}
    }
    public function getPasswordRepeatIfExist(): string
    {
        if (isset($_POST[$this->viewNames->getRPasswordRepeat()])) {
            return $_POST[$this->viewNames->getRPasswordRepeat()];
        } else {return "";}
    }
    public function getKeepIfExist(): bool
    {
        return (isset($_POST[$this->viewNames->getLKeep()]) && !empty($_POST[$this->viewNames->getLKeep()]));
    }

}