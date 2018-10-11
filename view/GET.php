<?php

class GET
{
    public function userWantToRegister()
    {
        if (isset($_GET['register'])) {
            return true;
        } else {
            return false;
        }
    }
}
