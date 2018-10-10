<?php

class POST 
{
    private static $loginString = "login";
    private static $logoutString = "logout";

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
}