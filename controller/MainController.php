<?php

class MainController
{

    private $LoginController;
    private $DateTimeView;
    private $LoginView;
    private $RegisterView;
    private $RegisterController;
    private $LayoutView;
    private $LoginModel;
    private $Database;
    private $Config;
    private $GET;
    private $POST;
    private $credentials;
    private $session;

    public function __construct($v, $dtv, $lv, $lm, $rv)
    {
        $this->LoginView = $v;
        $this->DateTimeView = $dtv;
        $this->LayoutView = $lv;
        $this->LoginModel = $lm;
        $this->RegisterView = $rv;

        $this->Config = new Config();
        $this->Database = new Database($this->Config);
        $this->LoginController = new LoginController($this->LoginView, $this->LayoutView, $this->LoginModel);
        $this->RegisterController = new RegisterController($this->LayoutView, $this->RegisterView);
        $this->POST = new POST();
        $this->GET = new GET();
        $this->credentials = new Credentials();
        $this->session = new Session();
    }

    public function render(): void
    {
        if ($this->POST->userTriedToRegister())
        {
           
            $response = $this->RegisterController->userTriedToRegister();

            if($response->wasSuccessful())
            {
                $this->LoginController->render($response);
            } 
            else
            {
                $this->RegisterController->render($response);
            }
        } 
        else if ($this->POST->userTriedToLogin())
        {
            $response = $this->LoginController->tryToLogin();

            $this->LoginController->render($response);
        }
        else if ($this->POST->userTriedToLogout())
        {
            $response = $this->LoginController->tryToLogout();

            $this->LoginController->render($response);
        }
        else if ($this->GET->userWantToRegister())
        {
            $emptyResponse = new ResponseObject();

            $this->RegisterController->render($emptyResponse);
        }
        else if ($this->POST->userWantsToAddOrRemoveNote())
        {
            $response = $this->LoginController->removeOrAddNote();

            $this->LoginController->render($response);
        }
        else
        {
            $emptyResponse = new ResponseObject();
            $this->LoginController->render($emptyResponse);
        }
    }

}
