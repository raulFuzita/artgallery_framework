<?php

/*
 * TABLE OF RETURNS
 * 
 * User inexistent: usererror=userinexistent
 * User exist: usererror=userexist
 * Inexistent field: required=emptyfield
 * Password and Confirm password don't match: passworderror=nomatch
 * SQL problem or no valid values: fatalerror=sqlproblem&novalues
 * Data has been updated: update=successfully
 */

namespace App\Controller\User;

use App\Model\User\UserUpdate;

include_once('../../includes/session.php');
include('../../../autoloader.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // session_start();

    $reference = (isset($_POST['userId'])) ? $_POST['userId'] : ""; // Real id

    $firstName = (isset($_POST['first-name'])) ? $_POST['first-name'] : "";
    $lastName = (isset($_POST['last-name'])) ? $_POST['last-name'] : "";
    $username = (isset($_POST['username'])) ? $_POST['username'] : "";
    $email = (isset($_POST['email'])) ? $_POST['email'] : "";
    $password = (isset($_POST['password'])) ? $_POST['password'] : "";
    $confirmPassword = (isset($_POST['confirm-password'])) ? $_POST['confirm-password'] : "";
    $street = (isset($_POST['street'])) ? $_POST['street'] : "";
    $city = (isset($_POST['city'])) ? $_POST['city'] : "";
    $country = (isset($_POST['country'])) ? $_POST['country'] : "";

    $update = new UserUpdate();

    if($update->require_properties($firstName, $username)){

        $update->setID($reference)->
        setFirstName($firstName)->
        setLastName($lastName)->
        setUsername($username)->
        setEmail($email)->
        setPassword($password)->
        setConfirmPassword($confirmPassword)->
        setStreet($street)->
        setCity($city)->
        setCountry($country);

        // echo "<pre>";
        // var_dump($update);
        // echo "</pre>";

        // exit();

        if (!empty($update->password) OR !$update->authenticate()) {
            header("location: ../../../public/edit_admin.php?userId=$reference&passworderror=nomatch");
            exit();
        }

        if (!$update->fetchById()) {
            header("location: ../../../public/edit_admin.php?userId=$reference&usererror=userinexistent");
            exit();
        } else {
            
            if(!$update->hasChanged()){
                header("location: ../../../public/edit_admin.php?userId=$reference&change=nothing");
                exit();
            } else {
                    
                    if(!$update->updateById()){
                        header("location: ../../../public/edit_admin.php?userId=$reference&fatalerror=sqlproblem&novalues");
                        exit();
                    } else {
                        header("location: ../../../public/edit_admin.php?userId=$reference&update=successfully");
                    }

            }
        }

    } else {
        header("location: ../../../public/edit_admin.php?userId=$reference&required=emptyfield");
        exit();
    }
    
} else {
    header("location: ../../../public/edit_admin.php?");
    exit();
}
