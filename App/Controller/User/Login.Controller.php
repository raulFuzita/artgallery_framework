<?php

/*
 * TABLE OF RETURNS
 * 
 * Inexistent User: usererror=nouser
 * Wrong Password: pwdwrong=password
 */

namespace App\Controller\User;

use App\Classes\User\FieldTable;
use App\Model\User\UserLogin;

include('../../../autoloader.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['credential'];
    $email = $_POST['credential'];
    $password = $_POST['password'];
    
    $login = new UserLogin();

    $login->setUsername($username)->
        setEmail($email)->
        setPassword($password);

    
    if($login->verifyUser()){

        if($login->authenticate()){
            
            $row = $login->getRow();

            session_start();

            $field = new FieldTable();

            $_SESSION['userId'] = $row[$field->id];
            $_SESSION['username'] = $row[$field->username];
            $_SESSION['permission'] = $row[$field->permission];
            $_SESSION['firstName'] = $row[$field->firstName];
            $_SESSION['user-logged'] = true;

            header("Location: ../../../public/dashboard.php?logged-successfully");

        } else {
            header("location: ../../../public/login.php?pwdwrong=password");
            exit();
        }

    } else {
        header("location: ../../../public/login.php?usererror=nouser");
        exit();
    }

} else {
    header("location: ../../../public/login.php");
    exit();
}

