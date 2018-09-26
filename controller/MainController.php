<?php

class MainController {

    private static $LoginController;
    private static $DateTimeView;
    private static $LoginView;
    private static $RegisterView;
    private static $RegisterController;
    private static $LayoutView;
    private static $LoginModel;
    private static $Database;
    private $Config;

    public function __construct ($v, $dtv, $lv, $lm, $rv) {
        self::$LoginView            = $v;
        self::$DateTimeView         = $dtv;
        self::$LayoutView           = $lv;
        self::$LoginModel           = $lm;
        self::$RegisterView         = $rv;
        $this->Config               = new Config();
        self::$Database             = new Database($this->Config->DBUsername, $this->Config->DBPassword, $this->Config->DBPort, $this->Config->DBHost, $this->Config->DBName);
        self::$LoginController      = new LoginController(self::$LoginView, self::$DateTimeView, self::$LayoutView, self::$LoginModel);
        self::$RegisterController   = new RegisterController(self::$RegisterView, self::$DateTimeView, self::$LoginModel);
    }

    public function render() {

        // Check if there was a POST to register
        $triedToRegister = self::$RegisterView->userTriedToRegister();
        if ($triedToRegister)
        {
            $credentials = self::$RegisterView->getCredentials();
            // CHECK IF INPUT IS FORMATTED CORRECTLY
            $validRegistrationResponse = ValidateRegisterInputFormat($credentials);
            // CHECK IF USER ALREADY EXIST
            // $validRegistrationResponse = self::$Database->connect();

            if ($validRegistrationResponse->getMessageState())
            {
                // TEMPORARY SOLUTION, should rewrite and use only credentials+statusmessage object
                // TODO: Change login view to use a more general object with not only a message,
                // but also credentials
                $credentials->setStatusMessage($validRegistrationResponse->getMessageString());
                // If credentials is true, then set session username and pass
                if ($credentials->getStatusMessage())
                {
                    $_SESSION["username"] = $credentials->getUsername();
                    $_SESSION["password"] = $credentials->getPassword();
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