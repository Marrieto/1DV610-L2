<?php

class LoginModel {

  private static $db;
  private static $cookies;

  private static $cookieName = "Loginview::CookieName";
  private static $cookiePassword = "Loginview::CookieName";

  public function _construct ()
  {
    self::$cookies = new Cookies();
    self::$db = new Database();
  }

  public function validateCredentialsToDB (Credentials $creds)
  {
    $response = new StatusMessage;
    $tempdb = new Database();

    // TODO Replace this with database
    if ($tempdb->authenticate($creds))
    {
      $response->setMessageState(true);
      $response->setMessageString("");
      return $response;
    }

    $response->setMessageState(false);
    $response->setMessageString("Wrong name or password");

    return $response;
  }

  public function login (Credentials $credentials) {
    self::$cookies = new Cookies();
    $_SESSION["loggedin"] = 'true';
    $username = $credentials->getUsername();
    self::$cookies->setCookie(self::$cookieName, $username);
    
  }

  public function logout (Credentials $credentials) {
    self::$cookies = new Cookies();
    session_destroy();
    self::$cookies->removeCookie(self::$cookieName);
  }

  public function checkIfLoggedInBySession ()
  {
    return isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == 'true';
  }

  public function checkIfLoggedInByCookies (Credentials $credentials)
  {
    self::$cookies = new Cookies();
    // Return a statusmessage object, with outcome and message string if manipulated?
    $username = $credentials->getUsername();
    $cookieName = self::$cookieName;
    $cookieUsername = self::$cookies->getCookie($cookieName);

    if ($username == $cookieUsername && $username != ""){
      return true;
    } else {
      return false;
    }
  }

  // Check if user is logged in either Session or Cookies
  public function checkIfLoggedIn() {
    return isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == 'true';
  }

}
