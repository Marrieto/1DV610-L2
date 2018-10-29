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

    public function render(StatusMessage $statusFromMain): void
    {
        $statusMessage = new StatusMessage();
        $statusMessage->setMessageState($this->Session->checkIfLoggedInBySession());
        $statusMessage->setMessageString($statusFromMain->getMessageString());

        $html = $this->RegisterView->returnHTML($statusMessage);
        $this->LayoutView->render($statusMessage, $html);
    }

    public function userTriedToRegister(): StatusMessage
    {
        $response = new StatusMessage();
        $response->setMessageState(true);
        $response->setMessageString('Registered new user.');
        $this->Credentials->fetchCredentials();
        
        try 
        {
            $this->validateUsernameAndPasswordFormat($this->Credentials);
            $this->Database->addUser($this->Credentials);
        }
        catch (Exception $e)
        {
            $response->setMessageState(false);
            $response->setMessageString($e->getMessage());
        }

        return $response;
    }
    
    private function validateUsernameAndPasswordFormat(Credentials $credentials): void
    {
        $username = $credentials->getUsername();
        $password = $credentials->getPassword();
        $passwordRepeat = $credentials->getPasswordRepeat();

        $testCredentials = new RegisterCredentials($username, $password, $passwordRepeat);
    }
}
