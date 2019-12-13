<?php

namespace App\Classes\Favorite;

use App\Classes\Art\FieldTable as ArtFiled;
use App\Classes\Artist\FieldTable as ArtistField;
use App\Classes\Database\DB;
use App\Classes\User\FieldTable as UserField;

class Favorite extends DB {

    protected $error;

    protected function count_all(){

        $field = new FieldTable();

        $tableName = $field->table;

        $sql = "SELECT count(*) as 'total' FROM {$tableName}";
        $result = $this->connect()->query($sql);

        $counter = $result->fetch_assoc();

        return $counter['total'];
    }

    protected function get_favorites($who, $start, $limit){

        $field = new FieldTable();
        $userField = new UserField();
        $artField = new ArtFiled();
        $artistField = new ArtistField();

        $tableName = $field->table;
        $tbUser = $userField->table;
        $tbArt = $artField->table;
        $tbArtist = $artistField->table;

        $userFavorite = $field->userId;
        $artFavorite = $field->artId;

        $idUser = $tbUser.".".$userField->id;

        $artId = $tbArt.".".$artField->id;
        $artName = $tbArt.".".$artField->name;
        $artType = $tbArt.".".$artField->type;
        $artArtistId = $tbArt.".".$artField->artistId;

        $artistId = $tbArtist.".".$artistField->id;
        $artistFirstName = $tbArtist.".".$artistField->firstName;
        $artistLastName = $tbArtist.".".$artistField->lastName;

        $Limit = "";

        if($start > -1 OR $limit > -1){
            $Limit = " LIMIT {$start},{$limit}";
        }

        // $sql = "SELECT {$artFavorite}, {$artName}, {$artType}, {$artArtistId} FROM {$tableName}
        // LEFT OUTER JOIN {$tbArt} ON {$artFavorite} = {$artId}
        // LEFT OUTER JOIN {$tbUser} ON {$idUser} = {$userFavorite} WHERE $idUser = ?".$Limit;
        // concat({$artistFirstName}, ' ', {$artistLastName}) as {$artField->artistId}
        $sql = "SELECT {$artFavorite}, {$artName}, {$artType}, 
        concat({$artistFirstName}, ' ', {$artistLastName}) as {$field->author} 
        FROM {$tableName}
        LEFT OUTER JOIN {$tbArt} ON {$artFavorite} = {$artId}
        LEFT OUTER JOIN {$tbUser} ON {$idUser} = {$userFavorite} 
        LEFT OUTER JOIN $tbArtist ON $artArtistId = $artistId
        WHERE $idUser = ?".$Limit;

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $who);

        if(!$stmt->execute()){
            $this->error = "wrong SQL Statement.";
            return 0;
        }

        $result = $stmt->get_result();

        $numRows = $result->num_rows;

        $data = array();

        if($numRows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }

        $stmt->close();
        $conn->close();

