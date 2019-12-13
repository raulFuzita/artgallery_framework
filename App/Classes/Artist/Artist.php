<?php

namespace App\Classes\Artist;

use App\Classes\Database\DB;

class Artist extends DB {

    protected $error;

    protected function count_all(){

        $field = new FieldTable();

        $tableName = $field->table;

        $sql = "SELECT count(*) as 'total' FROM {$tableName}";
        $result = $this->connect()->query($sql);

        $counter = $result->fetch_assoc();

        return $counter['total'];
    }

    protected function get_all_artist($start, $limit){

        $field = new FieldTable();

        $tableName = $field->table;
        $firstName = $field->firstName;

        $limitItems = ($start >= 0 AND $limit != 0) ? " LIMIT {$start},{$limit}" : "";

        $sql = "SELECT * FROM {$tableName} ORDER BY {$firstName} ASC ".$limitItems;

        $result = $this->connect()->query($sql);

        $numRows = $result->num_rows;

        if($numRows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
    }

    protected function fetch_artist_reference(){

        $field = new FieldTable();
        $tableName = $field->table;
        $id = $field->id;
        $firstName = $field->firstName;
        $lastName = $field->lastName;

        $sql = "SELECT {$id}, {$firstName}, {$lastName} FROM {$tableName} ORDER BY {$firstName} ASC";

        $result = $this->connect()->query($sql);

        $numRows = $result->num_rows;

        if($numRows > 0){
            while($row = $result->fetch_assoc()){
                $data[] = $row;
            }
            return $data;
        }
    }

    protected function user_update($changeWhere, $arrayValues){

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

    protected function add_new_artist($arrayValues){

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

    protected function fetch_artist_row($id, $firstName, $lastName){

        $field = new FieldTable();
        $tableName = $field->table;

        $sql = "SELECT * FROM {$tableName} WHERE {$field->id}=? OR {$field->firstName}=? AND {$field->lastName}=?";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $id, $firstName, $lastName);

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

    protected function check_artist_availability($firstName, $lastName){

        $field = new FieldTable();
        $tableName = $field->table;
        $firstName = $field->firstName;
        $lastName = $field->lastName;

        $sql = "SELECT {$firstName}, {$lastName} FROM {$tableName} WHERE {$firstName}=? AND {$lastName}=? LIMIT 1";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $firstName, $lastName);

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

    protected function delete_artist($artistId){

        $field = new FieldTable();
        $tableNme = $field->table;
        $id = $field->id;
        $sql = "DELETE FROM {$tableNme} WHERE {$id}=?";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $artistId);

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

        $tableName = $field->table;

        $firstName = $field->firstName;
        $lastName = $field->lastName;
        $website = $field->website;

        $sql = "SELECT * FROM {$tableName} WHERE {$firstName} LIKE concat(?, '%') 
        OR {$lastName} LIKE concat(?, '%') OR {$website} LIKE concat(?, '%');";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("sss", $text, $text, $text);

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