<?php

/*
* Handle all the data that has  something to do with the login
*/
class LoginModel {

  public function validateCredentials (Credentials $creds)
  {
    $response = new StatusMessage;

    if ($this->queryUsername($creds->getUsername()) & $this->queryPassword($creds->getPassword()))
    {
      $response->setMessageState(true);
      $response->setMessageString("Welcome");
      return $response;
    }

    $response->setMessageState(false);
    $response->setMessageString("Wrong name or password");

    return $response;
  }

  public function login () {
    $_SESSION["login"] = true;
  }

  public function logout () {
    session_destroy();
  }

  public function checkIfLoggedIn () {
    // echo "LOGGED IN\n";
    return (isset($_SESSION["login"]) && $_SESSION["login"] == true);
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
