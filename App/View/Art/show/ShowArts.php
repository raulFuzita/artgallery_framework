<?php

namespace App\View\Art\show;

use App\Classes\Art\FieldTable;
use App\Classes\Like\FieldTable as LikeFieldTable;
use App\Model\Art\Features\FeaturesModel;

class ShowArts {

    public function showYourself($features){

        if (!$features instanceof FeaturesModel) {
            return false;
        }

        $arts = $features->art;
        $likeField = new LikeFieldTable();
        $likeArtId = $likeField->artId;
        // New Features
        // ================= LIKE FUNCTIONALITY ===================
        $likes = $features->like;
        $likeData = $likes->getData();
        // $array = array_column($likes->getData(), $likeArtId);
        // $likeList = implode(' , ', $array);
        // =========================================================
        if($arts->dataSize() > 0){

            $field = new FieldTable();

            $id = $field->id;
            $name = $field->name;
            $type = $field->type;
            // new feature
            $artistId = $field->author;
        
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
            foreach ($arts->getAll() as $row) {
                // $hasLike = ((strpos($likeList, $row[$id]) !== false) ? "icon-like-blue": "");

                /**
                 * Title: PHP multidimensional array search by value
                 * Author: StackOverflow
                 * Author: Rahul
                 * Availability: https://stackoverflow.com/questions/6661530/php-multidimensional-array-search-by-value
                 */
                // ----------- Checks if a piece of art have a like ----------------
                $hasLike = (array_search($row[$id], array_column($likeData, $likeArtId)) !== false) ? "icon-like-blue": "";
                // -----------------------------------------------------------------
                echo "
                    <tr>
                        <td>{$row[$name]}</td>
                        <td>{$row[$type]}</td>
                        <td>{$row[$artistId]}</td>
                        <td>
                            <a class='btn-view' href='./view_art.php?idArt={$row[$id]}'>
                                View
                            </a>

                            <a href=''>
                                <img id='{$row[$id]}' class='like-Art download-icon icon-like $hasLike' src='../resources/Like_Button/icon/thumb-up-button.svg' alt='Like'>
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