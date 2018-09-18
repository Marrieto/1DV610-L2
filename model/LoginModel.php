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


  /*
  TODO: Replace with DB-query
  */
  private function queryUsername ($queryString) {
    if ($queryString == "Admin") {
      return true;
    } else {
      return false;
    }
  }

  /*
  TODO: Replace with DB-query
  */
  private function queryPassword ($queryString) {
    if ($queryString == "Password") {
      return true;
    } else {
      return false;
    }
  }

}
