<?php

/*
* Handle all the data that has  something to do with the login
*/
class LoginModel {

  private static $db;
  private static $cookies;

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
    $_SESSION["loggedin"] = 'true';
  }

  public function logout () {
    session_destroy();
  }

  public function checkIfLoggedInBySession ()
  {
    return isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == 'true';
  }

  public function checkIfLoggedInByCookies ()
  {
    // Query the database for a match of the "password"/randomstring
    //  If a match                          ## If string == "supersecret"
    //    --> save the name and password    ## return 'Admin' and 'Pass'
    //    --> (set the session aftwerwards, with username, password and randomstring)
    //  else
    //    --> return false
    // RETURN A STATUSMESSAGE OBJECET, if the cookie is wrong, set to false
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
