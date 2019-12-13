<?php

namespace App\Model\Artist;

use App\Classes\Artist\Artist;

class ArtistDelete extends Artist {

    private $id;

    public function deleteRecord(){
        return $this->delete_artist($this->id);
    }

    public function setId($id){
        $this->id = $this->connect()->real_escape_string($id);
        return $this;
    }

}