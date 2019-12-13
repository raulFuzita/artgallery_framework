<?php

namespace App\Classes\Database;

class DB {

    private $dbServername = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "";
    private $dbName = "marcelo";

    public function connect(){
        
        $conn = mysqli_connect($this->dbServername, $this->dbUsername, $this->dbPassword, $this->dbName);

        if(!$conn){
            die("Connection failed: ".mysqli_connect_error());
        }

        return $conn;
    }

}