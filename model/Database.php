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
            echo "Failed to connect to MYSQL: " . mysqli_connect_error(); // remove echo
            return false;
        } else {
            return true;
        }
    }

    private function initDB()
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

    public function addUser(Credentials $credentials): bool
    {
        $hashedPassword = password_hash($credentials->getPassword(), PASSWORD_BCRYPT);

        $qry = "INSERT INTO user (username, password, cookiestring)
    VALUES ('" . $credentials->getUsername() . "', '" . $hashedPassword . "', '" . $credentials->getCookieString() . "')";

        if ($this->Connection->query($qry) == true) {
            return true;
        } else {
            return false;
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

    public function getNotes(string $username)
    {
        $noteArray = array();
        
        if (!empty($username))
        {
            //$qry = "SELECT notestring FROM notes WHERE username=?";
            $qry = "SELECT notestring, id FROM notes WHERE username=?";
            $prepared = $this->Connection->prepare($qry);

            $prepared->bind_param("s", $username);
            $prepared->execute();
            // $prepared->store_result();
            //$prepared->bind_result($resultString);
            $prepared->bind_result($resultString, $resultId);

            
            //var_dump($resultId);

            // $noteArray = array();

            while ($prepared->fetch())
            {
                $note = new Note("test", "test", 0);
                $note->username = $username;
                $note->content = $resultString;
                $note->id = $resultId;
                // var_dump($resultString);
                // var_dump($username);
                // var_dump($resultId);
                // $resultNote = new Note($username, $resultString, $resultId);
                array_push($noteArray, $note);
            }
            // var_dump($noteArray);

            return $noteArray;
        } 
        else
        {
            return $noteArray;
        }
        
    }

    public function addNote(string $content, string $username): bool
    {
        $qry = "INSERT INTO notes (username, notestring)
        VALUES ('" . $username . "',  '" . $content . "')";

        if ($this->Connection->query($qry) == true) {
            return true;
        } else {
            return false;
        }
    }
    
    public function removeNote(int $idToBeRemoved): bool
    {
        $qry = "DELETE FROM `Users`.`notes` WHERE `notes`.`id` =" . $idToBeRemoved;
        // $qry = "DELETE FROM notes * WHERE id=" . $idToBeRemoved;
        // var_dump($qry);

        if ($this->Connection->query($qry) == true) {
            return true;
        } else {
            return false;
        }
    }

}
