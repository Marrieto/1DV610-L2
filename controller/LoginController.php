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
    
    //Check if user already logged in
    if (self::$LoginModel->checkIfLoggedIn()) {
      // echo 'User was logged in..';
      $response->setMessageState(true);
      $response->setMessageString("");
    } else {
      // echo 'Checked if logged in returns false';
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
          $replyFromDB = self::$LoginModel->validateCredentials($credentials);
  
          // If the user wants to stay logged in and the authorization was right, set session
          // TODO: Cookie, depending on checked box?s

          // USER WANT TO LOG IN, WITH RIGHT CREDENTIALS
          if ($replyFromDB->getMessageState()) {
            if (!self::$LoginModel->checkIfLoggedIn()) {
              self::$LoginModel->login();
              // $replyFromDB->setMessageString('Welcome');
              $response->setMessageString('Welcome');
            }
          }
          // ----------------------------------------------
          // TODO: Set cookies and session here accordingly
          // $credentials->getKeepLoggedIn()
          // ----------------------------------------------
        }
          // self::$LayoutView->render($replyFromDB, self::$LoginView, self::$DateTimeView);
        // } else {     
        //   self::$LayoutView->render($response, self::$LoginView, self::$DateTimeView);
        // }
      }

      // HANDLE LOGOUT
      if (self::$LoginView->userWantLogout() && self::$LoginModel->checkIfLoggedIn())
      {
        self::$LoginModel->logout();
        $response->setMessageState(false);
        $response->setMessageString("Bye bye!");
      }

      self::$LayoutView->render($response, self::$LoginView, self::$DateTimeView);

    } else { 
      //echo "there was no post";
      // If there's no POST, just print out the page without any messages
      self::$LayoutView->render($response, self::$LoginView, self::$DateTimeView);
    }

  }

  // private function userWantLogin () {
  //   return self::$LoginView->
  // }

  // private function userWantLogout () {
  //   return isset ($_POST['logout']);
  // }

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