<?php

class Session
{
    private static $sessionString = "sessionLoggedInStatus";
    private static $username = "sessionUsername";
    private static $password = "sessionPassword";

    public function login(): void
    {
        $_SESSION[self::$sessionString] = 'true';
    }

    public function logout(): void
    {
        $_SESSION[self::$sessionString] = 'false';
    }

    public function checkIfLoggedIn(): bool
    {
        return isset($_SESSION[self::$sessionString]) && $_SESSION[self::$sessionString] == 'true';
    }

    public function destroy(): void
    {
        session_destroy();
    }

    public function setUsername(string $name): void
    {
        $_SESSION[self::$username] = $name;
    }
    
    public function setPassword(string $password): void
    {
        $_SESSION[self::$password] = $password;
    }

    public function getUsernameIfExist()
    {
        if (isset($_SESSION[self::$username])) {
            return $_SESSION[self::$username];
        } else {return "";}
    }
    

    public function getPasswordIfExist()
    {
        if (isset($_SESSION[self::$password])) {
            return $_SESSION[self::$password];
        } else {return "";}
    }

}
