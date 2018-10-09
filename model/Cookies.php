<?php

class Cookies
{

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

}
