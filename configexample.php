<?php

class Config {

  private $DBUsername;
  private $DBPassword;
  private $DBPort;
  private $DBHost;
  private $DBName;

  public function _construct()
  {
    $this->DBUsername = "XXX";
    $this->DBPassword = "XXX";
    $this->DBPort = 0;
    $this->DBHost = "XXX";
    $this->DBName = "XXX";
  }

  public function getDBUsername()
  {
    return $this->DBUsername;
  }
  public function getDBPassword()
  {
    return $this->DBUsername;
  }
  public function getDBPort()
  {
    return $this->DBPort;
  }
  public function getDBHost()
  {
    return $this->DBHost;
  }
  public function getDBName()
  {
    return $this->DBName;
  }

}
