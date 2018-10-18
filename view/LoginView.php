<?php

class LoginView
{
    private $viewNames;
    private $credentials;

    public function __construct()
    {
        $this->viewNames = new ViewVariables();
        $this->credentials = new Credentials();
        $this->credentials->getCredentials();
    }

    public function returnHTML(StatusMessage $msg, array $notes)
    {
        if ($msg->getMessageState()) {
            $responseHTML = $this->generateLogoutButtonHTML($msg->getMessageString());
            $responseHTML .= $this->generateNotes($notes);

        } else {
            $responseHTML = $this->generateLoginFormHTML($msg->getMessageString());
        }
        return $responseHTML;
    }

    private function generateLogoutButtonHTML($message)
    {
        return '
        <a href="?register">Register a new user</a>
        <div class="container">
			<form  method="post" >
				<p id="' . $this->viewNames->getLMessageId() . '">' . $message . '</p>
				<input type="submit" name="' . $this->viewNames->getLLogout() . '" value="logout"/>
			</form>
		';
    }

    private function generateLoginFormHTML($message)
    {
        return '
        <a href="?register">Register a new user</a>
        <div class="container">
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . $this->viewNames->getLMessageId() . '">' . $message . '</p>

					<label for="' . $this->viewNames->getLUsername() . '">Username :</label>
					<input type="text" id="' . $this->viewNames->getLUsername() . '" name="' . $this->viewNames->getLUsername() . '" value="' . $this->credentials->getUsername() . '" />

					<label for="' . $this->viewNames->getLPassword() . '">Password :</label>
					<input type="password" id="' . $this->viewNames->getLPassword() . '" name="' . $this->viewNames->getLPassword() . '" />

					<label for="' . $this->viewNames->getLKeep() . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . $this->viewNames->getLKeep() . '" name="' . $this->viewNames->getLKeep() . '" />

					<input type="submit" name="' . $this->viewNames->getLLogin() . '" value="login" />
				</fieldset>
			</form>
		';
    }

    private function generateNotes(array $notes)
    {
        $returningHTML = '
        <br>
        <form method="post" >
                <input type="text" id="' . $this->viewNames->getAddNoteContent() . '" name="' . $this->viewNames->getAddNoteContent() . '" placeholder="note content"/>
                <input type="submit" name="' . $this->viewNames->getAddNote() . '" value="addnote" />
        </form>
        <br>
        Notes are listed down below:  <br>';
        foreach ($notes as $note => $value) {
            $returningHTML .= $value . '<br>';
        }
        return $returningHTML;
    }

}
