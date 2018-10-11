<?php

class LoginController
{
    private $Session;
    private $POST;
    private $credentials;
    private $cookies;

    public function __construct($v, $dtv, $lv, $lm)
    {
        $this->LoginView = $v;
        $this->DateTimeView = $dtv;
        $this->LayoutView = $lv;
        $this->LoginModel = $lm;
        $this->session = new Session();
        $this->POST = new POST();
        $this->credentials = new Credentials();
        $this->cookies = new Cookies();
        session_start();
    }

    public function render(StatusMessage $statusFromMain)
    {
        // Get credentials
        $this->credentials->getCredentials();
        // Check if logged in
        $response = $this->checkIfLoggedIn();
        if ($statusFromMain->getMessageString() != "")
        {
            $response->setMessageString($statusFromMain->getMessageString());
        }
        // get html from loginview
        $html = $this->LoginView->returnHTML($response);
        // render through layoutview
        $this->LayoutView->render($response, $html);
    }

    private function checkIfLoggedIn()
    {
        $response = new StatusMessage();
        // Check if logged in by session
        if ($this->session->checkIfLoggedInBySession())
        {
            $response->setMessageState(true);
        }

        if (!$response->getMessageState() && $this->cookies->checkIfLoggedInByCookies($this->credentials))
        {
            $response->setMessageState(true);
            $response->setMessageString("Welcome back with cookie");
        }
        return $response;
    }

    public function login()
    {
        $this->session->login();
        $this->cookies->setCookieUsername($this->credentials->getUsername());
        $this->cookies->setCookiePassword($this->credentials->getPassword());
    }
    public function logout()
    {
        $this->session->logout();
        $this->cookies->removeCookies();
    }

    public function userTriedToLogin()
    {
        $response = new StatusMessage();
        $this->credentials->getCredentials();

        $response = $this->credentials->validateCredentialFormat();

        if ($response->getMessageState())
        {
            $response = $this->LoginModel->validateCredentialsToDB($this->credentials);

            if ($response->getMessageState() && !$this->session->checkIfLoggedinBySession())
            {
                $response->setMessageString("Welcome");
                $response->setMessageState(true);
            }
        }

        return $response;
    }
    // Check if loggedin
    // User want to Logout -> SetMessage accordingly
    // User want to Login -> SetMessage accordingly

    public function loginn($credentialsFromMainController)
    {
        
        // Ask view if someone wants to log in;
        $this->credentials->getCredentials();
        $response = new StatusMessage();
        $response->setMessageState(false);

        //Check if user already logged in - Checking session and cookies
        // TODO: REPLACE WITH checkIfLoggedInByCookiesOrSession
        if ($this->Session->checkIfLoggedIn()) {
            $response->setMessageState(true);
            $response->setMessageString("");
        }

        // Check if logged in by cookie
        if (!$response->getMessageState() && $this->cookies->checkIfLoggedInByCookies($this->credentials)) {
            $this->Session->login();
            $response->setMessageState(true);
            $response->setMessageString("Welcome back with cookie");
        }

        if ($this->POST->requestMethodIsPOST()) {
            // CHECK IF ALREADY LOGGED IN -> RESPONSE SHOULD ALREADY BE 'TRUE'
            if ($this->POST->userWantToLogin()) {
                $response = $this->credentials->validateCredentialFormat();
                //// SWAPPED THIS LINE BELOW, checks if he's already logged in
                if ($response->getMessageState()) {
                    // Query the db to see if it was correct
                    $response = $this->LoginModel->validateCredentialsToDB($this->credentials);

                    // USER WANT TO LOG IN, WITH RIGHT CREDENTIALS
                    if ($response->getMessageState()) {
                        if (!$this->Session->checkIfLoggedIn()) {
                            $this->Session->login();
                            $response->setMessageString('Welcome');
                        }
                    }
                }
                $this->LayoutView->render($response, $this->LoginView, $this->DateTimeView);
                // HANDLE LOGOUT && self::$LoginModel->checkIfLoggedIn())
            } else if ($this->POST->userWantToLogout()) {
                // Only log out with 'Bye bye!' if the user was logged in
                if ($this->Session->checkIfLoggedIn()) {
                    $this->Session->logout();
                    $response->setMessageState(false);
                    $response->setMessageString("Bye bye!");
                }
                $this->LayoutView->render($response, $this->LoginView, $this->DateTimeView);
            } else {
                // When one successfully register
                $response->setMessageString($credentialsFromMainController);
                $this->LayoutView->render($response, $this->LoginView, $this->DateTimeView);
            }
        } else {
            $this->LayoutView->render($response, $this->LoginView, $this->DateTimeView);
        }
    }
}
