<?php

/*
* Handle all the data that has  something to do with the login
*/

  
 function ValidateRegisterInputFormat(Credentials $credentials): StatusMessage
 {
   $response        = new StatusMessage();
   $username        = $credentials->getUsername();
   $password        = $credentials->getPassword();
   $passwordRepeat  = $credentials->getPasswordRepeat();

   $response->setMessageState(true);
   $response->setMessageString("Registered new user.");

   if (!passwordsMatch($password, $passwordRepeat))
   {
     $response->setMessageState(false);
     $response->setMessageString("Passwords do not match.");
   }
   if (!passwordIsLongEnough($password))
   {
    $response->setMessageState(false);
    $response->setMessageString("Password has too few characters, at least 6 characters.");
   }
   if (!usernameIsLongEnough($username))
   {
    $response->setMessageState(false);
    $response->setMessageString("Username has too few characters, at least 3 characters.");
   }
   if (!passwordIsLongEnough($password) && !usernameIsLongEnough($username))
   {
    $response->setMessageState(false);
    $response->setMessageString("Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.");
   }
   if (!usesValidCharacters($username))
   {
    $response->setMessageState(false);
    $response->setMessageString("Username contains invalid characters.");
   }

    // Check if passwords match
    // Check if password has too few letters
    // Check if username has too few letters
    // Check if username and password contains too few characters
    // Check if username contains invalid input

   return $response;
 }

function usernameIsLongEnough ($username): bool {
  return strlen($username) > 2;
}

function passwordIsLongEnough ($password): bool {
  return strlen($password) > 5;
}

function passwordsMatch ($password1, $password2): bool {
  return $password1 == $password2;
}

// Copied from https://stackoverflow.com/questions/1735972/php-fastest-way-to-check-for-invalid-characters-all-but-a-z-a-z-0-9
// 21/09/18
function usesValidCharacters ($word): bool {
  echo "non-sanitized: " . $word;
  $sanitizedString = str_replace(array("<",">"), "", $word);
  echo " sanitized: " . $sanitizedString;
  
  return $sanitizedString == $word;
  // return preg_match("[a-zA-Z0-9,.;:\-_'\s]", $word);
  //return !preg_match('/[^A-Za-z0-9.#\\-$]/', $word);
}


