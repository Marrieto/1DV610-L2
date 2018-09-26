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
        // $this->Database             = new Database(self::$Config->DBUsername, self::$Config->DBPassword, self::$Config->DBPort, self::$Config->DBHost, self::$Config->DBName);
        self::$LoginController      = new LoginController(self::$LoginView, self::$DateTimeView, self::$LayoutView, self::$LoginModel);
        self::$RegisterController   = new RegisterController(self::$RegisterView, self::$DateTimeView, self::$LoginModel);
    }

    public function render() {
        // echo self::$Config->getDBUsername();
        // Check if there was a POST to register
        $triedToRegister = self::$RegisterView->userTriedToRegister();
        if ($triedToRegister)
        {
            $credentials = self::$RegisterView->getCredentials();
            // CHECK IF INPUT IS FORMATTED CORRECTLY
            $validRegistrationResponse = ValidateRegisterInputFormat($credentials);

            // CHECK IF USER ALREADY EXIST
            if ($validRegistrationResponse->getMessageState())
            {
                $response = $this->Database->checkIfUserExist($credentials);
                if ($response)
                {
                    $validRegistrationResponse->setMessageString("Username already taken.");
                    $validRegistrationResponse->setMessageState(false);
                }
            }
            // $validRegistrationResponse = self::$Database->connect();

            // If username and password has correct input
            if ($validRegistrationResponse->getMessageState())
            {
                
                $credentials->setStatusMessage($validRegistrationResponse->getMessageString());
                // If credentials is true, then set session username and pass
                // and save to database
                if ($credentials->getStatusMessage())
                {
                    $_SESSION["username"] = $credentials->getUsername();
                    $_SESSION["password"] = $credentials->getPassword();

                    if (!$this->Database->addUser($credentials)){
                        echo "Error saving user to database, check Database.php";
                    }
                }
                // TEMPORARY SOLUTION
                // echo $credentials->getStatusMessage();

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