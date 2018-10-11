<?php

class RegisterController
{
    private $LoginView;
    private $LayoutView;
    private $DateTimeView;
    private $RegisterView;
    private $LoginModel;
    private $Session;

    public function __construct($v, $lv, $rv, $dtv, $lm)
    {
        $this->LoginView = $v;
        $this->LayoutView = $lv;
        $this->RegisterView = $rv;
        $this->DateTimeView = $dtv;
        $this->LoginModel = $lm;
        $this->Session = new Session();
    }

    public function render(StatusMessage $statusFromMain)
    {
        $statusMessage = new StatusMessage();
        $statusMessage->setMessageState($this->Session->checkIfLoggedInBySession());
        $statusMessage->setMessageString($statusFromMain->getMessageString());

        //$isLoggedIn = $this->Session->checkIfLoggedInBySession();

        // $this->RegisterView->render($statusMessage, $this->DateTimeView);
        $html = $this->RegisterView->returnHTML($statusMessage);
        $this->LayoutView->render($statusMessage, $html);
    }

    public function register(StatusMessage $message)
    {
        $statusMessage = new StatusMessage();
        $statusMessage->setMessageState($this->Session->checkIfLoggedIn());
        $statusMessage->setMessageString($message->getMessageString());

        $this->RegisterView->render($statusMessage, $this->DateTimeView);
    }
}
