<?php

namespace App\Model\Artist;

class ArtistCreate extends ArtistModel {

    private $data;

    public function verifyArtist(){
        $this->data = $this->fetch_artist_row($this->id, $this->firstName, $this->lastName);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function addArtist(){
        $values = array(
            'firstName' => $this->firstName, 
            'lastName' => $this->lastName, 
            'website' => $this->website, 
            'street' => $this->street,
            'city' => $this->city, 
            'country' => $this->country
        );

        return $this->add_new_artist($values);
    }

    public function is_artist_available(){
        return $this->check_artist_availability($this->firstName, $this->lastName);
    }

    public function setWebsite($website){
        $website = $this->connect()->real_escape_string($website);
        if (filter_var($website, FILTER_SANITIZE_STRING)) {
            $this->website = $website;
        } else {
            $this->error = "Website format is invalid.";
        }
        return $this;
    }
    
    public function getRow(){return $this->data;}
    public function getError(){return $this->error;}
}