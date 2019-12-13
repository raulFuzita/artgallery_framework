<?php

/**
 * 
 * Impossible to like a piece of art: error=likefailed
 * You liked a piece of art: like=successfully
 * 
 */

namespace App\Controller\Art\Features;

use App\Model\Art\Like\ArtLike;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged'])) {

    $id = (isset($_GET['idArt'])) ? $_GET['idArt'] : false;
    $userId = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : "";

    $like = new ArtLike();
    $like->setArtID($id);
    $like->setUserID($userId);

    if($like->userHasLike() > 0){
        $like->dislike();
        header("Location: ../../../../public/view_art.php?idArt=$id&dislike=successfully");
        exit();
    } else {
        if(!$like->like_art()){
            header("Location: ../../../../public/view_art.php?idArt=$id&error=likefailed");
            exit();
        } else {
            header("Location: ../../../../public/view_art.php?idArt=$id&like=successfully");
            exit();
        }
    }

} else {
    header("Location: ../../../../public/view_art.php");
    exit();
}