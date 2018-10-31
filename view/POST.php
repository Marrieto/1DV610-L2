<?php

class POST
{
    private $viewNames;

    public function __construct()
    {
        $this->viewNames = new ViewVariables();
    }

    public function userTriedToLogin(): bool
    {
        return isset($_POST[$this->viewNames->getLLogin()]);
    }

    public function userTriedToLogout(): bool
    {
        return isset($_POST[$this->viewNames->getLLogout()]);
    }

    public function requestMethodIsPOST(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function userTriedToRegister(): bool
    {
        if (isset($_POST[$this->viewNames->getRName()])) {
            return true;
        } else {
            return false;
        }
    }

    public function getUsernameIfExist(): string
    {
        if (isset($_POST[$this->viewNames->getLUsername()])) 
        {
            return $_POST[$this->viewNames->getLUsername()];
        } else if (isset($_POST[$this->viewNames->getRUsername()]))
        {
            return $_POST[$this->viewNames->getRUsername()];
        }
        else {return "";}
    }
    public function getPasswordIfExist(): string
    {
        if (isset($_POST[$this->viewNames->getLPassword()])) 
        {
            return $_POST[$this->viewNames->getLPassword()];
        } else if (isset($_POST[$this->viewNames->getRPassword()]))
        {
            return $_POST[$this->viewNames->getRPassword()];
        } 
        else {return "";}
    }
    public function getPasswordRepeatIfExist(): string
    {
        if (isset($_POST[$this->viewNames->getRPasswordRepeat()])) {
            return $_POST[$this->viewNames->getRPasswordRepeat()];
        } else {return "";}
    }
    public function getKeepIfExist(): bool
    {
        return (isset($_POST[$this->viewNames->getLKeep()]) && !empty($_POST[$this->viewNames->getLKeep()]));
    }
    public function userWantsToAddOrRemoveNote(): bool
    {
        return $this->userWantsToAddNote() || $this->userWantsToRemoveNote();
    }
    public function userWantsToAddNote()
    {
        return isset($_POST[$this->viewNames->getAddNote()]);
    }
    public function userWantsToRemoveNote(): bool
    {
        return isset($_POST[$this->viewNames->getRemoveNote()]);
    }
    public function getAddNoteContent(): string
    {
        return $_POST[$this->viewNames->getAddNoteContent()];
    }
    public function getRemoveNoteId(): string
    {
        return $_POST[$this->viewNames->getRemoveNoteId()];
    }

}
