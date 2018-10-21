<?php

class GET
{
    public function userWantToRegister(): bool
    {
        if (isset($_GET['register'])) {
            return true;
        } else {
            return false;
        }
    }
}
