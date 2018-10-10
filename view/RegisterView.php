<?php

class RegisterView
{
    // REPLACE WITH POST OBJECT
    private $register = 'RegisterView::Register';
    private $username = 'RegisterView::UserName';
    private $password = 'RegisterView::Password';
    private $passwordRepeat = 'RegisterView::PasswordRepeat';
    private $messageId = 'RegisterView::Message';

    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @return  void BUT writes to standard output and cookies!
     */
    public function render(StatusMessage $message, $dtv)
    {

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
              <p id='" . $this->messageId . "'>" . $message->getMessageString() . "</p>
              <label for='" . $this->username . "' >Username :</label>
              <input type='text' size='20' name='" . $this->username . "' id='" . $this->username . "' value='" . $this->returnUsernameIfExistSanitized() . "' />
              <br/>
              <label for='" . $this->password . "' >Password  :</label>
              <input type='password' size='20' name='" . $this->password . "' id='" . $this->password . "' value='" . $this->returnPasswordIfExist() . "' />
              <br/>
              <label for='" . $this->passwordRepeat . "' >Repeat password  :</label>
              <input type='password' size='20' name='" . $this->passwordRepeat . "' id='" . $this->passwordRepeat . "' value='" . $this->returnPasswordRepeatIfExist() . "' />
              <br/>
              <input id='submit' type='submit' name='" . $this->register . "'  value='Register' />
              <br/>
            </fieldset>
          </form>" . $dtv->show() . "    </div>
       </body>
    </html>
    ";
        echo $response;
    }

    // public function userTriedToRegister()
    // {
    //     if (isset($_POST[$this->register])) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }

    public function getCredentials()
    {
        $username = $this->returnUsernameIfExist();
        $password = $this->returnPasswordIfExist();
        $passwordRepeat = $this->returnPasswordRepeatIfExist();
        $credentials = new Credentials($username, $password, false, "", "", $passwordRepeat, "");
        return $credentials;
    }

    private function userIsLoggedIn($isLoggedIn)
    {
        return $isLoggedIn == true ? "Logged in" : "Not logged in";
    }


    // TODO: REPLACE THESE AND PUT IN POST OBJECT
    private function returnUsernameIfExistSanitized()
    {
        if ((isset($_POST[$this->username]))) {
            $sanitizedString = strip_tags($_POST[$this->username]);
            return $sanitizedString;
        } else {
            return "";}
    }

    private function returnUsernameIfExist()
    {
        if ((isset($_POST[$this->username]))) {
            return $_POST[$this->username];
        } else {
            return "";}
    }

    private function returnPasswordIfExist()
    {
        if ((isset($_POST[$this->password]))) {
            return $_POST[$this->password];
        } else {
            return "";}
    }

    private function returnPasswordRepeatIfExist()
    {
        if ((isset($_POST[$this->passwordRepeat]))) {
            return $_POST[$this->passwordRepeat];
        } else {
            return "";}
    }

}
