<?php

class MainController {

    private static $LoginController;
    private static $DateTimeView;
    private static $LoginView;
    private static $RegisterView;
    private static $RegisterController;
    private static $LayoutView;
    private static $LoginModel;
    private $Database;
    private static $Config;

    public function __construct ($v, $dtv, $lv, $lm, $rv) {
        self::$LoginView            = $v;
        self::$DateTimeView         = $dtv;
        self::$LayoutView           = $lv;
        self::$LoginModel           = $lm;
        self::$RegisterView         = $rv;
        self::$Config               = new Config();
        $this->Database             = new Database(self::$Config);
        self::$LoginController      = new LoginController(self::$LoginView, self::$DateTimeView, self::$LayoutView, self::$LoginModel);
        self::$RegisterController   = new RegisterController(self::$RegisterView, self::$DateTimeView, self::$LoginModel);
    }

    public function render() {
        // Check if there was a POST to register
        $triedToRegister = self::$RegisterView->userTriedToRegister();
        if ($triedToRegister)
        {
            $credentials = self::$RegisterView->getCredentials();
            $validRegistrationResponse = ValidateRegisterInputFormat($credentials);

            // CHECK IF USER ALREADY EXIST
            if ($validRegistrationResponse->getMessageState())
            {
                $response = $this->Database->checkIfUserExist($credentials);
                if ($response)
                {
                    $validRegistrationResponse->setMessageString("User exists, pick another username.");
                    $validRegistrationResponse->setMessageState(false);
                }
            }

            // If username and password has correct input
            if ($validRegistrationResponse->getMessageState())
            {
                
                $credentials->setStatusMessage($validRegistrationResponse->getMessageString());
                // If credentials is true, then set session username and pass
                // and save to database
                if ($credentials->getStatusMessage())
                {
                    // $_SESSION["username"] = $credentials->getUsername();
                    // $_SESSION["password"] = $credentials->getPassword();
                    self::$LoginView->setSessionUsername($credentials->getUsername());
                    self::$LoginView->setSessionPassword($credentials->getPassword());

                    if (!$this->Database->addUser($credentials)){
                        echo "Error saving user to database, check Database.php";
                    }
                }

                self::$LoginController->login($validRegistrationResponse->getMessageString());
            } else {
                self::$RegisterController->register($validRegistrationResponse);
            }
            
        } else if (self::$LayoutView->userWantToRegister())
        {
            self::$RegisterController->register(new StatusMessage());
        } else {
            self::$LoginController->login("");
        }
    }

}