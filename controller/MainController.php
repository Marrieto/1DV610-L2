<?php

class MainController {

    private static $LoginController;
    private static $DateTimeView;
    private static $LoginView;
    private static $LayoutView;
    private static $LoginModel;

    public function __construct ($v, $dtv, $lv, $lm) {
        self::$LoginView        = $v;
        self::$DateTimeView     = $dtv;
        self::$LayoutView       = $lv;
        self::$LoginModel       = $lm;
        self::$LoginController  = new LoginController(self::$LoginView, self::$DateTimeView, self::$LayoutView, self::$LoginModel);
    }

    public function render() {
        // Should be handled differently, choose between the different controllers, not only layoutview
        // self::$LayoutView->render(false, self::$LoginView, self::$DateTimeView);
        self::$LoginController->render();
    }

    // Choose view depending on how the POST looks like, choose between the loginview m.m.
    // private function ChooseView () {
    // }

    // private function checkIfLoggedIn () {
    //     if ( isset($_POST['LoginView::Login']))
    // }

}