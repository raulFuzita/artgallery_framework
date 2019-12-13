<?php

namespace App\View\Art;

use App\Model\Art\Features\FeaturesModel;

class ViewArtist {

    public function showYourself($features){

        if (!$features instanceof FeaturesModel) {
            return false;
        }

        if($features->art->dataSize() > 0){

            $id = $features->art->get('id');
            $artistId = $features->artist->get('id');
            $firstName = $features->artist->get('firstName');
            $LastName = $features->artist->get('lastName');
            $website = $features->artist->get('website');
            $street = $features->artist->get('street');
            $city = $features->artist->get('city');
            $country = $features->artist->get('country');

            $name = $firstName." ".$LastName;
            $address = $street." ".$city." ".$country;
            
            // Extreme important keep this hidden element!!!
            echo "
                <input style='display: none' type='text' name='idArt' placeholder='First Name' value='$id' require>
            ";

            echo "
                <h3>$name</h3>
                <p>
                    <span class='field'>Website: $website</span>
                    <hr>
                    <span class='field'>Address: $address</span>
                </p>
             ";
            return true;
        }
        return false;

    }
}