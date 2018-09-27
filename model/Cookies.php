<?php

Class Cookies {

  public static function setCookie($cookiename, $value)
  {
    // echo $cookiename;
    // echo $value;
    setcookie($cookiename, $value, (time() + 60*60*24));
  }

  public static function getCookie($cookiename)
  {
    if (isset($_COOKIE[$cookiename]))
    {
      return $_COOKIE[$cookiename];
    }
  }

  public static function removeCookie($cookiename)
  {
    // echo $cookiename;
    setcookie($cookiename, "", -60);
    unset($_COOKIE[$cookiename]);
  }

  public static function hasCookie($cookiename)
  {
    return isset($_COOKIE[$cookiename]);
  }

}