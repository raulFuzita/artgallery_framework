<?php

namespace App\Model\Art\Arts;

use App\Classes\Art\Art;

class ArtLoadArts extends Art {

    private $LIMIT = 10;
    
    private $data;
    private $length;
    private $currentPage;
    private $text;

    public function fetchAllArts(){
        $this->data = $this->get_all_art(0, $this->LIMIT);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function getNext(){
        $this->data = $this->get_all_art($this->currentPage, $this->LIMIT);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function search(){
        $this->data = $this->search_content($this->text);
        // return false; // Debug mode
        return true;
    }

    public function countAll(){
        $this->length = $this->count_all();
        return true;
    }

    public function setCurrentPage($currentPage){
        $this->currentPage = $this->connect()->real_escape_string($currentPage);
        return $this;
    }

    public function setText($text){
        $this->text = $this->connect()->real_escape_string($text);
        return $this;
    }

    public function getCurrentPage(){return $this->currentPage;}
    public function getText(){return $this->text;}

    public function getLength(){return $this->length;}

    public function dataSize(){return sizeof($this->data);}
    public function getAll(){return $this->data;}
    public function getError(){return $this->error;}
    
}