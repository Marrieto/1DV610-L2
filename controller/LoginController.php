<?php

class LoginController
{
    private $Session;

    public function __construct($v, $dtv, $lv, $lm)
    {
        $this->LoginView = $v;
        $this->DateTimeView = $dtv;
        $this->LayoutView = $lv;
        $this->LoginModel = $lm;
        $this->Session = new Session();
        session_start();
    }

    public function login($credentialsFromMainController)
    {
        
        // Ask view if someone wants to log in
        $credentials = $this->LoginView->getCredentials();
        $response = new StatusMessage();
        $response->setMessageState(false);

        //Check if user already logged in - Checking session and cookies
        // if ($this->LoginModel->checkIfLoggedInBySession()) {
        // var_dump($this->Session->checkIfLoggedIn());
        if ($this->Session->checkIfLoggedIn()) {
            // echo 'User was logged in..';
            $response->setMessageState(true);
            $response->setMessageString("");
        }

        // Check if not logged in by session
        if (!$response->getMessageState() && $this->LoginModel->checkIfLoggedInByCookies($credentials)) {
            // $this->LoginModel->login($credentials);
            $this->Session->login();
            $response->setMessageState(true);
            $response->setMessageString("Welcome back with cookie");
        }

        if ($this->checkIfPOST()) {
            // CHECK IF ALREADY LOGGED IN -> RESPONSE SHOULD ALREADY BE 'TRUE'
            if ($this->LoginView->userWantLogin()) {
                $response = $credentials->validateCredentialFormat();
                //// SWAPPED THIS LINE BELOW, checks if he's already logged in
                if ($response->getMessageState()) {
                    // Query the db to see if it was correct
                    $response = $this->LoginModel->validateCredentialsToDB($credentials);

                    // USER WANT TO LOG IN, WITH RIGHT CREDENTIALS
                    if ($response->getMessageState()) {
                        if (!$this->LoginModel->checkIfLoggedIn()) {
                            // $this->LoginModel->login($credentials);
                            $this->Session->login();
                            $response->setMessageString('Welcome');
                        }
                    }
                }

                $this->LayoutView->render($response, $this->LoginView, $this->DateTimeView);
                //var_dump($this->Session->checkIfLoggedIn());
                // HANDLE LOGOUT && self::$LoginModel->checkIfLoggedIn())
            } else if ($this->LoginView->userWantLogout()) {
                // Only log out with 'Bye bye!' if the user was logged in
                // if ($this->LoginModel->checkIfLoggedIn()) {
                if ($this->Session->checkIfLoggedIn()) {
                    // $this->LoginModel->logout($credentials);
                    $this->Session->logout();
                    $response->setMessageState(false);
                    $response->setMessageString("Bye bye!");
                }
                $this->LayoutView->render($response, $this->LoginView, $this->DateTimeView);
                //var_dump($this->Session->checkIfLoggedIn());
            } else {
                // When one successfully register
                $response->setMessageString($credentialsFromMainController);
                $this->LayoutView->render($response, $this->LoginView, $this->DateTimeView);
                //var_dump($this->Session->checkIfLoggedIn());
            }
        } else {
            $this->LayoutView->render($response, $this->LoginView, $this->DateTimeView);
            //var_dump($this->Session->checkIfLoggedIn());
        }
    }

    private function userWantLogin()
    {
        return isset($_POST['login']);
    }

    private function userWantLogout()
    {
        return isset($_POST['logout']);
    }

    // TESTFUNKTION, WILL BE DELETED WHEN FINISHED
    private function printCredentials(Credentials $credentials)
    {
        echo $credentials->getUsername();
        echo $credentials->getPassword();
        echo $credentials->getKeepLoggedIn();
        echo $credentials->getCookieString();
        echo $credentials->getCookiePassword();
    }
    // TESTFUNKTION, WILL BE DELETED WHEN FINISHED
    private function checkIfPOST()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
}