        return $data;
    }

    protected function get_all_favorites(){

        $field = new FieldTable();

        $tableName = $field->table;

        $sql = "SELECT * FROM {$tableName}";

        $result = $this->connect()->query($sql);

        $numRows = $result->num_rows;

        $data = array();

        if($numRows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }

        return $data;
    }

    protected function save_an_item($userId, $artId){

        $field = new FieldTable();
        $tableName = $field->table;
        $userColumn = $field->userId;
        $artColumn = $field->artId;

        $sql = "INSERT INTO {$tableName} ({$userColumn}, {$artColumn}) VALUES (?, ?)";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param('ss', $userId, $artId);

        if(!$stmt->execute()){ 
            $this->error = "wrong SQL Statement.";
            return false;
        }

        $stmt->close();
        $conn->close();

        return true;
    }

    protected function count_favorites($where, $who){

        $field = new FieldTable();
        $tableName = $field->table;

        if(isset($field->$where)){
            $this->error = "Table column doesn't exist: $where";
            return array(null);
        }

        $sql = "SELECT count({$where}) FROM {$tableName} WHERE {$where} = ?";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $who);

        if(!$stmt->execute()){ 
            $this->error = "wrong SQL Statement.";
            return 0;
        }

        $result = $stmt->get_result();
        $arr = $result->fetch_assoc();

        $stmt->close();
        $conn->close();

        return $arr;

    }

    protected function my_stuff($who){

        $field = new FieldTable();
        $userField = new UserField();
        $artField = new ArtFiled();
        $artistField = new ArtistField();

        $tableName = $field->table;
        $tbUser = $userField->table;
        $tbArt = $artField->table;
        $tbArtist = $artistField->table;

        $userFavorite = $field->userId;
        $artFavorite = $field->artId;

        $idUser = $tbUser.".".$userField->id;

        $artId = $tbArt.".".$artField->id;
        $artName = $tbArt.".".$artField->name;
        $artType = $tbArt.".".$artField->type;
        $artArtistId = $tbArt.".".$artField->artistId;

        $artistId = $tbArtist.".".$artistField->id;
        $artistFirstName = $tbArtist.".".$artistField->firstName;
        $artistLastName = $tbArtist.".".$artistField->lastName;


        // $sql = "SELECT {$artFavorite}, {$artName}, {$artType}, {$artArtistId} FROM {$tableName}
        // LEFT OUTER JOIN {$tbArt} ON {$artFavorite} = {$artId}
        // LEFT OUTER JOIN {$tbUser} ON {$idUser} = {$userFavorite} WHERE $idUser = ?";

        $sql = "SELECT {$artFavorite}, {$artName}, {$artType}, 
        concat({$artistFirstName}, ' ', {$artistLastName}) as {$field->author}
        FROM {$tableName}
        LEFT OUTER JOIN {$tbArt} ON {$artFavorite} = {$artId}
        LEFT OUTER JOIN {$tbUser} ON {$idUser} = {$userFavorite} 
        LEFT OUTER JOIN $tbArtist ON $artArtistId = $artistId
        WHERE $idUser = ?";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $who);

        if(!$stmt->execute()){ 
            $this->error = "wrong SQL Statement.";
            return 0;
        }

        $result = $stmt->get_result();

        $numRows = $result->num_rows;

        $data = array();

        if($numRows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }

        $this->error = $data;

        $stmt->close();
        $conn->close();

        return $data;
    }

    protected function user_has_favorite($userId, $artId){

        $field = new FieldTable();
        $tableName = $field->table;
        $user = $field->userId;
        $art = $field->artId;

        $sql = "SELECT {$art} FROM {$tableName} WHERE {$user} = ? AND {$art} = ?";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userId, $artId);

        if(!$stmt->execute()){ 
            $this->error = "wrong SQL Statement.";
            return 0;
        }

        $stmt->store_result();

        $resultCheck = $stmt->num_rows;

        $stmt->close();
        $conn->close();

        return $resultCheck;

    }

    protected function delete_favorite($userId, $artId){

        $field = new FieldTable();
        $tableName = $field->table;
        $user = $field->userId;
        $art = $field->artId;

        $sql = "DELETE FROM {$tableName} WHERE {$user} = ? AND {$art} = ?";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $userId, $artId);

        if(!$stmt->execute()){ 
            $this->error = "wrong SQL Statement.";
            return 0;
        }

        $stmt->store_result();
        $resultCheck = $stmt->num_rows;

        $stmt->close();
        $conn->close();

        return $resultCheck;
    }

    protected function delete_by_reference($artId){

        $field = new FieldTable();
        $tableName = $field->table;
        $user = $field->userId;
        $art = $field->artId;

        $sql = "DELETE FROM {$tableName} WHERE {$art} = ?";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $artId);

        if(!$stmt->execute()){ 
            $this->error = "wrong SQL Statement.";
            return 0;
        }

        $stmt->store_result();
        $resultCheck = $stmt->num_rows;

        $stmt->close();
        $conn->close();

        return $resultCheck;
    }

    protected function search_content($text){

        $field = new FieldTable();
        $userField = new UserField();
        $artField = new ArtFiled();
        $artistField = new ArtistField();

        $tableName = $field->table;
        $tbUser = $userField->table;
        $tbArt = $artField->table;
        $tbArtist = $artistField->table;

        $userFavorite = $field->userId;
        $artFavorite = $field->artId;

        $idUser = $tbUser.".".$userField->id;

        $artId = $tbArt.".".$artField->id;
        $artName = $tbArt.".".$artField->name;
        $artType = $tbArt.".".$artField->type;
        $artArtistId = $tbArt.".".$artField->artistId;

        $artistId = $tbArtist.".".$artistField->id;
        $artistFirstName = $tbArtist.".".$artistField->firstName;
        $artistLastName = $tbArtist.".".$artistField->lastName;

        // $sql = "SELECT * FROM {$tableName} WHERE {$firstName} LIKE concat(?, '%') 
        // OR {$lastName} LIKE concat(?, '%') OR {$website} LIKE concat(?, '%');";

        $sql = "SELECT {$artFavorite}, {$artName}, {$artType}, 
        concat({$artistFirstName}, ' ', {$artistLastName}) as {$field->author} 
        FROM {$tableName} 
        LEFT OUTER JOIN {$tbArt} ON {$artFavorite} = {$artId} 
        LEFT OUTER JOIN {$tbUser} ON {$idUser} = {$userFavorite} 
        LEFT OUTER JOIN $tbArtist ON {$artArtistId} = {$artistId}
        WHERE $userFavorite = 1 AND $artName LIKE concat(?, '%') 
        OR $artType LIKE concat(?, '%') OR $artistFirstName LIKE concat(?, '%') OR $artistLastName LIKE concat(?, '%')";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssss", $text, $text, $text, $text);

        if(!$stmt->execute()){ 
            $this->error = "wrong SQL Statement.";
            return 0;
        }

        $result = $stmt->get_result();

        $numRows = $result->num_rows;

        $data = array();

        if($numRows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
        }

        $this->error = $data;

        $stmt->close();
        $conn->close();

        return $data;
    }

}