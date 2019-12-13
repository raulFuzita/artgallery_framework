<?php

namespace App\Classes\Like;

use App\Classes\Database\DB;

class Like extends DB {

    protected $error;

    protected function count_all(){

        $field = new FieldTable();

        $tableName = $field->table;

        $sql = "SELECT count(*) as 'total' FROM {$tableName}";
        $result = $this->connect()->query($sql);

        $counter = $result->fetch_assoc();

        return $counter['total'];
    }

    protected function get_all_likes(){

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

    protected function like_an_item($userId, $artId){

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

    protected function count_likes($where, $who){

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

    protected function my_stuff($myStuff, $where, $who){

        $field = new FieldTable();
        $tableName = $field->table;

        if(isset($field->$myStuff) OR isset($field->$where)){
            $this->error = "Column(s) inexistent: [0] => $myStuff, [1] => $where";
        }

        $sql = "SELECT {$myStuff} FROM {$tableName} WHERE {$where} = ?";
        
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

    protected function user_has_like($userId, $artId){

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

    protected function delete_like($userId, $artId){

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

}