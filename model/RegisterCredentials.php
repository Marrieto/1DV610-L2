<?php

class RegisterCredentials {

  private $username = "";
  private $firstPassword = "";
  private $secondPassword = "";

  public function __construct(string $username, string $firstPassword, string $secondPassword)
  {

    if (!$this->passwordsMatch($firstPassword, $secondPassword))
    {
      throw new Exception("Passwords do not match.");
    }

    if (strlen($username) < 3 && strlen($firstPassword) < 6)
    {
      throw new Exception("Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.");
    }
    
    if (strlen($username) < 3)
    {
      throw new Exception("Username has too few characters, at least 3 characters.");
    }

    if (!$this->usesValidCharacters($username))
    {
      throw new Exception("Username contains invalid characters.");
    }
    
    if (strlen($firstPassword) < 6)
    {
      throw new Exception("Password has too few characters, at least 6 characters.");
    }

    $this->firstPassword = $firstPassword;
    $this->secondPassword = $secondPassword;
    $this->username = $username;
  }

  private function usesValidCharacters($word): bool
  {
      $sanitizedString = str_replace(array("<", ">"), "", $word);
  
      return $sanitizedString == $word;
  }

  private function passwordsMatch($password1, $password2): bool
  {
      return $password1 == $password2;
  }

  public function getUsername(): string
  {
    return $this->username;
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