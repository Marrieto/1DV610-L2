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
	public function response() {
		$message = '';

		// Check if 
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (!$this->passwordExist()) {
				$message = "Enter a password!";
			}
			if (!$this->usernameExist()) {
				$message = "Enter a username!";
			}
		}
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
					<input type="text" id="' . self::$name . '" name="' . self::$name . '" value="" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />
					
					<input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
	}
	
	//CREATE GET-FUNCTIONS TO FETCH REQUEST VARIABLES
	private function usernameExist () {
		return (!empty($_POST[self::$name]));
		// return isset($_POST[self::$name]);
	}

	private function passwordExist () {
		 return (!empty($_POST[self::$password]));
		// return isset($_POST[self::$password]);
	}

	// getRequestPassword TODO

	// Return true if the user has pressed 'Send'
	// private function usernameExists () {
	// 	if (isset($_POST[self::$name])) {
	// 		if ($_POST[self::$name] == "") {
	// 			// self::$messageId;
	// 		}
	// 	}

	// 		// if ($_POST[self::$name] != "") {
	// 		// 	echo $_POST[self::$name];
	// 		// }   
	// 	}
	
}