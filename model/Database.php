<?php

Class Database {

  private $DBUsername;
  private $DBPassword;
  private $DBPort;
  private $DBHost;
  private $DBName;
  private $Connection;
  
  public function _construct ($username, $password, $dbport, $dbhost, $dbname) {
    $this->DBUsername = $username;
    $this->DBPassword = $password;
    $this->DBPort = $dbport;
    $this->DBHost = $dbhost;
    $this->DBName = $dbname;
  }

  private function connect(): void
  {
    $this->Connection = new mysqli($this->DBHost, $this->DBUsername, $this->DBPassword, $this->DBName, $this->DBPort);
  }

  

}