<?php

namespace App\Model\Art;

use App\Classes\art\Art;

class ArtDelete extends Art {

    private $id;
    private $data;

    public function deleteRecord(){
        return $this->delete_art($this->id);
    }

    public function deleteByReference($reference){
        return $this->delete_art($reference);
    }

    public function setId($id){
        $this->id = $this->connect()->real_escape_string($id);
        return $this;
    }

    public function allArtByArtist(){
        $this->data = $this->fetch_by_owner($this->id);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function getAll(){return $this->data;}
    public function getError(){return $this->error;}

}