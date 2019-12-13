<?php

namespace App\Model\User;

use App\Classes\User\User;

class UserModel extends User {

    protected $firstName;
    protected $lastName;
    protected $username;
    protected $email;
    protected $password;
    protected $confirmPassword;
    protected $permission;
    protected $street;
    protected $city;
    protected $country;

    public function require_properties(){
        $methods = func_get_args();
        foreach ($methods as $key => $value) {
            if(empty($value)) return false;
        }
        return true;
    }

    public function setUsername($username){
        $this->username = $this->connect()->real_escape_string($username);
        return $this;
    }

    public function setEmail($email){
        $this->email = $this->connect()->real_escape_string($email);
        return $this;
    }

    public function setPassword($password){
        $this->password = $this->connect()->real_escape_string($password);
        return $this;
    }

    public function setConfirmPassword($confirmPassword){
        $this->confirmPassword = $this->connect()->real_escape_string($confirmPassword);
        return $this;
    }

    public function setFirstName($firstName){
        $this->firstName = $this->connect()->real_escape_string($firstName);
        return $this;
    }

    public function setLastName($lastName){
        $this->lastName = $this->connect()->real_escape_string($lastName);
        return $this;
    }

    public function setPermission($permission){
        $this->permission = $this->connect()->real_escape_string($permission);
        return $this;
    }

    public function setStreet($street){
        $this->street = $this->connect()->real_escape_string($street);
        return $this;
    }

    public function setCity($city){
        $this->city = $this->connect()->real_escape_string($city);
        return $this;
    }

    public function setCountry($country){
        $this->country = $this->connect()->real_escape_string($country);
        return $this;
    }

}