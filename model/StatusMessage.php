<?php

/*
 A class to keep a message and a state, useful in queries
*/
class StatusMessage {

  private $messageState   = false;
  private $messageString  = "";

  public function __construct () 
  {
    // NOT SURE IF NEEDED
    // $this->messageState   = false;
    // $this->messageString  = "";
  }

  public function getMessageState () 
  {
    return $this->messageState;
  }

  public function setMessageState ($state) 
  {
    $this->messageState = $state;
  }

  public function getMessageString () 
  {
    return $this->messageString;
  }

  public function setMessageString ($input) 
  {
    $this->messageString = $input;
  }
	
}