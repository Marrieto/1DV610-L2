<?php

class StatusMessage {

  private $messageState   = false;
  private $messageString  = "";

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