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
		$response = $this->generateLoginFormHTML($msg->getMessageString());
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
	// Ny strategi - Hämta pw och username i ett credentials-objekt, utvärdera i controllern
	public function getCredentials () {
		$username = $this->returnUsernameIfExist();
		$password = $this->returnPasswordIfExist();
		$keepLoggedIn = false;

		return new Credentials($username, $password, $keepLoggedIn);
	}

	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function usernameExist () {
		return (isset($_POST[self::$name]) && !empty($_POST[self::$name]));
	}

	private function passwordExist () {
		 return (isset($_POST[self::$password]) && !empty($_POST[self::$password]));
	}

	private function returnUsername () {
		return $_POST[self::$name];
	}

	private function returnPassword () {
		return $_POST[self::$password];
	}

	private function returnUsernameIfExist () {
		if ($this->usernameExist()) {
			return $this->returnUsername();
		} else {
			 return '';
			}
	}

	private function returnPasswordIfExist () {
		if ($this->passwordExist()) {
			return $this->returnPassword();
		} else {
			 return '';
			}
	}


	
}