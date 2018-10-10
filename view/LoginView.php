<?php

class LoginView
{
    // Ersätt dessa variabler i session respektive cookies
    // Lägg till en Session objekt i konstruktorn
    // private $login = 'LoginView::Login';
    // private $logout = 'LoginView::Logout';
    // private $name = 'LoginView::UserName';
    // private $password = 'LoginView::Password';
    // private $cookieName = 'LoginView::CookieName';
    // private $cookiePassword = 'LoginView::CookiePassword';
    // private $keep = 'LoginView::KeepMeLoggedIn';
    // private $messageId = 'LoginView::Message';
    private $viewNames;
    public function __construct()
    {
        $this->viewNames = new ViewVariables();
    }

    public function response(StatusMessage $msg)
    {
        if ($msg->getMessageState()) {
            $response = $this->generateLogoutButtonHTML($msg->getMessageString());
        } else {
            $response = $this->generateLoginFormHTML($msg->getMessageString());
        }
        return $response;
    }

    private function generateLogoutButtonHTML($message)
    {
        return '
			<form  method="post" >
				<p id="' . $this->viewNames->getLMessageId() . '">' . $message . '</p>
				<input type="submit" name="' . $this->viewNames->getLLogout() . '" value="logout"/>
			</form>
		';
    }

    private function generateLoginFormHTML($message)
    {
        return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . $this->viewNames->getMessageId() . '">' . $message . '</p>

					<label for="' . $this->viewNames->getUsername() . '">Username :</label>
					<input type="text" id="' . $this->viewNames->getUsername() . '" name="' . $this->viewNames->getLname() . '" value="' . $this->returnUsernameIfExist() . '" />

					<label for="' . $this->viewNames->getPassword() . '">Password :</label>
					<input type="password" id="' . $this->viewNames->getPassword() . '" name="' . $this->viewNames->getPassword() . '" />

					<label for="' . $this->viewNames->getKeep() . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . $this->viewNames->getKeep() . '" name="' . $this->viewNames->getKeep() . '" />

					<input type="submit" name="' . $this->viewNames->getLLogin() . '" value="login" />
				</fieldset>
			</form>
		';
    }

    public function getCredentials()
    {
        $username = $this->returnUsernameIfExist();
        $password = $this->returnPasswordIfExist();
        $keepLoggedIn = $this->returnKeepLoggedInIfExist();
        $cookieName = $this->returnCookieNameIfExist();
        $cookiePassword = $this->returnCookiePasswordIfExist();

        return new Credentials($username, $password, $keepLoggedIn, $cookieName, $cookiePassword, "", "");
    }

    // public function userWantLogin(): bool
    // {
    //     return isset($_POST[$this->login]);
    // }

    // public function userWantLogout()
    // {
    //     return isset($_POST[$this->logout]);
    // }

    public function setSessionUsername(string $name)
    {
        $_SESSION[$this->name] = $name;
    }

    public function setSessionPassword(string $password)
    {
        $_SESSION[$this->password] = $password;
    }

    private function usernameExistInPOST()
    {
        return isset($_POST[$this->name]);
    }

    private function returnUsernameInPOST()
    {
        return $_POST[$this->name];
    }
    private function usernameExistInSession()
    {
        return isset($_SESSION[$this->name]);
    }

    private function returnUsernameInSession()
    {
        return $_SESSION[$this->name];
    }

    private function returnUsernameIfExist()
    {
        if ($this->usernameExistInPOST()) {
            return $this->returnUsernameInPOST();
        } else if ($this->usernameExistInSession()) {
            return $this->returnUsernameInSession();
        } else {
            return '';
        }
    }

    private function cookieNameExist()
    {
        return isset($_COOKIE[$this->cookieName]);
    }

    private function returnCookieName()
    {
        return $_COOKIE[$this->cookieName];
    }

    private function returnCookieNameIfExist()
    {
        if ($this->cookieNameExist()) {
            return $this->returnCookieName();
        } else {
            return "";
        }
    }

    private function cookiePasswordExist()
    {
        return isset($_COOKIE[$this->cookiePassword]);
    }

    private function returncookiePassword()
    {
        return $_COOKIE[$this->cookiePassword];
    }

    private function returncookiePasswordIfExist()
    {
        if ($this->cookiePasswordExist()) {
            return $this->returncookiePassword();
        } else {
            return "";
        }
    }

    private function keepLoggedInExist()
    {
        return (isset($_POST[$this->keep]) && !empty($_POST[$this->keep]));
    }

    private function returnKeepLoggedInIfExist()
    {
        if ($this->keepLoggedInExist()) {
            if ($_POST[$this->keep] == true) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    private function returnPasswordIfExist()
    {
        if ($this->passwordExist()) {
            return $this->returnPassword();
        } else {
            return '';
        }
    }

    private function passwordExist()
    {
        return (isset($_POST[$this->password]) && !empty($_POST[$this->password]));
    }

    private function returnPassword()
    {
        return $_POST[$this->password];
    }

}
