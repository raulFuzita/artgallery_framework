<?php

namespace App\Model\Artist;

use App\Classes\Artist\Artist;
use App\Classes\Artist\FieldTable;

class ArtistEdit extends Artist {

    private $data;
    private $id;
    private $field;

    private $firstName;
    private $lastName;

    function __construct($id){
        $this->id = $id;
        $this->field = new FieldTable();
    }

    public function verifyArtist(){
        $this->data = $this->fetch_artist_row($this->id, $this->firstName, $this->lastName);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function get($index){
        return (isset($this->field->$index)) ? $this->data[$this->field->$index] : "";
    }

    public function getData(){return $this->data;}
    public function dataSize(){return sizeof($this->data);}
    public function getError(){return $this->error;}
    
}