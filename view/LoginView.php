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

	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function response(StatusMessage $msg) {


		// TODO: If msg->getmessagestatus() == true { geberatelogoutbtn } else generateloginform
		if ($msg->getMessageState()) {
			$response = $this->generateLogoutButtonHTML($msg->getMessageString());
		} else {
			$response = $this->generateLoginFormHTML($msg->getMessageString());
		}
		
		//$response .= $this->generateLogoutButtonHTML($message);

		return $response;
	}

	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
	private function generateLogoutButtonHTML($message) {
		return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message .'</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
	}
	
	/**
	* Generate HTML code on the output buffer for the logout button
	* @param $message, String output message
	* @return  void, BUT writes to standard output!
	*/
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

	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function usernameExist () {
		return (isset($_POST[self::$name]) && !empty($_POST[self::$name]));
	}

	private function returnUsername () {
		return $_POST[self::$name];
	}

	private function returnUsernameIfExist () {
		if ($this->usernameExist()) {
			return $this->returnUsername();
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
		} else {
			 return '';
			}
	}


	
}