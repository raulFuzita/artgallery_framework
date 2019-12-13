<?php

namespace App\Model\Art\Favorite;

use App\Classes\Favorite\FieldTable;

class ArtLoadFavorite extends FavoriteModel {

    private $LIMIT = 10;

    private $data;
    private $field;

    private $length;
    private $currentPage;
    private $text;

    function __construct(){
        $this->field = new FieldTable();
    }

    public function save_art(){
        return $this->save_an_item($this->userId, $this->artId);
    }

    public function countArtFavorites(){
        $this->data = $this->count_favorites($this->field->artId, $this->id);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function removeFavorite(){
        if($this->userId > 0 AND $this->artId > 0){
            return $this->delete_favorite($this->userId, $this->artId);
        }
        return 0;
    }

    public function removeByArt(){
        if($this->artId > 0){
            return $this->delete_by_reference($this->artId);
        }
        return 0;
    }

    public function userHasFavorite(){
        if($this->userId > 0 AND $this->artId > 0){
            return $this->user_has_favorite($this->userId, $this->artId);
        }
        return 0;
    }

    public function fetchAllArts(){
        $this->data = $this->get_favorites($this->id, 0, $this->LIMIT);
        $this->length = $this->count_favorites($this->field->userId, $this->id);
        return (sizeof($this->data) > 0 AND sizeof($this->length)) ? true : false;
    }

    public function getNext(){
        $this->data = $this->get_favorites($this->id, $this->currentPage, $this->LIMIT);
        $this->length = $this->count_favorites($this->field->userId, $this->id);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function search(){
        $this->data = $this->search_content($this->text);
        // $this->length = $this->count_all();
        $this->length = $this->count_favorites($this->field->userId, $this->id);
        // return false; // Debug mode
        return true;
    }

    public function countAll(){
        $this->length = $this->count_favorites($this->field->userId, $this->id);
        // $this->length = $this->count_all();
        return true;
    }

    public function MyFavorites(){
        $this->data = $this->my_stuff($this->id);
        return (sizeof($this->data) > 0) ? true : false;
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

    public function getAll(){return $this->data;}
    public function getError(){return $this->error;}

}