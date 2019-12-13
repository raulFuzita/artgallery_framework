<?php

namespace App\View\Artist\show;

use App\Classes\Artist\FieldTable;
use App\Model\Artist\Artists\ArtistLoadArtists;

class ShowArtists {

    public function showYourself($users){

        if (!$users instanceof ArtistLoadArtists) {
            return false;
        }

        if($users->dataSize() > 0){

            $field = new FieldTable();

            $id = $field->id;
            $firstName = $field->firstName;
            $lastName = $field->lastName;
            $website = $field->website;
            $street = $field->street;
            $city = $field->city;
            $country = $field->country;
        
            // Table Header
            echo "
                <table class='user-list'>
                    <tr>
                        <th>Name</th>
                        <th>Website</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
            ";

            // Table Body
            foreach ($users->getAll() as $row) {
            
                echo "
                    <tr>
                        <td>{$row[$firstName]} {$row[$lastName]}</td>
                        <td>{$row[$website]}</td>
                        <td>{$row[$street]} {$row[$city]} {$row[$country]}</td>
                        <td>
                            <a class='btn-logout' href='../App/Controller/Artist/Delete.Controller.php?idArtist={$row[$id]}'>
                                Delete
                            </a>
                            <a class='btn-edit' href='./edit_artist.php?idArtist={$row[$id]}'>
                                Edit
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