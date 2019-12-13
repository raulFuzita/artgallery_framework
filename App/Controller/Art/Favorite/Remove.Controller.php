<?php

/**
 * 
 * There is no user or no art: error=nouserornoart
 * 
 */

namespace App\Controller\Art\Favorite;

use App\Model\Art\Favorite\ArtLoadFavorite;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged'])) {

    if(isset($_GET['idArt']) AND isset($_SESSION['userId'])){

        $artId = (isset($_GET['idArt'])) ? $_GET['idArt'] : "";
        $userId = $_SESSION['userId'];

        $remove = new ArtLoadFavorite();
        $remove->setUserID($userId);
        $remove->setArtID($artId);

        if( $remove->removeFavorite() < 0){
            header("Location: ../../../../public/my_gallery.php?usererror=inexistent");
        } else {
            header("Location: ../../../../public/my_gallery.php?removed=successfully");
        }

    } else {
        header("location: ../../../../public/my_gallery.php?error=nouserornoart");
    }

} else {
    header("location: ../../../../public/my_gallery.php");
}