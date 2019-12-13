<?php

namespace App\Classes\User;

use App\Classes\Database\DB;

class User extends DB {

    protected $error;

    protected function count_all(){

        $field = new FieldTable();

        $tableName = $field->table;

        $sql = "SELECT count(*) as 'total' FROM {$tableName}";
        $result = $this->connect()->query($sql);

        $counter = $result->fetch_assoc();

        return $counter['total'];
    }

    protected function get_all_users($start, $limit){

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

    protected function add_new_user($arrayValues){

        if(sizeof($arrayValues) < 1){
            $this->error = "There is no value to insert.";
            return false;
        }

        $field = new FieldTable();
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

    protected function fetch_user_row($username, $email){

        $field = new FieldTable();
        $tableName = $field->table;

        $sql = "SELECT * FROM {$tableName} WHERE {$field->username}=? OR {$field->email}=?";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ss", $username, $email);

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

    protected function fetch_by_id($userId){

        $field = new FieldTable();
        $tableName = $field->table;

        $sql = "SELECT * FROM {$tableName} WHERE {$field->id}=?";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userId);

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

    protected function check_user_availability($username, $email){

        $field = new FieldTable();
        $tableName = $field->table;
        $username = $field->username;
        $email = $field->email;

        $sql = "SELECT {$username}, {$email} FROM {$tableName} WHERE {$username}=? OR {$email}=? LIMIT 1";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $email);

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

    protected function delete_user($userId){

        $field = new FieldTable();
        $tableNme = $field->table;
        $id = $field->id;
        $sql = "DELETE FROM {$tableNme} WHERE {$id}=?";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("s", $userId);

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

    protected function authenticate_password($password, $row){
        
        $field = new FieldTable();

        $passwordCompare = $field->password;

        if(!is_array($row)){
            $this->error = "Second parameter is not an array!";
            return false;
        }

        if($password == $row[$passwordCompare]){
            return true;
        }

        $this->error = "Password incorrect";
        return false;
    }

    protected function search_content($text){

        $field = new FieldTable();

        $tableName = $field->table;
        $firstName = $field->firstName;
        $lastName = $field->lastName;
        $username = $field->username;
        $email = $field->email;

        $sql = "SELECT * FROM {$tableName} WHERE {$firstName} LIKE concat(?, '%') 
        OR {$lastName} LIKE concat(?, '%') OR {$username} LIKE concat(?, '%') 
        OR {$email} LIKE concat(?, '%');";

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