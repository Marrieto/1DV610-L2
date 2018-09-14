<?php

/*
* Handle all the data that has  something to do with the login
*/
class LoginModel {

  public function queryUsername ($queryString) {
    if ($queryString == "Admin") {
      return true;
    } else {
      return false;
    }
  }

  public function queryPassword ($queryString) {
    if ($queryString == "Password") {
      return true;
    } else {
      return false;
    }
  }

}
