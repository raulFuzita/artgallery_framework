<?php

namespace App\View\User;

use App\Model\User\UserLoadSettings;

class UserSettings {


    public function showYourself($user){

        if (!$user instanceof UserLoadSettings) {
            return false;
        }

        if($user->dataSize() > 0){

            $firstName = $user->get('firstName');
            $lastName = $user->get('lastName');
            $username = $user->get('username');
            $email = $user->get('email');
            $street = $user->get('street');
            $city = $user->get('city');
            $country = $user->get('country');
                
            echo "

                <input class='field' type='text' name='first-name' placeholder='First Name' value='$firstName' require>
                <input class='field' type='text' name='last-name' placeholder='Last Name' value='$lastName'>
                <input class='field' type='text' name='username' placeholder='Username' value='$username'>
                <input class='field' type='text' name='email' placeholder='Email' value='$email'>
            
                <input class='field' type='password' name='password' placeholder='password'>
                <input class='field' type='password' name='confirm-password' placeholder='confirm password'>
                
                <hr>
            
                <input class='field' type='text' name='street' placeholder='Street' value='$street'>
                <input class='field' type='text' name='city' placeholder='City' value='$city'>
                <input class='field' type='text' name='country' placeholder='Country' value='$country'>
                
             ";
            return true;
        }
        return false;

    }
}