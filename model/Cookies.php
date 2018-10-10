<?php

class Cookies
{
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';

    // public function __construct()
    // {
    //     self
    // POSSIBLE BUG: not using the same variable names for checking pass/username
    // }

    public function setCookie($cookiename, $value)
    {
        setcookie($cookiename, $value, (time() + 60 * 60 * 24));
    }

    public function getCookie($cookiename)
    {
        if (isset($_COOKIE[$cookiename])) {
            return $_COOKIE[$cookiename];
        }
    }

    public function removeCookie($cookiename)
    {
        setcookie($cookiename, "", (time() + 60 * 60 * 24));
        unset($_COOKIE[$cookiename]);
    }

    public function hasCookie($cookiename)
    {
        return isset($_COOKIE[$cookiename]);
    }

    public function getUsernameIfExist()
    {
        if (isset($_COOKIE[self::$cookieName])) {
            return $_COOKIE[self::$cookieName];
        } else {return "";}
    }
    public function getPasswordIfExist()
    {
        if (isset($_COOKIE[self::$cookiePassword])) {
            return $_COOKIE[self::$cookiePassword];
        } else {return "";}
    }
    public function checkIfLoggedInByCookies(Credentials $credentials)
    {
        $this->cookies = new Cookies();
        // Return a statusmessage object, with outcome and message string if manipulated?
        $username = $credentials->getUsername();
        $cookieName = self::$cookieName;
        $cookieUsername = $this->getCookie($cookieName);

        if ($username == $cookieUsername && $username != "") {
            return true;
        } else {
            return false;
        }
    }

}
