<?php

namespace App\View\Artist;

use App\Model\Artist\ArtistEdit;

class ArtistSettings {


    public function showYourself($artist){

        if (!$artist instanceof ArtistEdit) {
            return false;
        }

        if($artist->dataSize() > 0){

            $id = $artist->get('id');
            $firstName = $artist->get('firstName');
            $lastName = $artist->get('lastName');
            $website = $artist->get('website');
            $street = $artist->get('street');
            $city = $artist->get('city');
            $country = $artist->get('country');
            

            // Extreme important keep this hidden element!!!
            echo "
                <input style='display: none' type='text' name='idArtist' placeholder='First Name' value='$id' require>
            ";

            echo "
                <input class='field' type='text' name='first-name' placeholder='First Name' value='$firstName' require>
                <input class='field' type='text' name='last-name' placeholder='Last Name' value='$lastName'>
                <input class='field' type='text' name='website' placeholder='Website' value='$website'>
            
                <hr>
            
                <input class='field' type='text' name='street' placeholder='Street' value='$street'>
                <input class='field' type='text' name='city' placeholder='City' value='$city'>
                <input class='field' type='text' name='country' placeholder='Country' value='$country'>
                
             ";
            return true;
        }
        return false;

    }
}