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

}
