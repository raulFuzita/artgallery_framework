<?php

namespace App\View\Art;

use App\Model\Art\Features\FeaturesModel;

class ViewArt {

    public function showYourself($art){

        if (!$art instanceof FeaturesModel) {
            return false;
        }

        if($art->art->dataSize() > 0){

            $id = $art->art->get('id');
            $name = $art->art->get('name');
            $type = $art->art->get('type');
            $artistId = $art->art->get('artistId');
            $author = $art->art->get('author');

            // Return to the right page
            $returnPage = "";

            if(isset($_GET['favorite'])){
                $returnPage = "&favorite=".$_GET['favorite'];
            } else if(isset($_GET['arts'])){
                $returnPage = "&arts=".$_GET['arts'];
            }
            
            // Extreme important keep this hidden element!!!
            echo "
                <input style='display: none' type='text' name='idArt' placeholder='First Name' value='$id' require>
            ";

            echo "
                <h3>$name</h3>
                <p>
                    <span class='field'>$type</span>
                    <a class='field' href='./view_artist.php?idArtist=$artistId&idArt=$id&$returnPage'>$author</a>
                </p>
            ";
            return true;
        }
        return false;

    }
}