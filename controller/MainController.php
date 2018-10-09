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
    }

    public function render()
    {
        // Check if there was a POST to register
        $triedToRegister = $this->RegisterView->userTriedToRegister();
        if ($triedToRegister) {
            $credentials = $this->RegisterView->getCredentials();
            $validRegistrationResponse = ValidateRegisterInputFormat($credentials);

            // CHECK IF USER ALREADY EXIST
            if ($validRegistrationResponse->getMessageState()) {
                $response = $this->Database->checkIfUserExist($credentials);
                if ($response) {
                    $validRegistrationResponse->setMessageString("User exists, pick another username.");
                    $validRegistrationResponse->setMessageState(false);
                }
            }

            // If username and password has correct input
            if ($validRegistrationResponse->getMessageState()) {

                $credentials->setStatusMessage($validRegistrationResponse->getMessageString());
                // If credentials is true, then set session username and pass
                // and save to database
                if ($credentials->getStatusMessage()) {
                    $this->LoginView->setSessionUsername($credentials->getUsername());
                    $this->LoginView->setSessionPassword($credentials->getPassword());

                    if (!$this->Database->addUser($credentials)) {
                        echo "Error saving user to database, check Database.php";
                    }
                }

                $this->LoginController->login($validRegistrationResponse->getMessageString());
            } else {
                $this->RegisterController->register($validRegistrationResponse);
            }

        } else if ($this->LayoutView->userWantToRegister()) {
            $this->RegisterController->register(new StatusMessage());
        } else {
            $this->LoginController->login("");
        }
    }

}
