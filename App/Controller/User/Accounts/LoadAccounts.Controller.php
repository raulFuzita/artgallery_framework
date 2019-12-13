<?php

/**
 * 
 * There is no data: error=nodata
 * 
 * 
 */

namespace App\Controller\User\Accounts;

use App\Classes\User\FieldTable;
use App\Model\User\Accounts\UserLoadAccounts;
use App\View\User\show\ShowAccounts;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');

if (isset($_SESSION['user-logged']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;

    if($_SESSION['permission'] == $admin){

        $load = new UserLoadAccounts();

        if($load->fetchAllAccounts()){

            $show = new ShowAccounts();
            $show->showYourself($load);

        }

    } else {
        echo "Oh, that's awkward!<br>No data to display.";
    }

} else {
    header("location: ../../../../public/accounts.php");
    exit();
}