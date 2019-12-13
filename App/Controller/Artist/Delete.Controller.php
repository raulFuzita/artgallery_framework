<?php

/*
 * TABLE OF RETURNS
 * 
 * Artist inexistent: artisterror=inexistent
 * Artist deleted: delete=successfully
 */

namespace App\Controller\Artist;

use App\Classes\Art\FieldTable as ArtFieldTable;
use App\Classes\Favorite\FieldTable as FavoriteFieldTable;
use App\Classes\Like\FieldTable as LikeFieldTable;
use App\Classes\User\FieldTable;
use App\Model\Art\ArtDelete;
use App\Model\Art\Favorite\ArtLoadFavorite;
use App\Model\Art\Like\ArtLike;
use App\Model\Artist\ArtistDelete;

include_once('../../includes/session.php');
include('../../../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;
    $favoriteField = new FavoriteFieldTable();
    $likeField = new LikeFieldTable();
    $artField = new ArtFieldTable();
    $artId = $artField->id;

    if($_SESSION['permission'] == $admin){

        $id = (isset($_GET['idArtist'])) ? $_GET['idArtist'] : 0;

        if(empty($id)){
            header("Location: ../../../public/artists.php");
        } else {

            $delete = new ArtistDelete();
            $art = new ArtDelete();
            $favorite = new ArtLoadFavorite();

            $art->setId($id);
            $art->allArtByArtist();
            $like = new ArtLike();

            
            foreach ($art->getAll() as $row) {
                // echo "{$row[$artId]}<br>";
                $reference = $row[$artId];

                echo "$reference<br>";

                $art->deleteByReference($reference);

                if(!empty($favoriteField->table)){
                    $favorite->setArtID($reference);
                    $favorite->removeByArt();
                }

                if(!empty($likeField->table)){
                    $like->setArtID($reference);
                    $like->dislikeAllByArt();
                }
            }

            if($delete->setId($id)->deleteRecord() < 1){
                header("Location: ../../../public/artists.php?artisterror=inexistent");
            }
            header("Location: ../../../public/artists.php?delete=successfully");
        }
    }

} else {
    header("location: ../../../public/artists.php");
    exit();
}