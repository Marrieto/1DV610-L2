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
        $statusMessage = new StatusMessage();
        $statusMessage->setMessageState($this->Session->checkIfLoggedIn());
        $statusMessage->setMessageString($message->getMessageString());

        $this->RegisterView->render($statusMessage, $this->DateTimeView);
    }
}
