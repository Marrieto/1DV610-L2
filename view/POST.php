<?php

class POST
{
    private static $loginString = "LoginView::Login";
    private static $logoutString = "LoginView::Logout";
    private static $registerName = "RegisterView::Register";
    private static $registerUsername = 'RegisterView::UserName';
    private static $registerPassword = 'RegisterView::Password';
    private static $registerPasswordRepeat = 'RegisterView::PasswordRepeat';
    private static $registerMessageId = 'RegisterView::Message';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    // TODO: use ViewVariables object instead of static strings

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

    public function returnRegisterName(): string
    {
        return self::$registerName;
    }

    public function returnRegisterUsername(): string
    {
        return self::$registerUsername;
    }

    public function getUsernameIfExist(): string
    {
        if (isset($_POST[self::$registerUsername])) {
            return $_POST[self::$registerUsername];
        } else {return "";}
    }
    public function getPasswordIfExist(): string
    {
        if (isset($_POST[self::$registerPassword])) {
            return $_POST[self::$registerPassword];
        } else {return "";}
    }
    public function getPasswordRepeatIfExist(): string
    {
        if (isset($_POST[self::$registerPasswordRepeat])) {
            return $_POST[self::$registerPasswordRepeat];
        } else {return "";}
    }
    public function getKeepIfExist(): bool
    {
        return (isset($_POST[self::$keep]) && !empty($_POST[self::$keep]));
    }

}
