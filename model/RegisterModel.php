<?php

/*
* Handle all the data that has  something to do with the login
*/

namespace Model {
  
 function ValidateRegisterInput(string $username, string $password, string $passwordRepeat)
 {
   $response = new StatusMessage();

   $response->setMessageState(false);
   $response->setMessageString("Registration failed..");

   return $response;
 }

}

