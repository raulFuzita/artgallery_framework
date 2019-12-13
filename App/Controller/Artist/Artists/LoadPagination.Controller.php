<?php

/**
 * 
 * There is no data: error=nodata
 * 
 * 
 */
namespace App\Controller\Artist\Artists;

use App\Classes\User\FieldTable;
use App\Model\Artist\Artists\ArtistLoadArtists;
use App\View\Pagination\PaginationView;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');

$admin = FieldTable::Admin;

if($_SESSION['permission'] == $admin){

    $load = new ArtistLoadArtists();
    $page = (isset($_GET['page'])) ? $_GET['page'] : 0;

    if($load->countAll()){

        $length = $load->getLength();

        $pagination = new PaginationView();
        $pagination->bootstrapPagination($page, $length);

    } else {
        header("location: ../../../../public/artists.php?error=nodata");
        exit();
    }

} else {
    header("location: ../../../../public/artists.php");
    exit();
}