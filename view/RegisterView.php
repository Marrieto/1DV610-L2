<?php

class RegisterView {

  // private static $login = 'LoginView::Login';
	// private static $logout = 'LoginView::Logout';
	// private static $name = 'LoginView::UserName';
	// private static $password = 'LoginView::Password';
	// private static $cookieName = 'LoginView::CookieName';
	// private static $cookiePassword = 'LoginView::CookiePassword';
	// private static $keep = 'LoginView::KeepMeLoggedIn';
  // private static $messageId = 'LoginView::Message';	
  
  private static $username = 'RegisterView::UserName';
  private static $password = 'RegisterView::Password';
  private static $passwordRepeat = 'RegisterView::PasswordRepeat';
  private static $messageId = 'RegisterView::Message';


	/**
	 * Create HTTP response
	 *
	 * Should be called after a login attempt has been determined
	 *
	 * @return  void BUT writes to standard output and cookies!
	 */
	public function render(StatusMessage $message, $dtv) {

    $response = "
    <!DOCTYPE html>
    <html>
      <head>
        <meta charset='utf-8'>
        <title>Login Example</title>
      </head>
      <body>
        <h1>Assignment 2</h1>
        <a href='?'>Back to login</a><h2>" . $this->userIsLoggedIn($message->getMessageState()) . "</h2>    <div class='container' >
          
          <h2>Register new user</h2>
          <form action='?register' method='post' enctype='multipart/form-data'>
            <fieldset>
            <legend>Register a new user - Write username and password</legend>
              <p id='" . self::$messageId . "'>" . $message->getMessageString() . "</p>
              <label for='" . self::$username . "' >Username :</label>
              <input type='text' size='20' name='" . self::$username . "' id='" . self::$username . "' value='' />
              <br/>
              <label for='" . self::$password . "' >Password  :</label>
              <input type='password' size='20' name='" . self::$password . "' id='" . self::$password . "' value='' />
              <br/>
              <label for='" . self::$passwordRepeat . "' >Repeat password  :</label>
              <input type='password' size='20' name='" . self::$passwordRepeat . "' id='" . self::$passwordRepeat . "' value='' />
              <br/>
              <input id='submit' type='submit' name='DoRegistration'  value='Register' />
              <br/>
            </fieldset>
          </form>" . $dtv->show() . "    </div>
       </body>
    </html>
    ";
		echo $response;
  }

  public function userTriedToRegister()
  {
    if (isset($_POST['DoRegistration'])) {
      return true;
    } else {
      return false;
    }
  }

  private function userIsLoggedIn($isLoggedIn) {
    return $isLoggedIn == true ? "Logged in" : "Not logged in";
  }

}


	
