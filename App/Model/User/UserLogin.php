<?php

namespace App\Model\User;

class UserLogin extends UserModel {

    private $data;

    public function verifyUser(){
        $this->data = $this->fetch_user_row($this->username, $this->email);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function authenticate(){
        return $this->authenticate_password($this->password, $this->data);
    }
    
    public function getRow(){return $this->data;}
    public function getError(){return $this->error;}

}