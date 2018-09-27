<?php

Class Cookies {

  public function setCookie($username, $rndString)
  {
    setcookie($username, $rndString, 60*60);
  }

  public function getCookie($username)
  {
    if (isset($_COOKIE[$username]))
    {
      return $_COOKIE[$username];
    }
  }

  public function removeCookie($username)
  {
    setcookie($username, "", -1);
  }

}