<?php

namespace App\Model\Art;

use App\Classes\Art\Art;

class ArtModel extends Art {

    protected $name;
    protected $type;
    protected $artistId;

    public function require_properties(){
        $methods = func_get_args();
        foreach ($methods as $key => $value) {
            if(empty($value)) return false;
        }
        return true;
    }

    public function setName($name){
        $this->name = $this->connect()->real_escape_string($name);
        return $this;
    }

    public function setType($type){
        $this->type = $this->connect()->real_escape_string($type);
        return $this;
    }

    public function setArtistId($artistId){
        $this->artistId = $this->connect()->real_escape_string($artistId);
        return $this;
    }

}