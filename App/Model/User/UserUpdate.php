<?php

namespace App\Model\User;

use App\Classes\User\FieldTable;

class UserUpdate extends UserModel {

    private $reference;
    private $data;
    private $id;
    private $field;
    private $columnAttributes;
    private $newData = array();

    function __construct(){

        $this->field = new FieldTable();

        $this->columnAttributes = array (
            'firstName' => $this->field->firstName,
            'lastName' => $this->field->lastName,
            'username' => $this->field->username,
            'email' => $this->field->email,
            'password' => $this->field->password,
            'street' => $this->field->street,
            'city' => $this->field->city,
            'country' => $this->field->country
        );
    }

    public function fetchById(){
        $this->data = $this->fetch_by_id($this->id);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function verifyUser(){
        $this->data = $this->fetch_user_row($this->reference, $this->email);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function authenticate(){
        return ($this->password == $this->confirmPassword) ? true : false;
    }

    public function hasChanged(){

        $userModel = new UserModel();

        if(empty($this->password)){
            unset($userModel->password);
        }

        $isAvailable = $this->check_user_availability($this->username, $this->email);

        if($isAvailable > 0){
            unset($userModel->username);
        }

        $classProperties = get_object_vars($userModel);

        foreach ($classProperties as $property => $item) {

            if(isset($this->columnAttributes[$property])){
                $key =  $this->columnAttributes[$property];

                if(isset($this->data[$key]) OR empty($this->data[$key])){
                    if($this->$property != $this->data[$key]){
                        $this->newData[$property] = $this->$property;
                    }
                }
            }
        }
        return (sizeof($this->newData) > 0) ? true : false;
    }

    public function updateData(){
        $reference[$this->field->username] = $this->reference;
        return $this->user_update($reference, $this->newData);
    }

    public function updateByID(){
        $reference[$this->field->id] = $this->id;
        return $this->user_update($reference, $this->newData);
    }

    public function is_user_available(){
        return $this->check_user_availability($this->username, $this->email);
    }

    public function setReference($reference){
        $this->reference = $this->connect()->real_escape_string($reference);
        return $this;
    }
    
    public function getUsername(){
        return $this->username;
    }

    public function setID($id){
        $this->id = $this->connect()->real_escape_string($id);
        return $this;
    }

    public function getID(){return $this->id;}

    public function getRow(){return $this->data;}
    public function getError(){return $this->error;}
}