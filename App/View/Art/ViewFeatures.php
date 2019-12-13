<?php

namespace App\View\Art;

use App\Model\Art\Features\FeaturesModel;
use App\Model\Art\Like\ArtLike;
use App\Model\Art\Favorite\ArtLoadFavorite;

class ViewFeatures {

    public function showYourself($features){

        $btnName = "";

        if (!$features instanceof FeaturesModel) {
            return false;
        }

        if($features->favorite instanceof ArtLoadFavorite){
            $favorite = $features->favorite;
            $btnName = ($favorite->userHasFavorite()) ? "Remove": "Favorite";
        }

        if($features->like instanceof ArtLike){

            
            $id = $features->like->getArtID();
            $hasLike = ($features->like->userHasLike() > 0) ? "icon-like-blue" : "";

            echo "
                <form action='../App/Controller/Art/Features/SaveArt.Controller.php' method='get'>

                    <input style='display: none' type='text' name='idArt' value='$id'>

                    <input class='btn-edit' type='submit' value='$btnName'>
                    
                    <a href='../App/Controller/Art/Features/LikeClick.Controller.php?idArt=$id'>
                        <img class='download-icon icon-like $hasLike' src='../resources/Like_Button/icon/thumb-up-button.svg' alt='Like'>
                    </a>

                </form>
             ";
            return true;
        }
        return false;

    }
}