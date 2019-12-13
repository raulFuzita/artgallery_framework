<?php

/*
 * TABLE OF RETURNS
 * 
 * User exist: usererror=userexist
 * Password entered and password confirmation aren't equal: passworderror=notiqual
 * Failed to create a user: createuser=error
 * User create successfully:  createuser=successfully
 * Required fields: required=emptyfield
 * 
 */

namespace App\Controller\User;

use App\Classes\User\FieldTable;
use App\Model\User\UserSignup;

include('../../../autoloader.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $firstName = (isset($_POST['first-name'])) ? $_POST['first-name'] : "";
    $lastName = (isset($_POST['last-name'])) ? $_POST['last-name'] : "";
    $username = (isset($_POST['username'])) ? $_POST['username'] : "";
    $email = (isset($_POST['email'])) ? $_POST['email'] : "";
    $password = (isset($_POST['password'])) ? $_POST['password'] : "";
    $confirmPassword = (isset($_POST['confirm-password'])) ? $_POST['confirm-password'] : "";

    $signup = new UserSignup();

    $customer = FieldTable::User;

    $signup->setFirstName($firstName)->
        setLastName($lastName)->
        setUsername($username)->
        setEmail($email)->
        setPassword($password)->
        setConfirmPassword($confirmPassword)->
        setPermission($customer);

    if(!$signup->require_properties($firstName, $lastName, $username, $email, $password)){
        header("location: ../../../public/signup.php?required=emptyfield");
        exit();
    } else {

        if ($signup->is_user_available() > 0) {
            header("location: ../../../public/signup.php?usererror=userexist");
            exit();
        } else {
    
            if (!$signup->authenticate()) {
                header("location: ../../../public/signup.php?passworderror=notiqual");
                exit();
            } else {
                
                if (!$signup->addUser()) {
                    header("location: ../../../public/signup.php?createuser=error");
                    exit();
                } else {
                    // **************  USER CREATED SUCCESSFULLY ****************
                    header("location: ../../../public/login.php?createuser=successfully");
                    exit();
                }
                
            }
        } // End available
    }

} else {
    header("location: ../../../public/signup.php");
    exit();
}