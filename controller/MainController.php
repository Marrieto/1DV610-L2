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
            // Check if the register succeded
            echo "henlo";
            //  if not          -> render register with message
            //  if successful   -> render login with message 
        } else if (self::$LayoutView->userWantToRegister())
        {
            self::$RegisterController->register();
        } else {
            self::$LoginController->login();
        }
    }

}