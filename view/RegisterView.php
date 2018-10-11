<?php

class RegisterView
{
    // REPLACE WITH POST OBJECT
    // private $register = 'RegisterView::Register';
    // private $username = 'RegisterView::UserName';
    // private $password = 'RegisterView::Password';
    // private $passwordRepeat = 'RegisterView::PasswordRepeat';
    // private $messageId = 'RegisterView::Message';
    private $viewNames;
    private $credentials;
    public function __construct()
    {
        $this->viewNames = new ViewVariables();
        $this->credentials = new Credentials();
        $this->credentials->getCredentials();
    }

    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @return  void BUT writes to standard output and cookies!
     */
    public function returnHtml(StatusMessage $message): string
    {

        $response = "
        <a href='?'>Back to login</a>   
        <div class='container' >
          <h2>Register new user</h2>
          <form action='?register' method='post' enctype='multipart/form-data'>
            <fieldset>
            <legend>Register a new user - Write username and password</legend>
              <p id='" . $this->viewNames->getRMessageId() . "'>" . $message->getMessageString() . "</p>
              <label for='" . $this->viewNames->getRUsername() . "' >Username :</label>
              <input type='text' size='20' name='" . $this->viewNames->getRUsername() . "' id='" . $this->viewNames->getRUsername() . "' value='" . $this->credentials->getUsernameSanitized() . "' />
              <br/>
              <label for='" . $this->viewNames->getRPassword() . "' >Password  :</label>
              <input type='password' size='20' name='" . $this->viewNames->getRPassword() . "' id='" . $this->viewNames->getRPassword() . "' value='" . $this->credentials->getPassword() . "' />
              <br/>
              <label for='" . $this->viewNames->getRPasswordRepeat() . "' >Repeat password  :</label>
              <input type='password' size='20' name='" . $this->viewNames->getRPasswordRepeat() . "' id='" . $this->viewNames->getRPasswordRepeat() . "' value='" . $this->credentials->getPasswordRepeat() . "' />
              <br/>
              <input id='submit' type='submit' name='" . $this->viewNames->getRName() . "'  value='Register' />
              <br/>
            </fieldset>
          </form>
    ";
        return $response;
    }



    // public function getCredentials()
    // {
    //     $username = $this->returnUsernameIfExist();
    //     $password = $this->returnPasswordIfExist();
    //     $passwordRepeat = $this->returnPasswordRepeatIfExist();
    //     $credentials = new Credentials($username, $password, false, "", "", $passwordRepeat, "");
    //     return $credentials;
    // }

    // private function userIsLoggedIn($isLoggedIn)
    // {
    //     return $isLoggedIn == true ? "Logged in" : "Not logged in";
    // }


    // TODO: REPLACE THESE AND PUT IN POST OBJECT
    // private function returnUsernameIfExistSanitized()
    // {
    //     if ((isset($_POST[$this->username]))) {
    //         $sanitizedString = strip_tags($_POST[$this->username]);
    //         return $sanitizedString;
    //     } else {
    //         return "";}
    // }

    // private function returnUsernameIfExist()
    // {
    //     if ((isset($_POST[$this->username]))) {
    //         return $_POST[$this->username];
    //     } else {
    //         return "";}
    // }

    // private function returnPasswordIfExist()
    // {
    //     if ((isset($_POST[$this->password]))) {
    //         return $_POST[$this->password];
    //     } else {
    //         return "";}
    // }

    // private function returnPasswordRepeatIfExist()
    // {
    //     if ((isset($_POST[$this->passwordRepeat]))) {
    //         return $_POST[$this->passwordRepeat];
    //     } else {
    //         return "";}
    // }

}
