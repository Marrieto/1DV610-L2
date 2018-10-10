<?php

class LoginModel
{

    private $db;
    private $cookies;
    private $Session;

    private $cookieName = "Loginview::CookieName";
    private $cookiePassword = "Loginview::CookieName";

    public function __construct()
    {
        $this->cookies = new Cookies();
        $this->db = new Database();
        $this->Session = new Session();
    }

    public function validateCredentialsToDB(Credentials $creds)
    {
        $response = new StatusMessage;
        $tempdb = new Database();

        // TODO Replace this with database
        if ($tempdb->authenticate($creds)) {
            $response->setMessageState(true);
            $response->setMessageString("");
            return $response;
        }

        $response->setMessageState(false);
        $response->setMessageString("Wrong name or password");

        return $response;
    }

    public function login(Credentials $credentials)
    {
        $this->cookies = new Cookies();
        //$_SESSION["loggedin"] = 'true';
        $this->Session->login();
        $username = $credentials->getUsername();
        $this->cookies->setCookie($this->cookieName, $username);

    }

    public function logout(Credentials $credentials)
    {
        $this->cookies = new Cookies();
        // session_destroy();
        $this->Session->logout();
        $this->cookies->removeCookie($this->cookieName);
    }

    // Should have it's own model, sessionmodel?
    public function checkIfLoggedInBySession()
    {
        return $this->Session->checkIfLoggedIn();
        // return isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == 'true';
    }

    public function checkIfLoggedInByCookies(Credentials $credentials)
    {
        $this->cookies = new Cookies();
        // Return a statusmessage object, with outcome and message string if manipulated?
        $username = $credentials->getUsername();
        $cookieName = $this->cookieName;
        $cookieUsername = $this->cookies->getCookie($cookieName);

        if ($username == $cookieUsername && $username != "") {
            return true;
        } else {
            return false;
        }
    }

    // Check if user is logged in either Session or Cookies
    public function checkIfLoggedIn()
    {
        return $this->Session->checkIfLoggedIn();
        // return isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == 'true';
    }

}
