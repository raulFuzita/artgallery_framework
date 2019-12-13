<?php

namespace App\Controller\User;

use App\Classes\User\FieldTable;
use App\Model\User\UserLoadSettings;

include('../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;

    if($_SESSION['permission'] == $admin){

        $userId = (isset($_GET['userId'])) ? $_GET['userId'] : false;

        if (!empty($userId)) {
        
            $account = new UserLoadSettings("");
            $account->setID($userId);
            $account->fetchById();
        } 
    }
}
