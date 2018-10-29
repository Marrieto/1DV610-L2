<?php

class Username {

  private $username = "";

  public function __construct(string $username)
  {
    if (strlen($username) < 1)
    {
      throw new Exception("Username is missing.");
    }
    
    if (strlen($username) < 3)
    {
      throw new Exception("Username has too few characters, at least 3 characters.");
    }

    if (!usesValidCharacters($username))
    {
      throw new Exception("Username contains invalid characters.");
    }

    $this->username = $username;
  }

  private function usesValidCharacters($word): bool
  {
      $sanitizedString = str_replace(array("<", ">"), "", $word);
  
      return $sanitizedString == $word;
  }

  public function getUsername(): string
  {
    return $this->username;
  }

}