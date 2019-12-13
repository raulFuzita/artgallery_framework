<?php

/**
 * 
 * There is no data: error=nodata
 * 
 * 
 */

namespace App\Controller\Art\Favorite;

use App\Model\Art\Favorite\ArtLoadFavorite;
use App\View\Art\show\ShowFavorites;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged']) AND isset($_SESSION['permission'])) {

    $userId = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : 0;
    
    $load = new ArtLoadFavorite();
    $load->setID($userId);

    if($load->fetchAllArts()){
        $show = new ShowFavorites();
        $show->showYourself($load);
    }

} else {
    header("location: ../../../../public/my_gallery.php");
    exit();
}