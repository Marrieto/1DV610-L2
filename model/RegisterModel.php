<?php

/*
 * Handle all the data that has  something to do with the login
 */

 // SHOULD BE REPLACED BY A FUNCTION IN THE CREDENTIALS CLASS
function ValidateRegisterInputFormat(Credentials $credentials): ResponseObject
{
    $response = new ResponseObject();
    $username = $credentials->getUsername();
    $password = $credentials->getPassword();
    $passwordRepeat = $credentials->getPasswordRepeat();

    $response->setWasSuccessful(true);
    $response->setMessage("Registered new user.");

    if (!passwordsMatch($password, $passwordRepeat)) {
        $response->setWasSuccessful(false);
        $response->setMessage("Passwords do not match.");
    }
    if (!passwordIsLongEnough($password)) {
        $response->setWasSuccessful(false);
        $response->setMessage("Password has too few characters, at least 6 characters.");
    }
    if (!usernameIsLongEnough($username)) {
        $response->setWasSuccessful(false);
        $response->setMessage("Username has too few characters, at least 3 characters.");
    }
    if (!passwordIsLongEnough($password) && !usernameIsLongEnough($username)) {
        $response->setWasSuccessful(false);
        $response->setMessage("Username has too few characters, at least 3 characters. Password has too few characters, at least 6 characters.");
    }
    if (!usesValidCharacters($username)) {
        $response->setWasSuccessful(false);
        $response->setMessage("Username contains invalid characters.");
    }

    return $response;
}

function usernameIsLongEnough($username): bool
{
    return strlen($username) > 2;
}

function passwordIsLongEnough($password): bool
{
    return strlen($password) > 5;
}

function passwordsMatch($password1, $password2): bool
{
    return $password1 == $password2;
}

function usesValidCharacters($word): bool
{
    $sanitizedString = str_replace(array("<", ">"), "", $word);

    return $sanitizedString == $word;
}
