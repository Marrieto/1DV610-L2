<?php

/*
 A class to keep credential pairs
*/
class Credentials {

  private static $username      = "";
  private static $password      = "";
  private static $keepLoggedIn  = false;

  public function __construct ($username, $password, $keepLoggedIn) 
  {
    self::$username = $username;
    self::$password = $password;
    self::$keepLoggedIn = $keepLoggedIn;
  }

  public function getUsername  () 
  {
    return self::$username;
  }
  public function getPassword () 
  {
    return self::$password;
  }
  public function getKeepLoggedIn () 
  {
    return self::$keepLoggedIn;
  }

  // Checks if the credential object is having the right format
  public function validateCredentialFormat ()
  {
    $returnMessage = new StatusMessage();

    // Check if username exists
    if (!strlen(self::$username) > 0) {
      $returnMessage->setMessageState(false);
      $returnMessage->setMessageString("Username is missing");
      return $returnMessage;
    }

    // Check if password exists
    if (!strlen(self::$password) > 0) {
      $returnMessage->setMessageState(false);
      $returnMessage->setMessageString("Password is missing");
      return $returnMessage;
    } else {
      // If both exists, return a successful state, no message needed
      $returnMessage->setMessageState(true);
      return $returnMessage;
    }
  }
	
}