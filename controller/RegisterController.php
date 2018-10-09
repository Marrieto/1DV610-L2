<?php

class RegisterController
{

    private static $DateTimeView;
    private static $RegisterView;
    private static $LoginModel;

    public function __construct($rv, $dtv, $lm)
    {
        self::$RegisterView = $rv;
        self::$DateTimeView = $dtv;
        self::$LoginModel = $lm;
    }

    public function register(StatusMessage $message)
    {
        $statusMessage = new StatusMessage();
        $statusMessage->setMessageState(self::$LoginModel->checkIfLoggedInBySession());
        $statusMessage->setMessageString($message->getMessageString());

        self::$RegisterView->render($statusMessage, self::$DateTimeView);
    }

    private function userWantLogin()
    {
        return isset($_POST['login']);
    }

    private function userWantLogout()
    {
        return isset($_POST['logout']);
    }

    private function checkIfPOST()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
}
