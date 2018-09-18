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
    // $this->printCredentials($c redentials);
    $response = new StatusMessage();
    $response->setMessageState(false);
    //AretheInputscorrect? If so, ask the database, otherwise print out the error 
    
    //Check if user already logged in
    $response->setMessageState(self::$LoginModel->checkIfLoggedIn());

    if ($this->checkIfThereWasAPOST()) {
      $response = $credentials->validateCredentialFormat();
      if ($response->getMessageState()) 
      {
        // Query the db to see if it was correct
        $replyFromDB = self::$LoginModel->validateCredentials($credentials);

        // If the user wants to stay logged in and the authorization was right, set session
        // TODO: Cookie, depending on checked box?s
        if ($credentials->getKeepLoggedIn() && $replyFromDB->getMessageState()) {
          self::$LoginModel->login();
        }
        // ----------------------------------------------
        // TODO: Set cookies and session here accordingly
        // ----------------------------------------------

        self::$LayoutView->render($replyFromDB, self::$LoginView, self::$DateTimeView);
      } else {         
        self::$LayoutView->render($response, self::$LoginView, self::$DateTimeView);
      }
    } else { 
      // If there's no POST, just print out the page without any messages
      self::$LayoutView->render($response, self::$LoginView, self::$DateTimeView);
    }


    // Check if username and password is present
    // -> Ask the model to try to log in
    //    -> if succesful, return true
    //        -> set session to loggedIn
    //        !-> if not, output 'wrong password or username'
    //    !-> if username/pass is missing, output accordingly


  }

  // TESTFUNKTION, WILL BE DELETED
  private function printCredentials (Credentials $credentials) {
    echo $credentials->getUsername();
    echo $credentials->getPassword();
    echo $credentials->getKeepLoggedIn();
  }
  // TESTFUNKTION, WILL BE DELETED
  private function checkIfThereWasAPOST () 
  {
    return $_SERVER['REQUEST_METHOD'] == 'POST';
  }
}