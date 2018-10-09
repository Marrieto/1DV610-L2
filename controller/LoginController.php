<?php

class LoginController
{

    private static $DateTimeView;
    private static $LoginView;
    private static $LayoutView;
    private static $LoginModel;

    public function __construct($v, $dtv, $lv, $lm)
    {
        self::$LoginView = $v;
        self::$DateTimeView = $dtv;
        self::$LayoutView = $lv;
        self::$LoginModel = $lm;
    }

    public function login($credentialsFromMainController)
    {
        // Ask view if someone wants to log in
        $credentials = self::$LoginView->getCredentials();
        $response = new StatusMessage();
        $response->setMessageState(false);

        //Check if user already logged in - Checking session and cookies
        if (self::$LoginModel->checkIfLoggedInBySession()) {
            // echo 'User was logged in..';
            $response->setMessageState(true);
            $response->setMessageString("");
        }

        // Check if not logged in by session
        if (!$response->getMessageState() && self::$LoginModel->checkIfLoggedInByCookies($credentials)) {
            self::$LoginModel->login($credentials);
            $response->setMessageState(true);
            $response->setMessageString("Welcome back with cookie");
        }

        if ($this->checkIfPOST()) {
            // CHECK IF ALREADY LOGGED IN -> RESPONSE SHOULD ALREADY BE 'TRUE'
            if (self::$LoginView->userWantLogin()) {
                $response = $credentials->validateCredentialFormat();
                //// SWAPPED THIS LINE BELOW, checks if he's already logged in
                if ($response->getMessageState()) {
                    // Query the db to see if it was correct
                    $response = self::$LoginModel->validateCredentialsToDB($credentials);

                    // USER WANT TO LOG IN, WITH RIGHT CREDENTIALS
                    if ($response->getMessageState()) {
                        if (!self::$LoginModel->checkIfLoggedIn()) {
                            self::$LoginModel->login($credentials);
                            $response->setMessageString('Welcome');
                        }
                    }
                }

                self::$LayoutView->render($response, self::$LoginView, self::$DateTimeView);
                // HANDLE LOGOUT && self::$LoginModel->checkIfLoggedIn())
            } else if (self::$LoginView->userWantLogout()) {
                // Only log out with 'Bye bye!' if the user was logged in
                if (self::$LoginModel->checkIfLoggedIn()) {
                    self::$LoginModel->logout($credentials);
                    $response->setMessageState(false);
                    $response->setMessageString("Bye bye!");
                }
                self::$LayoutView->render($response, self::$LoginView, self::$DateTimeView);
            } else {
                // When one successfully register
                $response->setMessageString($credentialsFromMainController);
                self::$LayoutView->render($response, self::$LoginView, self::$DateTimeView);
            }
        } else {
            self::$LayoutView->render($response, self::$LoginView, self::$DateTimeView);
        }
    }

    private function userWantLogin()
    {
        return isset($_POST['login']);
        // return self::$LoginView->
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
        echo $credentials->getCookieName();
        echo $credentials->getCookiePassword();
    }
    // TESTFUNKTION, WILL BE DELETED WHEN FINISHED
    private function checkIfPOST()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
}
