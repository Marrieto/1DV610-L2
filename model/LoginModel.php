<?php

/*
* Handle all the data that has  something to do with the login
*/
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
    // TAKEN FROM https://stackoverflow.com/questions/19017694/one-line-php-random-string-generator 27/09/18
    // $rndStr = chr( mt_rand( 97 ,122 ) ) .substr( md5( time( ) ) ,1 );
    $username = $credentials->getUsername();
    self::$cookies->setCookie(self::$cookieName, $username);
    $_SESSION["loggedin"] = 'true';
  }

  public function logout (Credentials $credentials) {
    self::$cookies = new Cookies();
    // $username = $credentials->getUsername();
    self::$cookies->removeCookie(self::$cookieName);
    session_destroy();
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
    // $response = self::$cookies->getCookie(self::$cookieName);
    $cookieUsername = self::$cookies->getCookie(self::$cookieName);
    // echo "username is: " . $username . "   -   ";
    // echo "cookieusUsername is:  " . $cookieUsername;

    if ($username == $cookieUsername && $cookieUsername != ""){
      return true;
    } else {
      return false;
    }
  }

  // Check if user is logged in either Session or Cookies
  // TODO: add the cookiechecks in here, isset && $_SESSION[] || checkIfLoggedInByCookies ()
  public function checkIfLoggedIn() {
    return isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == 'true';
  }

  // public function echoLoggedIn () {
  //   // if ($_SESSION['loggedin'] == true) {
  //   //   echo 'also true..';
  //   // }
  // }

}
