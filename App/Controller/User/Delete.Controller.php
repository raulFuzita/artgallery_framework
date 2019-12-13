<?php

namespace App\Controller\User;

use App\Classes\User\FieldTable;
use App\Model\User\UserDelete;

include_once('../../includes/session.php');
include('../../../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;

    if($_SESSION['permission'] == $admin){

        $id = (isset($_GET['userId'])) ? $_GET['userId'] : 0;

        if(empty($id)){
            header("Location: ../../../public/accounts.php");
        } else {

            $delete = new UserDelete();

            if($delete->setId($id)->deleteRecord() < 0){
                header("Location: ../../../public/accounts.php?usererror=inexistent");
            } else {
                header("Location: ../../../public/accounts.php?delete=successfully");
            }
        }
    }

} else {
    header("location: ../../../public/accounts.php");
    exit();
}