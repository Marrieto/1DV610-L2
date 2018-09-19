<?php

/*
* Handle all the data that has  something to do with the login
*/
class LoginModel {

  public function validateCredentialsToDB (Credentials $creds)
  {
    $response = new StatusMessage;

    if ($this->queryUsername($creds->getUsername()) & $this->queryPassword($creds->getPassword()))
    {
      $response->setMessageState(true);
      $response->setMessageString("");
      return $response;
    } else if ($this->check)

    $response->setMessageState(false);
    $response->setMessageString("Wrong name or password");

    return $response;
  }

  public function login () {
    $_SESSION["loggedin"] = 'true';
  }

  public function logout () {
    session_destroy();
  }

  public function checkIfLoggedInBySession ()
  {
    return isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == 'true';
  }

  public function checkIfLoggedInByCookies ($cookiePassword)
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

  public function echoLoggedIn () {
    // if ($_SESSION['loggedin'] == true) {
    //   echo 'also true..';
    // }
  }
  /*
  TODO: Replace with DB-query
  */
  private function queryUsername ($queryString) {
    if ($queryString == "Admin") {
      //echo "\nCORRECT USERNAME";
      return true;
    } else {
      //echo "\n WRONG USERNAME";
      return false;
    }
  }

  /*
  TODO: Replace with DB-query
  */
  private function queryPassword ($queryString) {
    if ($queryString == "Pass") {
      // echo "\n CORRECT PASS";
      return true;
    } else {
      // echo "\n WRONG PASS";
      return false;
    }
  }

}
