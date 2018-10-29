<?php

class Password {

  private $firstPassword = "";
  private $secondPassword = "";

  public function __construct(string $firstPassword, string $secondPassword)
  {
    if (!passwordsMatch($firstPassword, $secondPassword))
    {
      throw new Exception("Passwords do not match.");
    }

    if (strlen($firstPassword) < 1)
    {
      throw new Exception("Password is missing.");
    }
    
    if (strlen($firstPassword) < 3)
    {
      throw new Exception("Password has too few characters, at least 6 characters.");
    }

    $this->firstPassword = $firstPassword;
    $this->secondPassword = $secondPassword;
  }

  private function passwordsMatch($password1, $password2): bool
  {
      return $password1 == $password2;
  }

  public function getFirstPassword(): string
  {
    return $this->firstPassword;
  }
  
  public function getSecondPassword(): string
  {
    return $this->secondPassword;
  }

}