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

    (isset($_POST['first-name'])) ? $_POST['first-name'] : "";
    $firstName = (isset($_POST['first-name'])) ? $_POST['first-name'] : "";
    $lastName = (isset($_POST['last-name'])) ? $_POST['last-name'] : "";
    $username = (isset($_POST['username'])) ? $_POST['username'] : "";
    $email = (isset($_POST['email'])) ? $_POST['email'] : "";
    $password = (isset($_POST['password'])) ? $_POST['password'] : "";
    $confirmPassword = (isset($_POST['confirm-password'])) ? $_POST['confirm-password'] : "";

    $signup = new UserSignup();

    $admin = FieldTable::Admin;

    $signup->setFirstName($firstName)->
        setLastName($lastName)->
        setUsername($username)->
        setEmail($email)->
        setPassword($password)->
        setConfirmPassword($confirmPassword)->
        setPermission($admin);

    if(!$signup->require_properties($firstName, $lastName, $username, $email, $password)){
        header("location: ../../../public/create_admin.php?required=emptyfield");
        exit();
    } else {

        if ($signup->is_user_available() > 0) {
            header("location: ../../../public/create_admin.php?usererror=userexist");
            exit();
        } else {
    
            if (!$signup->authenticate()) {
                header("location: ../../../public/create_admin.php?passworderror=notiqual");
                exit();
            } else {
                
                if (!$signup->addUser()) {
                    header("location: ../../../public/create_admin.php?createadmin=error");
                    exit();
                } else {
                    // **************  USER CREATED SUCCESSFULLY ****************
                    header("location: ../../../public/dashboard.php?createadmin=successfully");
                    exit();
                }
                
            }
        } // End available
    }

} else {
    header("location: ../../../public/create_admin.php");
    exit();
}