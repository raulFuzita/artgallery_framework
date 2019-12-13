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
use App\View\Pagination\PaginationView;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');

$admin = FieldTable::Admin;

if($_SESSION['permission'] == $admin){

    $load = new UserLoadAccounts();
    $page = (isset($_GET['page'])) ? $_GET['page'] : 0;

    if($load->countAll()){

        $length = $load->getLength();

        $pagination = new PaginationView();
        $pagination->bootstrapPagination($page, $length);

    } else {
        header("location: ../../../../public/accounts.php?error=nodata");
        exit();
    }

} else {
    header("location: ../../../../public/accounts.php");
    exit();
}