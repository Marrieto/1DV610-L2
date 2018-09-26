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

    $this->Connection = new mysqli($this->DBHost, $this->DBUsername, $this->DBPassword, $this->DBName, $this->DBPort);

    $this->Connection->query("CREATE TABLE IF NOT EXISTS `Users` (
      `id` int(11) NOT NULL auto_increment,   
      `cookiestring` varchar(250) default '',       
      `username` varchar(250)  NOT NULL,
      `password` varchar(250)  NOT NULL,     
    );");

  }

  public function connect(): boolean
  {
  //   echo "before";
    

  //   if (mysqli_connect_errno())
  //   {
  //     echo "Failed to connect to database: " . mysqli_connect_error();
  //     return false;
  //   }
  //   // $this->Connection = new PDO("msql:host=$this->DBHost;dbname=$this->DBName", $this->DBUsername, $this->DBPassword);
  //   echo "after";
  //   return true;
  // }

  

}
}