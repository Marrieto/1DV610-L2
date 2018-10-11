<?php

class ViewVariables
{
    private static $lLogin = 'LoginView::Login';
    private static $lLogout = 'LoginView::Logout';
    private static $lMessageId = 'LoginView::Message';
    private static $messageId = 'LoginView::Message';
    private static $rName = "RegisterView::Register";
    private static $rUsername = 'RegisterView::UserName';
    private static $rPassword = 'RegisterView::Password';
    private static $rMessageId = 'RegisterView::Message';
    private static $username = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $passwordRepeat = 'RegisterView::PasswordRepeat';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';

    public function getRName(): string 
    {
        return self::$rName;
    }
    public function getRUsername(): string 
    {
        return self::$rUsername;
    }
    public function getRPassword(): string 
    {
        return self::$rPassword;
    }
    public function getPasswordRepeat(): string 
    {
        return self::$passwordRepeat;
    }
    public function getRMessageId(): string 
    {
        return self::$rMessageId;
    }
    public function getLLogin(): string 
    {
        return self::$lLogin;
    }
    public function getLLogout(): string 
    {
        return self::$lLogout;
    }
    public function getUsername(): string 
    {
        return self::$username;
    }
    public function getPassword(): string 
    {
        return self::$password;
    }
    public function getCookieName(): string 
    {
        return self::$cookieName;
    }
    public function getCookiePassword(): string 
    {
        return self::$cookiePassword;
    }
    public function getKeep(): string 
    {
        return self::$keep;
    }
    public function getMessageId(): string 
    {
        return self::$messageId;
    }
}