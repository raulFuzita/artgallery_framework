<?php

namespace App\Model\Artist;

use App\Classes\Artist\FieldTable;

class ArtistUpdate extends ArtistModel {

    private $reference;
    private $data;
    private $columnAttributes;
    private $filed;
    private $newData = array();

    function __construct(){

        $this->filed = new FieldTable();

        $this->columnAttributes = array (
            'firstName' => $this->filed->firstName,
            'lastName' => $this->filed->lastName,
            'website' => $this->filed->website,
            'street' => $this->filed->street,
            'city' => $this->filed->city,
            'country' => $this->filed->country
        );
    }

    public function verifyArtist(){
        $this->data = $this->fetch_artist_row($this->reference, $this->firstName, $this->lastName);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function hasChanged(){

        $userModel = new ArtistModel();

        $classProperties = get_object_vars($userModel);

        foreach ($classProperties as $property => $item) {

            if(isset($this->columnAttributes[$property])){
                $key =  $this->columnAttributes[$property];

                if($this->$property != $this->data[$key]){
                    $this->newData[$property] = $this->$property;
                }
            }
        }
        return (sizeof($this->newData) > 0) ? true : false;
    }

    public function updateData(){
        $reference[$this->filed->id] = $this->reference;
        return $this->user_update($reference, $this->newData);
    }

    public function is_artist_available(){
        return $this->check_artist_availability($this->id, $this->firstName, $this->lastName);
    }

    public function setReference($reference){
        $this->reference = $this->connect()->real_escape_string($reference);
        return $this;
    }

    public function getReference(){return $this->reference;}

    public function getRow(){return $this->data;}
    public function getError(){return $this->error;}
}