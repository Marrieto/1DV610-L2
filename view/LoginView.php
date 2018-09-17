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
	public function response($isLoggedIn) {
		$message = '';

		// if ($_SESSION[isLoggedIn] != true) {
		// 	// Do login stuff
		// } else {
		// 	// Do logout stuff
		// 	// $this->generateLogoutButtonHTML($message)
		// }

		if (!$isLoggedIn) {
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if (!$this->usernameExist()) {
					$message = "Username is missing";
				} 
				if (!$this->passwordExist()) {
					$message = "Password is missing ";
				} else if ( $this->usernameExist() && $this->passwordExist() ) {
					// Check DB if correct
					// 		If not -> Display wrong name or password
					// 		If was -> generateLogoutButton
				}
			}
		} else {
			
		}

		// Check if there was a POST

		// Check if there's a username and password
		
		$response = $this->generateLoginFormHTML($message);
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