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
        $this->LoginController = new LoginController($this->LoginView, $this->DateTimeView, $this->LayoutView, $this->LoginModel);
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

            if($response->getWasSuccessful())
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
            $response = $this->LoginController->userTriedToLogin();

            if ($response->getWasSuccessful())
            {
                $this->LoginController->Login();
            }

            $this->LoginController->render($response);
        }
        else if ($this->POST->userTriedToLogout())
        {
            $logoutStatus = new ResponseObject();

            if ($this->session->checkIfLoggedInBySession())
            {
                $logoutStatus->setMessage("Bye bye!");
                $this->LoginController->logout();
            }

            $this->LoginController->render($logoutStatus);
        }
        else if ($this->GET->userWantToRegister())
        {
            $emptyStatus = new ResponseObject();
            $this->RegisterController->render($emptyStatus);
        }
        else if ($this->POST->userWantsToAddOrRemoveNote())
        {
            $this->LoginController->removeOrAddNote();
        }
        else
        {
            $emptyStatus = new ResponseObject();
            $this->LoginController->render($emptyStatus);
        }
    }

}
