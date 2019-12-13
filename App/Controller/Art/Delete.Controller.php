<?php

namespace App\Controller\Art;

use App\Classes\Favorite\FieldTable as FavoriteFieldTable;
use App\Classes\Like\FieldTable as LikeFieldTable;
use App\Classes\User\FieldTable;
use App\Model\Art\ArtDelete;
use App\Model\Art\Favorite\ArtLoadFavorite;
use App\Model\Art\Like\ArtLike;

include_once('../../includes/session.php');
include('../../../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;
    $favoriteField = new FavoriteFieldTable();
    $likeField = new LikeFieldTable();

    if($_SESSION['permission'] == $admin){

        $id = (isset($_GET['idArt'])) ? $_GET['idArt'] : 0;
        $userId = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : "";

        if(empty($id)){
            header("Location: ../../../public/arts.php");
        } else {

            $delete = new ArtDelete();

            if($delete->setId($id)->deleteRecord() < 0){
                header("Location: ../../../public/arts.php?arterror=inexistent");
            } else {
                
                if(!empty($favoriteField->table)){
                    echo "Favorite: {$favoriteField->table}<br>";
                    $favorite = new ArtLoadFavorite();
                    $favorite->setArtID($id);
                    $favorite->removeByArt();
                }

                if(!empty($likeField->table)){
                    echo "Like: {$likeField->table}<br>";
                    $like = new ArtLike();
                    $like->setArtID($id);
                    $like->dislikeAllByArt();
                }

                header("Location: ../../../public/arts.php?delete=successfully");
            }
        }
    }

} else {
    header("location: ../../../public/arts.php");
    exit();
}