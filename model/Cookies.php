<?php

class Cookies
{
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';

    public function setUsername($value)
    {
        setcookie(self::$cookieName, $value, (time() + 60 * 60 * 24));
    }
    public function setPassword($value)
    {
        setcookie(self::$cookiePassword, $value, (time() + 60 * 60 * 24));
    }

    public function getCookie($cookiename)
    {
        if (isset($_COOKIE[$cookiename])) {
            return $_COOKIE[$cookiename];
        }
    }

    public function removeCookies($cookiename)
    {
        setcookie(self::$cookiename, "", (time() + 60 * 60 * 24));
        setcookie(self::$cookiePassword, "", (time() + 60 * 60 * 24));
        unset($_COOKIE[self::$cookiename]);
        unset($_COOKIE[self::$cookiePassword]);
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
        $cookieUsername = $this->getUsernameIfExist();

        if ($username == $cookieUsername && $username != "") {
            return true;
        } else {
            return false;
        }
    }

}
