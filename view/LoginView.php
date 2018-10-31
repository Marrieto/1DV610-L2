<?php

class LoginView
{
    private $viewNames;
    private $credentials;

    public function __construct()
    {
        $this->viewNames = new ViewVariables();
        $this->credentials = new Credentials();
        $this->credentials->fetchCredentials();
    }

    public function returnHTML(ResponseObject $msg, array $notes): string
    {
        if ($msg->wasSuccessful()) {
            $responseHTML = $this->generateLogoutButtonHTML($msg->getMessage());
            $responseHTML .= $this->generateNotes($notes);

        } else {
            $responseHTML = $this->generateLoginFormHTML($msg->getMessage());
        }
        return $responseHTML;
    }

    private function generateLogoutButtonHTML($message): string
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

    private function generateLoginFormHTML($message): string
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

    private function generateNotes(array $notes): string
    {
        $returningHTML = '
        <br>
            <form method="post" >
                    <textarea type="text" id="' . $this->viewNames->getAddNoteContent() . '" name="' . $this->viewNames->getAddNoteContent() . '" placeholder="Note content. Maximum 500 characters."></textarea>
                    <input type="submit" name="' . $this->viewNames->getAddNote() . '" value="Add note" />
            </form>
        <br>
            <form method="post" >
                <input type="text" id="' . $this->viewNames->getRemoveNoteId() . '" name="' . $this->viewNames->getRemoveNoteId() . '" placeholder="Note id to delete" maxlength="4"/>
                <input type="submit" name="' . $this->viewNames->getRemoveNote() . '" value="Remove note with id" />
            </form>
        <br>
        Notes are listed down below:  <br>';

        foreach ($notes as $note => $value) {
            $returningHTML .= '| ID: ' . $value->id . ' | ' . $value->content . '<br>';
        }
        return $returningHTML;
    }

}
