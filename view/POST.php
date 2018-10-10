<?php

class POST
{
    private static $loginString = "LoginView::Login";
    private static $logoutString = "LoginView::Logout";
    private static $registerString = "RegisterView::Register";

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
        if (isset($_POST[self::$registerString])) {
            return true;
        } else {
            return false;
        }
    }

    // Put getCredentials here
}
