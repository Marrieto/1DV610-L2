<?php

/*
* Handle all the data that has  something to do with the login
*/

  
 function ValidateRegisterInputFormat(Credentials $credentials): StatusMessage
 {
   $response = new StatusMessage();

    // Check if passwords match
    // Check if password has too few letters
    // Check if username has too few letters
    // Check if username and password contains too few characters
    // Check if username contains invalid innput

   $response->setMessageState(false);
   $response->setMessageString("Registration failed..");

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
  return !preg_match('/[^A-Za-z0-9.#\\-$]/', $word);
}


