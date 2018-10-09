<?php

class RegisterController
{

    private $DateTimeView;
    private $RegisterView;
    private $LoginModel;

    public function __construct($rv, $dtv, $lm)
    {
        $this->RegisterView = $rv;
        $this->DateTimeView = $dtv;
        $this->LoginModel = $lm;
    }

    public function register(StatusMessage $message)
    {
        $statusMessage = new StatusMessage();
        $statusMessage->setMessageState($this->LoginModel->checkIfLoggedInBySession());
        $statusMessage->setMessageString($message->getMessageString());

        $this->RegisterView->render($statusMessage, $this->DateTimeView);
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
