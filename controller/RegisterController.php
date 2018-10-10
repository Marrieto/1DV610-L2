<?php

class RegisterController
{

    private $DateTimeView;
    private $RegisterView;
    private $LoginModel;
    private $Session;

    public function __construct($rv, $dtv, $lm)
    {
        $this->RegisterView = $rv;
        $this->DateTimeView = $dtv;
        $this->LoginModel = $lm;
        $this->Session = new Session();
    }

    public function register(StatusMessage $message)
    {
        // session_start();
        $statusMessage = new StatusMessage();
        // $statusMessage->setMessageState($this->LoginModel->checkIfLoggedInBySession());
        $statusMessage->setMessageState($this->Session->checkIfLoggedIn());
        $statusMessage->setMessageString($message->getMessageString());

        $this->RegisterView->render($statusMessage, $this->DateTimeView);
        //var_dump($this->Session->checkIfLoggedIn());
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
