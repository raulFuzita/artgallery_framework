<?php

/**
 * 
 * Art has been saved: save=successfully
 * Failed to save a piece of art: error=favoritefailed
 * Favorite removed: removed=successfully
 * 
 */

namespace App\Controller\Art\Features;

use App\Model\Art\Favorite\ArtLoadFavorite;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged'])) {

    $id = (isset($_GET['idArt'])) ? $_GET['idArt'] : false;
    $userId = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : "";

    $favorite = new ArtLoadFavorite();
    $favorite->setArtID($id);
    $favorite->setUserID($userId);

    if($favorite->save_art()){
        header("Location: ../../../../public/view_art.php?idArt=$id&save=successfully");
        exit();
    } else {
        if($favorite->removeFavorite()){
            header("Location: ../../../../public/view_art.php?idArt=$id&error=favoritefailed");
            exit();
        }
        header("Location: ../../../../public/view_art.php?idArt=$id&removed=successfully");
        exit();
    }

} else {
    header("Location: ../../../../public/view_art.php?nocredential");
    exit();
}