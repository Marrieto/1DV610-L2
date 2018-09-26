<?php

Class Database {

  private static $DBUsername;
  private static $DBPassword;
  private static $DBPort;
  private static $DBHost;
  private static $DBName;
  private static $Config;
  private $Connection;
  
  // public function _construct ($username, $password, $dbport, $dbhost, $dbname) {
  public function _construct () {  
    
    self::$DBUsername = "root";
    self::$DBPassword = "Password";
    self::$DBPort     = "3306";
    self::$DBHost     = "localhost";
    self::$DBName     = "Users";

    self::$Config     = new Config;

    // self::$DBUsername = self::$Config->getDBUsername;
    // self::$DBPassword = self::$Config->getDBPassword;
    // self::$DBPort     = self::$Config->getDBPort;
    // self::$DBHost     = self::$Config->getDBHost;
    // self::$DBName     = self::$Config->getDBName;

    // $this->Connection = new mysqli($this->DBHost, $this->DBUsername, $this->DBPassword, $this->DBName, $this->DBPort);
    
    $this->connect();
  }

  // TAKEN FROM https://www.w3schools.com/php/func_mysqli_connect.asp
  private function connect(): bool
  {
    $this->Connection = mysqli_connect("localhost", "root", "Password", "Users");
    return $this->checkConnection();
  }

  private function checkConnection (): bool 
  {
    if (mysqli_connect_errno())
    {
      echo "Failed to connect to MYSQL: " . mysqli_connect_error();
      return false;
    } else {
      return true;
    }
  }

  // Run this once if there's no table
  private function initDB () 
  {
    // TODO: REPLACE root/pass here from config
    // echo self::$DBUsername;

    // $this->Connection = mysqli_connect(self::$DBHost, self::$DBUsername, self::$DBPassword, self::$DBName);
    $this->Connection = mysqli_connect("localhost", "root", "Password", "Users");
    $this->Connection->query("CREATE TABLE IF NOT EXISTS `user` (   
      `cookiestring` varchar(250) default '',       
      `username` varchar(250)  NOT NULL,
      `password` varchar(250)  NOT NULL     
    );");
  }

  public function addUser(Credentials $credentials): bool
  {
    $this->initDB();
    $response = $this->connect();

    $hashedPassword = password_hash($credentials->getPassword(), PASSWORD_BCRYPT);
    
    $qry = "INSERT INTO user (username, password, cookiestring)
    VALUES ('" . $credentials->getUsername() . "', '" . $hashedPassword . "', '" . $credentials->getCookieString() . "')";
    
    if ($this->Connection->query($qry) == true && $response == true)
    {
      return true;
    } else {
      return false;
    }
    

  }

  public function checkIfUserExist (Credentials $credentials): bool
  {
    $this->initDB();
    $response = $this->connect();
    $username       = $credentials->getUsername();
    $qry = "SELECT username FROM user WHERE username=?";
    
    $prepared = $this->Connection->prepare($qry);

    $prepared->bind_param("s", $username);
    $prepared->execute();
    $prepared->bind_result($result);
    $prepared->fetch();

    // $statement = $this->Connection->prepare($qry);
    // $statement->bind_param('s', $username);
    // $statement->fetch();

    if ($result == $username)
    {
      return true;
    } else {
      return false;
    }
  }

}