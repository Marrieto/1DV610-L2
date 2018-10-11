<?php

class MainController
{

    private $LoginController;
    private $DateTimeView;
    private $LoginView;
    private $RegisterView;
    private $RegisterController;
    private $LayoutView;
    private $LoginModel;
    private $Database;
    private $Config;
    private $GET;
    private $POST;
    private $credentials;
    private $session;

    public function __construct($v, $dtv, $lv, $lm, $rv)
    {
        $this->LoginView = $v;
        $this->DateTimeView = $dtv;
        $this->LayoutView = $lv;
        $this->LoginModel = $lm;
        $this->RegisterView = $rv;
        $this->Config = new Config();
        $this->Database = new Database($this->Config);
        $this->LoginController = new LoginController($this->LoginView, $this->DateTimeView, $this->LayoutView, $this->LoginModel);
        $this->RegisterController = new RegisterController($this->LoginView, $this->LayoutView, $this->RegisterView, $this->DateTimeView, $this->LoginModel);
        $this->POST = new POST();
        $this->GET = new GET();
        $this->credentials = new Credentials();
        $this->session = new Session();
    }

    public function render()
    {
        // Check if user tried to register
        // Check if user tried to login
        // Check if user wants to register
        // else
        if ($this->POST->userTriedToRegister())
        {
            // Check for response, if it failed, show register, else login
            $response = $this->RegisterController->userTriedToRegister();

            if($response->getMessageState())
            {
                $this->LoginController->render($response);
            } 
            else
            {
                $this->RegisterController->render($response);
            }
        } 
        else if ($this->POST->userTriedToLogin())
        {
            // Check for response, send response to render
            $response = $this->LoginController->userTriedToLogin();

            if ($response->getMessageState())
            {
                $this->LoginController->Login();
            }

            $this->LoginController->render($response);
        }
        else if ($this->POST->userTriedToLogout())
        {
            $logoutStatus = new StatusMessage();

            if ($this->session->checkIfLoggedInBySession())
            {
                $logoutStatus->setMessageString("Bye bye!");
                $this->LoginController->logout();
            }

            $this->LoginController->render($logoutStatus);
        }
        else if ($this->GET->userWantToRegister())
        {
            $emptyStatus = new StatusMessage();
            $this->RegisterController->render($emptyStatus);
        }
        else
        {
            $emptyStatus = new StatusMessage();
            $this->LoginController->render($emptyStatus);
            // Get html from loginview without parameters (should never be)
        }
        // Check if there was a POST to register
        // $triedToRegister = $this->POST->userTriedToRegister();

        // if ($triedToRegister) {
        //     $this->credentials->getCredentials();
        //     $validRegistrationResponse = ValidateRegisterInputFormat($this->credentials);

        //     // CHECK IF USER ALREADY EXIST
        //     if ($validRegistrationResponse->getMessageState()) {
        //         $response = $this->Database->checkIfUserExist($this->credentials);
        //         if ($response) {
        //             $validRegistrationResponse->setMessageString("User exists, pick another username.");
        //             $validRegistrationResponse->setMessageState(false);
        //         }
        //     }

        //     // If username and password has correct input
        //     if ($validRegistrationResponse->getMessageState()) {

        //         $this->credentials->setStatusMessage($validRegistrationResponse->getMessageString());
        //         // If credentials is true, then set session username and pass
        //         // and save to database
        //         if ($this->credentials->getStatusMessage()) {
        //             $this->session->setUsername($this->credentials->getUsername());
        //             $this->session->setUsername($this->credentials->getPassword());

        //             if (!$this->Database->addUser($this->credentials)) {
        //                 echo "Error saving user to database, check Database.php";
        //             }
        //         }

        //         $this->LoginController->login($validRegistrationResponse->getMessageString());
        //     } else {
        //         $this->RegisterController->register($validRegistrationResponse);
        //     }

        // } else if ($this->GET->userWantToRegister()) {
        //     $this->RegisterController->register(new StatusMessage());
        // } else {
        //     $this->LoginController->login("");
        // }
    }

    private function login(Credentials $credentials)
    {
        $this->session->login();

        // Set cookies
    }

}
