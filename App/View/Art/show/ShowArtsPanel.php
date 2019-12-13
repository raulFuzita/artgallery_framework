<?php

namespace App\View\Art\show;

use App\Classes\Art\FieldTable;
use App\Model\Art\Arts\ArtLoadArts;

class ShowArtsPanel {

    public function showYourself($arts){

        if (!$arts instanceof ArtLoadArts) {
            return false;
        }

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
            
                echo "
                    <tr>
                        <td>{$row[$name]}</td>
                        <td>{$row[$type]}</td>
                        <td>{$row[$artistId]}</td>
                        <td>
                            <a class='btn-logout' href='../App/Controller/Art/Delete.Controller.php?idArt={$row[$id]}'>
                                Delete
                            </a>
                            <a class='btn-edit' href='./edit_art.php?idArt={$row[$id]}'>
                                Edit
                            </a>
                            <a class='btn-view' href='./view_art.php?idArt={$row[$id]}'>
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