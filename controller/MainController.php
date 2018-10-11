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
        $this->RegisterController = new RegisterController($this->RegisterView, $this->DateTimeView, $this->LoginModel);
        $this->POST = new POST();
        $this->GET = new GET();
        $this->credentials = new Credentials();
        $this->session = new Session();
    }

    public function render()
    {
        // Check if there was a POST to register
        $triedToRegister = $this->POST->userTriedToRegister();

        if ($triedToRegister) {
            $this->credentials->getCredentials();
            $validRegistrationResponse = ValidateRegisterInputFormat($this->credentials);

            // CHECK IF USER ALREADY EXIST
            if ($validRegistrationResponse->getMessageState()) {
                $response = $this->Database->checkIfUserExist($this->credentials);
                if ($response) {
                    $validRegistrationResponse->setMessageString("User exists, pick another username.");
                    $validRegistrationResponse->setMessageState(false);
                }
            }

            // If username and password has correct input
            if ($validRegistrationResponse->getMessageState()) {

                $this->credentials->setStatusMessage($validRegistrationResponse->getMessageString());
                // If credentials is true, then set session username and pass
                // and save to database
                if ($this->credentials->getStatusMessage()) {
                    $this->session->setUsername($this->credentials->getUsername());
                    $this->session->setUsername($this->credentials->getPassword());

                    if (!$this->Database->addUser($this->credentials)) {
                        echo "Error saving user to database, check Database.php";
                    }
                }

                $this->LoginController->login($validRegistrationResponse->getMessageString());
            } else {
                $this->RegisterController->register($validRegistrationResponse);
            }

        } else if ($this->GET->userWantToRegister()) {
            $this->RegisterController->register(new StatusMessage());
        } else {
            $this->LoginController->login("");
        }
    }

}
