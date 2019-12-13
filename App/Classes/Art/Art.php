<?php

namespace App\Classes\Art;

use App\Classes\Artist\FieldTable as ArtistField;
use App\Classes\Database\DB;

class Art extends DB {

    protected $error;

    protected function count_all(){

        $field = new FieldTable();

        $tableName = $field->table;

        $sql = "SELECT count(*) as 'total' FROM {$tableName}";
        $result = $this->connect()->query($sql);

        $counter = $result->fetch_assoc();

        return $counter['total'];
    }

    protected function get_all_art($start, $limit){

        $field = new FieldTable();
        $artistField = new ArtistField();

        $tableName = $field->table;
        $id = $field->id;
        $artName = $field->name;
        $artType = $field->type;
        $artist = $field->artistId;

        $artistTable = $artistField->table;
        $artistId = $artistField->id;
        $artistFirstName = $artistTable.".".$artistField->firstName;
        $artistLastName = $artistTable.".".$artistField->lastName;

        $limitItems = ($start >= 0 AND $limit != 0) ? " LIMIT {$start},{$limit}" : "";

        // $sql = "SELECT * FROM {$tableName}".$limitItems;

        $sql = "SELECT {$id}, {$artName}, {$artType}, $artist, 
        concat({$artistFirstName}, ' ', {$artistLastName}) as {$field->author}
        FROM $tableName
        JOIN {$artistTable} ON {$artist} = $artistId 
        GROUP BY {$artName} ASC".$limitItems;

        $result = $this->connect()->query($sql);

        $numRows = $result->num_rows;

        if($numRows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
    }

    protected function fetch_art_reference(){

        $field = new FieldTable();
        $tableName = $field->table;
        $id = $field->id;
        $name = $field->name;
        $type = $field->type;

        $sql = "SELECT {$id}, {$name}, {$type} FROM {$tableName}";

        $result = $this->connect()->query($sql);

        $numRows = $result->num_rows;

        if($numRows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
    }



    protected function fetch_art_row($id, $name, $artistId){

        $field = new FieldTable();
        $artistField = new ArtistField();

        $tableName = $field->table;
        $artId = $field->id;
        $artName = $field->name;
        $artType = $field->type;
        $artist = $field->artistId;

        $artistTable = $artistField->table;
        $artistId = $artistField->id;
        $artistFirstName = $artistTable.".".$artistField->firstName;
        $artistLastName = $artistTable.".".$artistField->lastName;

        // $sql = "SELECT * FROM {$tableName} WHERE {$field->id}=? OR {$field->name}=? AND {$field->artistId}=?";

        $sql = "SELECT {$artId}, {$artName}, {$artType}, {$artist},
        concat({$artistFirstName}, ' ', {$artistLastName}) as {$field->author}
        FROM $tableName
        JOIN {$artistTable} ON {$artist} = $artistId 
        WHERE {$artId}=? OR {$artName}=? AND {$artist}=?";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $id, $name, $artistId);

        if(!$stmt->execute()){ 
            $this->error = "wrong SQL Statement.";
            return array();
        }

        $result = $stmt->get_result();
        $arr = $result->fetch_assoc();

        $stmt->close();
        $conn->close();

        return $arr;
    }

    protected function art_update($changeWhere, $arrayValues){

        $field = new FieldTable();
        $tableName = $field->table;

        $keyRef = key($changeWhere);

        if(!is_array($arrayValues) AND sizeof($arrayValues) <= 0){
            $this->error = "The passed argument is not an array or it doesn't have any value.";
            return false;
        }

        $values = "";
        $attributes = array();

        foreach ($arrayValues as $key => $value) {
            if (isset($field->$key)) {
                $values .= $field->$key."=?,";
                $attributes[] = $value;
            }
        }

        $values = substr($values,0,strlen($values)-1);
        $attributes[] = $changeWhere[$keyRef];
            
        $sql = "UPDATE {$tableName} SET $values WHERE {$keyRef}=?";

        $parameters = str_repeat("s", count($attributes));

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param($parameters, ...$attributes);
        if(!$stmt->execute()){ 
            $this->error = "wrong SQL Statement.";
            return false;
        }

        $stmt->close();
        $conn->close();
        return true;
    }

    protected function delete_art($artId){

        $field = new FieldTable();
        $tableNme = $field->table;
        $id = $field->id;
        $sql = "DELETE FROM {$tableNme} WHERE {$id}=?";

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

    protected function fetch_by_owner($reference){

        $field = new FieldTable();
        $tableName = $field->table;
        $id = $field->id;
        // $name = $field->name;
        // $type = $field->type;
        $artistId = $field->artistId;

        $sql = "SELECT {$id} FROM {$tableName} WHERE {$artistId}=?";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $reference);

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

    protected function check_art_availability($name, $type, $artistId){

        $field = new FieldTable();
        $tableName = $field->table;
        $name = $field->name;
        $type = $field->type;
        $artistId = $field->artistId;

        $sql = "SELECT {$name}, {$type} FROM {$tableName} WHERE {$name}=? AND {$type}=?  AND {$artistId}=? LIMIT 1";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $type, $artistId);

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

    protected function add_new_art($arrayValues){

        if(sizeof($arrayValues) < 1){
            $this->error = "There is no value to insert.";
            return false;
        }

        $field = new FieldTable;
        $tableName = $field->table;

        $attributes = "";
        $values = array();

        foreach ($arrayValues as $key => $value) {
            if (isset($field->$key)) {
                $attributes .= $field->$key.",";
                $values[] = $value;
            }
        }
        
        $questionMarks = '?'.str_repeat(',?', count($arrayValues)-1);
        $attributes = substr($attributes,0,strlen($attributes)-1);

        $sql = "INSERT INTO {$tableName} ($attributes) VALUES ($questionMarks);";

        $parameters = str_repeat('s', count($arrayValues));

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param($parameters, ...$values);

        if(!$stmt->execute()){ 
            $this->error = "wrong SQL Statement.";
            return false;
        }

        $stmt->close();
        $conn->close();

        return true;
    }

    protected function search_content($text){

        $field = new FieldTable();
        $artistField = new ArtistField();

        $tableName = $field->table;
        $id = $field->id;
        $name = $field->name;
        $type = $field->type;
        $artist = $field->artistId;

        $tbArtist = $artistField->table;
        $artistId = $tbArtist.'.'.$artistField->id;
        $artistFirstName = $tbArtist.'.'.$artistField->firstName;
        $artistLastName = $tbArtist.'.'.$artistField->lastName;


        // $sql = "SELECT * FROM {$tableName} WHERE {$name} LIKE concat(?, '%') 
        // OR {$type} LIKE concat(?, '%') OR {$artistId} LIKE concat(?, '%');";

        $sql = "SELECT {$id}, {$name}, {$type}, {$artist}, 
        concat({$artistFirstName}, ' ', {$artistLastName}) as {$field->author}
        FROM $tableName
        JOIN $tbArtist ON {$artist} = {$artistId}  
        WHERE {$name} LIKE concat(?, '%') 
        OR $type LIKE concat(?, '%') OR {$artistFirstName} LIKE concat(?, '%')
        OR {$artistLastName} LIKE concat(?, '%')
        GROUP BY {$name} ASC";

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