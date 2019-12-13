<?php

namespace App\Classes\Artist;

final class FieldTable {

    // idArtist, first_name, last_name, street, country, city, website
    public $table = "artist";
    
    public $id = "idArtist";
    public $firstName = "first_name";
    public $lastName = "last_name";
    public $website = "website";
    public $street = "street";
    public $city = "city";
    public $country = "country";
}