<?php

namespace App\Model\User;


class UserSignup extends UserModel {

    private $data;

    public function verifyUser(){
        $this->data = $this->fetch_user_row($this->reference, $this->email);
        return (sizeof($this->data) > 0) ? true : false;
    }

    public function addUser(){
        $values = array(
            'firstName' => $this->firstName, 
            'lastName' => $this->lastName, 
            'username' => $this->username, 
            'email' => $this->email,
            'password' => $this->password, 
            'permission' => $this->permission
        );

        return $this->add_new_user($values);
    }

    public function is_user_available(){
        return $this->check_user_availability($this->username, $this->email);
    }

    public function authenticate(){
        return ($this->password == $this->confirmPassword) ? true : false;
    }

    public function setUsername($username){
        $username = $this->connect()->real_escape_string($username);
        if (preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $this->username = $username;
        } else {
            $this->error = "Username is invalid. Just letters and numbers are allowed.";
        }
        return $this;
    }

    public function setEmail($email){
        $email = $this->connect()->real_escape_string($email);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
        } else {
            $this->error = "Email format is invalid.";
        }
        return $this;
    }
    
    public function getRow(){return $this->data;}
    public function getError(){return $this->error;}
}