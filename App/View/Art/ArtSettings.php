<?php

namespace App\View\Art;

use App\Classes\Artist\FieldTable;
use App\Model\Art\ArtEdit;
use App\Model\Artist\Artists\ArtistLoadArtists;

class ArtSettings {


    public function showYourself($features){

        $art = $features->art;
        $artists = $features->artist;
        $artistNames = array();

        if (!$art instanceof ArtEdit) {
            return false;
        }

        if($artists instanceof ArtistLoadArtists){
            $artistNames = $artists->getAll();
        }

        if($art->dataSize() > 0){

            $id = $art->get('id');
            $name = $art->get('name');
            $type = $art->get('type');
            // $artArtistId = $art->get('artistId');

            $artistField = new FieldTable();
            $artistId = $artistField->id;
            $artistFirstName = $artistField->firstName;
            $artistLastName = $artistField->lastName;
            
            // Extreme important keep this hidden element!!!
            echo "
                <input style='display: none' type='text' name='idArt' placeholder='First Name' value='$id' require>
            ";

            echo "
                <input class='field' type='text' name='name' placeholder='First Name' value='$name' require>
                <input class='field' type='text' name='type' placeholder='Last Name' value='$type'>
             ";

             echo "<select class='field' name='artistId'>";

            foreach ($artistNames as $row) {
                echo "<option value='{$row[$artistId]}'>{$row[$artistFirstName]} {$row[$artistLastName]}</option>";
            }

            echo "</select>";

            return true;
        }
        return false;

    }
}