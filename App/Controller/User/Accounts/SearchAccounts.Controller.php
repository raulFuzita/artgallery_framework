<?php

namespace App\Controller\User\Accounts;

use App\Classes\User\FieldTable;
use App\Model\User\Accounts\UserLoadAccounts;
use App\View\User\show\ShowAccounts;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;

    if($_SESSION['permission'] == $admin){
    
        $search = (isset($_GET['search'])) ? $_GET['search'] : "";

        $load = new UserLoadAccounts();
        $load->setText($search);
    
        if($load->search()){

            $show = new ShowAccounts();
            $show->showYourself($load);
    
        } else {
            echo "<br>Problem with SQL statement or there is no text to search!";
            echo "<br>Search value: ".$load->getText();
            echo "<br>GET value: ".$search;
        }
    
    } else {
        echo "You don't have permission!";
    }

} else {
    echo "Request method is not a GET, GET doesn't have page variable.";
}

