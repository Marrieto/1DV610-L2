<?php

class RegisterView
{
    private $viewNames;
    private $credentials;

    public function __construct()
    {
        $this->viewNames = new ViewVariables();
        $this->credentials = new Credentials();
        $this->credentials->getCredentials();
    }

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

}
