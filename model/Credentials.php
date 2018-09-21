<?php

/*
 A class to keep credential pairs
*/
class Credentials {

  private static $username        = "";
  private static $password        = "";
  private static $passwordRepeat  = "";
  private static $cookieName      = "";
  private static $cookiePassword  = "";
  private static $keepLoggedIn    = false;

  public function __construct ($username, $password, $keepLoggedIn, $cookieName, $cookiePassword, $passwordRepeat) 
  {
    self::$username         = $username;
    self::$password         = $password;
    self::$passwordRepeat   = $passwordRepeat;
    self::$cookieName       = $cookieName;
    self::$cookiePassword   = $cookiePassword;
    self::$keepLoggedIn     = $keepLoggedIn;
  }

  public function getUsername  () 
  {
    return self::$username;
  }
  public function getPassword () 
  {
    return self::$password;
  }
  public function getPasswordRepeat ()
  {
    return self::$passwordRepeat;
  }
  public function getKeepLoggedIn () 
  {
    return self::$keepLoggedIn;
  }
  public function getCookieName ()
  {
    return self::$cookieName;
  }
  public function getCookiePassword ()
  {
    return self::$cookiePassword;
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