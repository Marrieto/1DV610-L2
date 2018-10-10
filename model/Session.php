<?php

class Session 
{
    private static $sessionString = "sessionLoggedInStatus";
    private static $username = "sessionUsername";
    private static $password = "sessionPassword";

    public function __construct()
    {
        session_start();
    }

    public function setLoggedIn(bool $status): void
    {
        $_SESSION[self::$sessionString] = $status;
    }

    public function checkIfLoggedIn(): bool 
    {
        return isset($_SESSION[self::$sessionString]) && $_SESSION[self::$sessionString] = true;
    }

    public function setName(string $name): void
    {
        $_SESSION[self::$username] = $name;
    }

    public function getName(): string 
    {
        return $_SESSION[self::$username];
    }

    public function setPassword(string $password): void 
    {
        $_SESSION[self::$password] = $password;
    }

    public function getPassword(): string 
    {
        return $_SESSION[self::$password];
    }

    public function destroy(): void 
    {
        session_destroy();
    }
}