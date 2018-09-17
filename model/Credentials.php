<?php

class Credentials {

  private static $username      = "";
  private static $password      = "";
  private static $keepLoggedIn  = "";

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
	
}