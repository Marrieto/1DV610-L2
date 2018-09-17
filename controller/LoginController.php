<?php

class LoginController {

  private static $DateTimeView;
  private static $LoginView;
  private static $LayoutView;
  private static $LoginModel;

  public function __construct ($v, $dtv, $lv, $lm) {
    self::$LoginView    = $v;
    self::$DateTimeView = $dtv;
    self::$LayoutView   = $lv;
    self::$LoginModel   = $lm;
  }

  public function login () {
    // Ask view if someone wants to log in
    $credentials = self::$LoginView->getCredentials();
    $this->printCredentials($credentials);
    // Check if username and password is present
    // -> Ask the model to try to log in
    //    -> if succesful, return true
    //        -> set session to loggedIn
    //        !-> if not, output 'wrong password or username'
    //    !-> if username/pass is missing, output accordingly

    // self::$LayoutView->setMessage('Benis');
    self::$LayoutView->render(false, self::$LoginView, self::$DateTimeView);
  }

  // Kolla om en post till 'login' sker ifrån main controller, isåfall -> skapa en 
  // sekvens av operationer definerat här i controllern.
  
  // Kolla om username finns

  // TESTFUNKTION
  private function printCredentials (Credentials $credentials) {
    echo $credentials->getUsername();
    echo $credentials->getPassword();
    echo $credentials->getKeepLoggedIn();
  }
	
}