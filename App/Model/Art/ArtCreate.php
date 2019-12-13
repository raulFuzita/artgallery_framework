<?php

namespace App\Model\Art;

class ArtCreate extends ArtModel {

    private $data;

    public function verifyArt(){
        $this->data = $this->fetch_art_row($this->id, $this->name, $this->artistId);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function addArt(){
        $values = array(
            'name' => $this->name, 
            'type' => $this->type, 
            'artistId' => $this->artistId, 
        );

        return $this->add_new_art($values);
    }

    public function is_art_available(){
        return $this->check_art_availability($this->name, $this->type, $this->artistId);
    }
    
    public function getRow(){return $this->data;}
    public function getError(){return $this->error;}
}