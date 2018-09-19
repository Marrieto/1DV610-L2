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
    $response = new StatusMessage();
    $response->setMessageState(false);
    //AretheInputscorrect? If so, ask the database, otherwise print out the error 
    
    //Check if user already logged in - Check session and cookies
    if (self::$LoginModel->checkIfLoggedIn()) {
      // echo 'User was logged in..';
      $response->setMessageState(true);
      $response->setMessageString("");
    }
    

    if ($this->checkIfPOST()) {
      // IF userWantsToLogin() && !userIsLoggedIn
      // CHECK IF ALREADY LOGGED IN -> RESPONSE SHOULD ALREADY BE 'TRUE'
      if (self::$LoginView->userWantLogin())
      {
        $response = $credentials->validateCredentialFormat();
        //// SWAPPED THIS LINE BELOW, checks if he's already logged in
        if ($response->getMessageState()) 
        {
          // Query the db to see if it was correct
          $response = self::$LoginModel->validateCredentials($credentials);
  
          // USER WANT TO LOG IN, WITH RIGHT CREDENTIALS
          if ($response->getMessageState()) {
            if (!self::$LoginModel->checkIfLoggedIn()) {
              self::$LoginModel->login();
              $response->setMessageString('Welcome');
            }
          }
          // ----------------------------------------------
          // TODO: Cookie, depending on checked box?s
          // TODO: Set cookies and session here accordingly
          // $credentials->getKeepLoggedIn()
          // ----------------------------------------------
        }

      self::$LayoutView->render($response, self::$LoginView, self::$DateTimeView);
        // HANDLE LOGOUT && self::$LoginModel->checkIfLoggedIn())
    } else if (self::$LoginView->userWantLogout())
    {
      // Only log out with 'Bye bye!' if the user was logged in
      if (self::$LoginModel->checkIfLoggedIn())
      {
        self::$LoginModel->logout();
        $response->setMessageState(false);
        $response->setMessageString("Bye bye!");
      }
      self::$LayoutView->render($response, self::$LoginView, self::$DateTimeView);
    } 
  } else {
    self::$LayoutView->render($response, self::$LoginView, self::$DateTimeView);
  }

}

  private function userWantLogin () {
    return isset ($_POST['login']);
    // return self::$LoginView->
  }

  private function userWantLogout () {
    return isset ($_POST['logout']);
  }

  // TESTFUNKTION, WILL BE DELETED
  private function printCredentials (Credentials $credentials) {
    echo $credentials->getUsername();
    echo $credentials->getPassword();
    echo $credentials->getKeepLoggedIn();
  }
  // TESTFUNKTION, WILL BE DELETED
  private function checkIfPOST () 
  {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }
}