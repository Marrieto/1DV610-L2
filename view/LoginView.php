<?php

class LoginView {
	private static $login = 'LoginView::Login';
	private static $logout = 'LoginView::Logout';
	private static $name = 'LoginView::UserName';
	private static $password = 'LoginView::Password';
	private static $cookieName = 'LoginView::CookieName';
	private static $cookiePassword = 'LoginView::CookiePassword';
	private static $keep = 'LoginView::KeepMeLoggedIn';
	private static $messageId = 'LoginView::Message';	

	public function response(StatusMessage $msg) {
		if ($msg->getMessageState()) {
			$response = $this->generateLogoutButtonHTML($msg->getMessageString());
		} else {
			$response = $this->generateLoginFormHTML($msg->getMessageString());
		}
		return $response;
	}

	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	private function generateLoginFormHTML($message) {
		return '
			<form method="post" > 
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>
					
					<label for="' . self::$name . '">Username :</label>
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $this->returnUsernameIfExist() . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}

	public function getCredentials () {
		$username 			= $this->returnUsernameIfExist();
		$password 			= $this->returnPasswordIfExist();
		$keepLoggedIn 	= $this->returnKeepLoggedInIfExist();
		$cookieName			= $this->returnCookieNameIfExist();
		$cookiePassword	= $this->returnCookiePasswordIfExist();

		return new Credentials($username, $password, $keepLoggedIn, $cookieName, $cookiePassword, "", "");
	}

	public function userWantLogin (): bool {
		return isset($_POST[self::$login]);
	}

	public function userWantLogout () {
		return isset($_POST[self::$logout]);
	}

	public function setSessionUsername (string $name) {
		$_SESSION[self::$name] = $name;
	}

	public function setSessionPassword (string $password) {
		$_SESSION[self::$password] = $password;
	}

	private function usernameExistInPOST () {
		return isset($_POST[self::$name]);
	}

	private function returnUsernameInPOST () {
		return $_POST[self::$name];
	}
	private function usernameExistInSession () {
		return isset($_SESSION[self::$name]);
	}

	private function returnUsernameInSession () {
		return $_SESSION[self::$name];
	}

	private function returnUsernameIfExist () {
		if ($this->usernameExistInPOST()) {
			return $this->returnUsernameInPOST();
		} else if ($this->usernameExistInSession()) {
			return $this->returnUsernameInSession();
		} else {
			 return '';
		}
	}

	private function cookieNameExist() {
		return isset($_COOKIE[self::$cookieName]);
	}

	private function returnCookieName() {
		return $_COOKIE[self::$cookieName];
	}

	private function returnCookieNameIfExist() {
		if ($this->cookieNameExist()) {
			return $this->returnCookieName();
		} else {
			return "";
		}
	}

	private function cookiePasswordExist() {
		return isset($_COOKIE[self::$cookiePassword]);
	}

	private function returncookiePassword() {
		return $_COOKIE[self::$cookiePassword];
	}

	private function returncookiePasswordIfExist() {
		if ($this->cookiePasswordExist()) {
			return $this->returncookiePassword();
		} else {
			return "";
		}
	}

	private function keepLoggedInExist() {
		return (isset($_POST[self::$keep]) && !empty($_POST[self::$keep]));
	}

	private function returnKeepLoggedInIfExist() {
		if ($this->keepLoggedInExist()) {
			if ($_POST[self::$keep] == true ) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	private function passwordExist () {
		 return (isset($_POST[self::$password]) && !empty($_POST[self::$password]));
	}

	private function returnPassword () {
		return $_POST[self::$password];
	}

	private function returnPasswordIfExist () {
		if ($this->passwordExist()) {
			return $this->returnPassword();
		} else if (isset($_SESSION['password']))
		{
			return $_SESSION['password'];
		} else {
			 return '';
			}
	}


	
}