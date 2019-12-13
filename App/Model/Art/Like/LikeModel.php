<?php

namespace App\Model\Art\Like;

use App\Classes\Like\Like;

class LikeModel extends Like {

    protected $id;
    protected $userId;
    protected $artId;

    public function require_properties(){
        $methods = func_get_args();
        foreach ($methods as $key => $value) {
            if(empty($value)) return false;
        }
        return true;
    }

    public function setUserID($userId){
        $this->userId = $this->connect()->real_escape_string($userId);
        return $this;
    }

    public function setArtID($artId){
        $this->artId = $this->connect()->real_escape_string($artId);
        return $this;
    }

    public function setID($id){
        $this->id = $this->connect()->real_escape_string($id);
        return $this;
    }

    public function getUserID(){return $this->userId;}
    public function getArtID(){return $this->artId;}
    public function getID(){return $this->id;}

}