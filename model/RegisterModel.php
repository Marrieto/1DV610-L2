<?php

/*
* Handle all the data that has  something to do with the login
*/

  
 function ValidateRegisterInput(Credentials $credentials)
 {
   $response = new StatusMessage();

   $response->setMessageState(true);
   $response->setMessageString("Registration failed..");

   return $response;
 }


