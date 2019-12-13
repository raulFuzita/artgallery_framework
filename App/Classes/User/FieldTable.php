<?php

namespace App\Classes\User;

final class FieldTable {

    // idUser, first_name, last_name, password, email, privilege, street, country, city, username
    public $table = "user";

    public $id = "idUser";
    public $firstName = "first_name";
    public $lastName = "last_name";
    public $username = "username";
    public $email = "email";
    public $password = "password";

    public $permission = "privilege";

    /* Attention!! These two values belongs to the values of the permission 
    column in the database. Check the ENUM values.*/
    const Admin = "admin";
    const User = "user";

    public $street = "street";
    public $city = "city";
    public $country = "country";

}