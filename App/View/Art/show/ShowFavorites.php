<?php

namespace App\View\Art\show;

use App\Classes\Art\FieldTable;
use App\Classes\Favorite\FieldTable as FavoriteFieldTable;
use App\Model\Art\Favorite\ArtLoadFavorite;

class ShowFavorites {

    public function showYourself($favorite){

        if (!$favorite instanceof ArtLoadFavorite) {
            return false;
        }

        if($favorite->getLength() > 0){

            $field = new FieldTable();
            $favoriteField = new FavoriteFieldTable();

            $name = $field->name;
            $type = $field->type;
            $artistId = $field->artistId;

            // new feature
            $favoriteArt = $favoriteField->author;
            $artId = $favoriteField->artId;
            // Table Header
            echo "
                <table class='user-list'>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Artist</th>
                        <th>Action</th>
                    </tr>
            ";
            // Table Body
            foreach ($favorite->getAll() as $row) {
            
                echo "
                    <tr>
                        <td>{$row[$name]}</td>
                        <td>{$row[$type]}</td>
                        <td>{$row[$favoriteArt]}</td>
                        <td>
                            <a class='btn-logout' href='../App/Controller/Art/Favorite/Remove.Controller.php?idArt={$row[$artId]}'>
                                Remove
                            </a>
                            <a class='btn-view' href='./view_art.php?idArt={$row[$artId]}&favorite=my_gallery'>
                                View
                            </a>
                        </td>
                    </tr>
                ";
            }
            // The end of the table
            echo "</table>";
            return true;
        }
        return false;
    }
}