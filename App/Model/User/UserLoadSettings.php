<?php

namespace App\Model\User;

use App\Classes\User\FieldTable;
use App\Classes\User\User;


class UserLoadSettings extends User {

    private $data;
    private $username;
    private $field;
    private $id;

    function __construct($username){
        $this->username = $username;
        $this->field = new FieldTable();
    }

    public function verifyUser(){
        $this->data = $this->fetch_user_row($this->username, $this->username);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function get($index){
        return (isset($this->field->$index)) ? $this->data[$this->field->$index] : "";
    }

    public function setID($id){
        $this->id = $this->connect()->real_escape_string($id);
        return $this;
    }

    public function fetchById(){
        $this->data = $this->fetch_by_id($this->id);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function getID(){return $this->id;}
    public function dataSize(){return sizeof($this->data);}
    public function getError(){return $this->error;}
    
}