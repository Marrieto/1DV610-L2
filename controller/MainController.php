<?php

class MainController {

    private static $LoginController;
    private static $DateTimeView;
    private static $LoginView;
    private static $RegisterView;
    private static $RegisterController;
    private static $LayoutView;
    private static $LoginModel;

    public function __construct ($v, $dtv, $lv, $lm, $rv) {
        self::$LoginView        = $v;
        self::$DateTimeView     = $dtv;
        self::$LayoutView       = $lv;
        self::$LoginModel       = $lm;
        self::$RegisterView     = $rv;
        self::$LoginController  = new LoginController(self::$LoginView, self::$DateTimeView, self::$LayoutView, self::$LoginModel);
        self::$RegisterController   = new RegisterController(self::$RegisterView, self::$DateTimeView, self::$LoginModel);
    }

    public function render() {

        // Check if there was a POST to register
        $triedToRegister = self::$RegisterView->userTriedToRegister();
        if ($triedToRegister)
        {
            $credentials = self::$RegisterView->getCredentials();
            $validRegistrationResponse = ValidateRegisterInputFormat($credentials);
            // Also check the db if it already exist

            if ($validRegistrationResponse->getMessageState())
            {
                // TEMPORARY SOLUTION, should rewrite and use only credentials+statusmessage object
                $credentials->setStatusMessage($validRegistrationResponse->getMessageString());
                // TEMPORARY SOLUTION

                self::$LoginController->login($validRegistrationResponse->getMessageString());
                //echo 'helo';
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