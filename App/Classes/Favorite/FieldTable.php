<?php

namespace App\Classes\Favorite;

final class FieldTable {

    // favorite_user_idUser, favorite_art_piece_idart_piece
    public $table = "favorite_user_has_art_piece";

    public $userId = "favorite_user_idUser";
    public $artId = "favorite_art_piece_idart_piece";

    public $author = "author";
    
    public $thirdId = ""; // Don't need
    public $Fourth = ""; // Don't need

}