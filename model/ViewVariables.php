<?php

class ViewVariables
{
    private static $rName = "RegisterView::Register";
    private static $rUsername = 'RegisterView::UserName';
    private static $rPassword = 'RegisterView::Password';
    private static $rPasswordRepeat = 'RegisterView::PasswordRepeat';
    private static $rMessageId = 'RegisterView::Message';

    private static $lLogin = 'LoginView::Login';
    private static $lLogout = 'LoginView::Logout';
    private static $lMessageId = 'LoginView::Message';
    private static $lUsername = 'LoginView::UserName';
    private static $lPassword = 'LoginView::Password';
    private static $lKeep = 'LoginView::KeepMeLoggedIn';

    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';

    private static $addNote = "LoginView::AddNote";
    private static $addNoteContent = "LoginView::AddNoteContent";
    private static $removeNote = "LoginView::RemoveNote";

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
    public function getRPasswordRepeat(): string 
    {
        return self::$rPasswordRepeat;
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
    public function getLUsername(): string 
    {
        return self::$lUsername;
    }
    public function getLPassword(): string 
    {
        return self::$lPassword;
    }
    public function getCookieName(): string 
    {
        return self::$cookieName;
    }
    public function getCookiePassword(): string 
    {
        return self::$cookiePassword;
    }
    public function getLKeep(): string 
    {
        return self::$lKeep;
    }
    public function getLMessageId(): string 
    {
        return self::$lMessageId;
    }
    public function getAddNote(): string
    {
        return self::$addNote;
    }
    public function getAddNoteContent(): string
    {
        return self::$addNoteContent;
    }
    public function getRemoveNote(): string
    {
        return self::$removeNote;
    }
}