<?php

namespace App\Controller\User;

use App\Model\User\UserLoadSettings;

include('../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged'])) {
    
    $username = (isset($_SESSION['username'])) ? $_SESSION['username'] : false;

    if (!empty($username)) {
        
        $account = new UserLoadSettings($username);
        $account->verifyUser();
    } 
    
}
