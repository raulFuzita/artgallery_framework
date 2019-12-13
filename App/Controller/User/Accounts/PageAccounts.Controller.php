<?php

namespace App\Controller\User\Accounts;

use App\Classes\User\FieldTable;
use App\Model\User\Accounts\UserLoadAccounts;
use App\View\User\show\ShowAccounts;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['page']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;

    if($_SESSION['permission'] == $admin){
    
        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;

        $load = new UserLoadAccounts();
        $load->setCurrentPage($page);
    
        if($load->getNext()){
    
            $show = new ShowAccounts();
            $show->showYourself($load);
    
        } else {
            echo $load->getError();
            echo "<br>Problem with SQL statement or there is no page set!";
            echo "<br>Page value: ".$load->getCurrentPage();
            echo "<br>GET value: ".$page;
        }
    
    } else {
        echo "You don't have permission!";
    }

} else {
    echo "Request method is not a GET, GET doesn't have page variable.";
}

