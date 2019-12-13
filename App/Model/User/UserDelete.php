<?php

namespace App\Model\User;

use App\Classes\User\User;

class UserDelete extends User {

    private $id;

    public function deleteRecord(){
        return $this->delete_user($this->id);
    }

    public function setId($id){
        $this->id = $this->connect()->real_escape_string($id);
        return $this;
    }

}