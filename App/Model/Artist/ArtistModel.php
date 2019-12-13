<?php

namespace App\Model\Artist;

use App\Classes\Artist\Artist;

class ArtistModel extends Artist {

    protected $firstName;
    protected $lastName;
    protected $website;
    protected $street;
    protected $city;
    protected $country;

    public function require_properties(){
        $methods = func_get_args();
        foreach ($methods as $key => $value) {
            if(empty($value)) return false;
        }
        return true;
    }

    public function setFirstName($firstName){
        $this->firstName = $this->connect()->real_escape_string($firstName);
        return $this;
    }

    public function setLastName($lastName){
        $this->lastName = $this->connect()->real_escape_string($lastName);
        return $this;
    }

    public function setWebsite($website){
        $this->website = $this->connect()->real_escape_string($website);
        return $this;
    }

    public function setStreet($street){
        $this->street = $this->connect()->real_escape_string($street);
        return $this;
    }

    public function setCity($city){
        $this->city = $this->connect()->real_escape_string($city);
        return $this;
    }

    public function setCountry($country){
        $this->country = $this->connect()->real_escape_string($country);
        return $this;
    }

}