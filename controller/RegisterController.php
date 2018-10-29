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

    public function __construct($lv, $rv)
    {
        $this->LayoutView = $lv;
        $this->RegisterView = $rv;
        $this->Session = new Session();
        $this->Credentials = new Credentials();
        $this->Database = new Database();
    }

    public function render(ResponseObject $statusFromMain): void
    {
        $ResponseObject = new ResponseObject();
        $ResponseObject->setWasSuccessful($this->Session->checkIfLoggedInBySession());
        $ResponseObject->setMessage($statusFromMain->getMessage());

        $html = $this->RegisterView->returnHTML($ResponseObject);
        $this->LayoutView->render($ResponseObject, $html);
    }

    public function userTriedToRegister(): ResponseObject
    {
        $response = new ResponseObject();
        $response->setWasSuccessful(true);
        $response->setMessage('Registered new user.');
        $this->Credentials->fetchCredentials();
        
        try 
        {
            $this->validateUsernameAndPasswordFormat($this->Credentials);
            $this->Database->addUser($this->Credentials);
        }
        catch (Exception $e)
        {
            $response->setWasSuccessful(false);
            $response->setMessage($e->getMessage());
        }

        return $response;
    }
    
    private function validateUsernameAndPasswordFormat(Credentials $credentials): void
    {
        $username = $credentials->getUsername();
        $password = $credentials->getPassword();
        $passwordRepeat = $credentials->getPasswordRepeat();

        // Throws exception if it's not having correct format
        $testCredentials = new RegisterCredentials($username, $password, $passwordRepeat);
    }
}
