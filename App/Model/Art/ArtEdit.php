<?php

namespace App\Model\Art;

use App\Classes\Art\Art;
use App\Classes\Art\FieldTable;

class ArtEdit extends Art {

    private $data;
    private $id;
    private $field;

    private $name;
    private $artistId;

    function __construct($id){
        $this->id = $id;
        $this->field = new FieldTable();
    }

    public function verifyArt(){
        $this->data = $this->fetch_art_row($this->id, $this->name, $this->artistId);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function get($index){
        return (isset($this->field->$index)) ? $this->data[$this->field->$index] : "";
    }

    public function getData(){return $this->data;}
    public function dataSize(){return sizeof($this->data);}
    public function getError(){return $this->error;}
    
}