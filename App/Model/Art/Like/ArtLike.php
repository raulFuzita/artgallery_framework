<?php

namespace App\Model\Art\Like;

use App\Classes\Like\FieldTable;

class ArtLike extends LikeModel {

    private $data;
    private $field;

    function __construct(){
        $this->field = new FieldTable();
    }

    public function like_art(){
        return $this->like_an_item($this->userId, $this->artId);
    }

    public function countArtLikes(){
        $this->data = $this->count_likes($this->field->artId, $this->id);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function dislike(){
        if($this->userId > 0 AND $this->artId > 0){
            return $this->delete_like($this->userId, $this->artId);
        }
        return 0;
    }

    public function dislikeAllByArt(){
        if($this->artId > 0){
            return $this->delete_by_reference($this->artId);
        }
        return 0;
    }

    public function userHasLike(){
        if($this->userId > 0 AND $this->artId > 0){
            return $this->user_has_like($this->userId, $this->artId);
        }
        return 0;
    }

    public function MyLikedArt(){
        $this->data = $this->my_stuff($this->field->artId, $this->field->userId, $this->id);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function allMyLikes(){
        $this->data = $this->my_stuff($this->field->artId, $this->field->userId, $this->userId);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function get($index){
        return (isset($this->field->$index)) ? $this->data[$this->field->$index] : "";
    }

    public function getData(){return $this->data;}
    public function getError(){return $this->error;}

}