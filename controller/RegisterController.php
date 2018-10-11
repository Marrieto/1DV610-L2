<?php

class RegisterController
{
    private $LoginView;
    private $LayoutView;
    private $DateTimeView;
    private $RegisterView;
    private $Session;
    private $Credentials;
    private $Database;

    public function __construct($v, $lv, $rv, $dtv, $lm)
    {
        $this->LoginView = $v;
        $this->LayoutView = $lv;
        $this->RegisterView = $rv;
        $this->DateTimeView = $dtv;
        $this->Session = new Session();
        $this->Credentials = new Credentials();
        $this->Database = new Database();
    }

    public function render(StatusMessage $statusFromMain)
    {
        $statusMessage = new StatusMessage();
        $statusMessage->setMessageState($this->Session->checkIfLoggedInBySession());
        $statusMessage->setMessageString($statusFromMain->getMessageString());

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

    public function userTriedToRegister()
    {
        $response = new StatusMessage();
        $this->Credentials->getCredentials();

        
        $response = ValidateRegisterInputFormat($this->Credentials);
        
        if ($response->getMessageState())
        {
            $userExist = $this->Database->checkIfUserExist($this->Credentials->getUsername());
            if ($userExist) {
                $response->setMessageString("User exists, pick another username.");
                $response->setMessageState(false);
            }
        }

        if ($response->getMessageState())
        {
            if (!$this->Database->addUser($this->Credentials)) {
                throw new Error("Error saving user to database, check Database.php");
                $response->setMessageString("Error saving user to database, check Database.php");
                $response->setMessageState(false);
            } else {
                $this->Session->setUsername($this->Credentials->getUsername());
            }
        }

        return $response;
    }
}
