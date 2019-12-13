<?php

namespace App\Model\Art;

use App\Classes\Art\FieldTable;

class ArtUpdate extends ArtModel {

    private $reference;
    private $data;
    private $columnAttributes;
    private $newData = array();
    private $field;

    function __construct(){

        $this->field = new FieldTable();

        $this->columnAttributes = array (
            'name' => $this->field->name,
            'type' => $this->field->type,
            'artistId' => $this->field->artistId,
        );
    }

    public function verifyArt(){
        $this->data = $this->fetch_art_row($this->reference, $this->name, $this->type);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function hasChanged(){

        $userModel = new ArtModel();

        $classProperties = get_object_vars($userModel);

        foreach ($classProperties as $property => $item) {

            if(isset($this->columnAttributes[$property])){
                $key =  $this->columnAttributes[$property];
                echo "$property<br>";
                if($this->$property != $this->data[$key]){
                    $this->newData[$property] = $this->$property;
                }
            }
        }
        return (sizeof($this->newData) > 0) ? true : false;
    }

    public function updateData(){
        $reference[$this->field->id] = $this->reference;
        return $this->art_update($reference, $this->newData);
    }

    public function is_art_available(){
        return $this->check_art_availability($this->id, $this->firstName, $this->lastName);
    }

    public function setReference($reference){
        $this->reference = $this->connect()->real_escape_string($reference);
        return $this;
    }

    public function getReference(){return $this->reference;}

    public function getRow(){return $this->data;}
    public function getError(){return $this->error;}
}