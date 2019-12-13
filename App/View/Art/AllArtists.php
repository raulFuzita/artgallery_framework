<?php

namespace App\View\Art;

use App\Classes\Artist\FieldTable;
use App\Model\Artist\Artists\ArtistLoadArtists;

class AllArtists {


    public function showYourself($artists){

        if (!$artists instanceof ArtistLoadArtists) {
            return false;
        }

        if($artists->dataSize() > 0){

            $field = new FieldTable();

            $id = $field->id;
            $firstName = $field->firstName;
            $lastName = $field->lastName;

            foreach ($artists->getAll() as $row) {
                echo "
                    <option value='{$row[$id]}'>{$row[$firstName]} {$row[$lastName]}</option>
                ";
            }

            return true;
        }
        return false;

    }
}