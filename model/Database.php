<?php

class Database
{
    private $Config;
    private $Connection;

    public function __construct()
    {
        $this->Config = new Config();
        $this->connect();
        $this->initDB();
    }

    // TAKEN FROM https://www.w3schools.com/php/func_mysqli_connect.asp
    private function connect(): bool
    {
        $this->Connection = mysqli_connect($this->Config->getDBHost(), $this->Config->getDBUsername(), $this->Config->getDBPassword(), $this->Config->getDBName());
        return $this->checkConnection();
    }

    private function checkConnection(): bool
    {
        if (mysqli_connect_errno()) {
            return false;
        } else {
            return true;
        }
    }

    private function initDB(): void
    {
        $this->Connection->query("CREATE TABLE IF NOT EXISTS `user` (
      `cookiestring` varchar(250) default '',
      `username` varchar(250)  NOT NULL,
      `password` varchar(250)  NOT NULL
    );");

    $this->Connection->query("CREATE TABLE IF NOT EXISTS `notes` (
        `id` int NOT NULL AUTO_INCREMENT,
        `notestring` varchar(250) default '',
        `username` varchar(250)  NOT NULL,
        PRIMARY KEY (`id`)
        );");
    }

    public function addUser(Credentials $credentials): void
    {
        if ($this->checkIfUserExist($credentials->getUsername()))
        {
            throw new Exception('User exists, pick another username.');
        }

        $hashedPassword = password_hash($credentials->getPassword(), PASSWORD_BCRYPT);

        $qry = "INSERT INTO user (username, password, cookiestring) VALUES ('" . $credentials->getUsername() . "', '" . $hashedPassword . "', '" . $credentials->getCookieString() . "')";

        if ($this->Connection->query($qry) == false) {
            throw new Exception('Error saving user to database, check Database.php.');
        } 
    }

    public function checkIfUserExist(string $username): bool
    {
        $qry = "SELECT username FROM user WHERE username=?";

        $prepared = $this->Connection->prepare($qry);

        $prepared->bind_param("s", $username);
        $prepared->execute();
        $prepared->bind_result($result);
        $prepared->fetch();

        if ($result == $username) {
            return true;
        } else {
            return false;
        }
    }

    public function authenticate(Credentials $credentials): bool
    {
        $username = $credentials->getUsername();
        $password = $credentials->getPassword();
        $qry = "SELECT username, password FROM user WHERE username=?";

        $prepared = $this->Connection->prepare($qry);
        $prepared->bind_param("s", $username);
        $prepared->execute();
        $prepared->bind_result($dbusername, $dbpassword);
        $prepared->fetch();

        if (password_verify($password, $dbpassword) && $dbusername == $username) {
            return true;
        } else {
            return false;
        }

    }

    public function getNotes(string $username): array
    {
        $noteArray = array();
        
        if (strlen($username) > 0 && !empty($username))
        {
            $qry = "SELECT notestring, id FROM notes WHERE username=?";
            $prepared = $this->Connection->prepare($qry);

            $prepared->bind_param("s", $username);
            $prepared->execute();
            $prepared->bind_result($resultString, $resultId);

            while ($prepared->fetch())
            {
                $note = new Note("test", "test", 0);
                $note->username = $username;
                $note->content = $resultString;
                $note->id = $resultId;
   
                array_push($noteArray, $note);
            }

            return $noteArray;
        } 
        else
        {
            $emptyNote = new Note("", "", 0);
            array_push($noteArray, $emptyNote);
            return $noteArray;
        }
        
    }

    public function addNote(string $content, string $username): void
    {
        $qry = "INSERT INTO notes (username, notestring)
        VALUES ('" . $username . "',  '" . $content . "')";

        if ($this->Connection->query($qry) !== true) 
        {
            throw new Exception('Database error: Could not add note into database');
        }
    }

    public function findNoteUser(int $idToFind): string
    {
        $qry = "SELECT `username` FROM `notes` WHERE `id`=?";
        $prepared = $this->Connection->prepare($qry);
        $prepared->bind_param("i", $idToFind);
        $prepared->execute();

        $prepared->bind_result($resultUser);
        $prepared->fetch();

        if ($resultUser == null)
        {
            $resultUser = "";
        }

        return $resultUser;
    }
    
    public function removeNote(int $idToBeRemoved): void
    {
        $qry = "DELETE FROM `Users`.`notes` WHERE `notes`.`id` =" . $idToBeRemoved;

        if ($this->Connection->query($qry) == null) 
        {
            throw new Exception('Remove note error: no note with that ID found.');
        }

    }

}
