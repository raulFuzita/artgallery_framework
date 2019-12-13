<?php

/**
 * 
 * There is no data: error=nodata
 * 
 * 
 */
namespace App\Controller\Art\Arts;

use App\Model\Art\Favorite\ArtLoadFavorite;
use App\View\Pagination\PaginationView;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');
// session_start();

if(isset($_SESSION['user-logged'])){

    $load = new ArtLoadFavorite();
    $page = (isset($_GET['page'])) ? $_GET['page'] : 0;

    if($load->countAll()){

        $length = $load->getLength();

        $pagination = new PaginationView();
        $pagination->bootstrapPagination($page, $length);

    } else {
        header("location: ../../../../public/my_gallery.php?error=nodata");
        exit();
    }

} else {
    header("location: ../../../../public/my_gallery.php");
    exit();
}