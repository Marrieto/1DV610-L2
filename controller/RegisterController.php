<?php

class RegisterController {

  private static $DateTimeView;
  private static $RegisterView;
  private static $LoginModel;

  public function __construct ($rv, $dtv, $lm) {
    self::$RegisterView = $rv;
    self::$DateTimeView = $dtv;
    self::$LoginModel   = $lm;
  }

  public function register ($messageString) {
    $statusMessage = new StatusMessage();
    $statusMessage->setMessageState(self::$LoginModel->checkIfLoggedInBySession());
    
    // echo $messageString->getMessageString();
    // $temp = $messageString->getMessageString();

    $statusMessage->setMessageString($messageString->getMessageString());
    // $statusMessage->setMessageString($messageString->getMessageString());
    // echo $messageString->getMessageString();


    self::$RegisterView->render($statusMessage, self::$DateTimeView);
  }

  private function userWantLogin () {
    return isset ($_POST['login']);
    // return self::$LoginView->
  }

  private function userWantLogout () {
    return isset ($_POST['logout']);
  }

  // TESTFUNKTION, WILL BE DELETED WHEN FINISHED
  private function printCredentials (Credentials $credentials) {
    echo $credentials->getUsername();
    echo $credentials->getPassword();
    echo $credentials->getKeepLoggedIn();
    echo $credentials->getCookieName();
    echo $credentials->getCookiePassword();
  }
  // TESTFUNKTION, WILL BE DELETED WHEN FINISHED
  private function checkIfPOST () 
  {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }
}