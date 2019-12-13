<?php

namespace App\View\User\show;

use App\Classes\User\FieldTable;
use App\Model\User\Accounts\UserLoadAccounts;

class ShowAccounts {

    public function showYourself($users){

        if (!$users instanceof UserLoadAccounts) {
            return false;
        }

        if($users->dataSize() > 0){

            $field = new FieldTable();

            $id = $field->id;
            $firstName = $field->firstName;
            $lastName = $field->lastName;
            $username = $field->username;
            $email = $field->email;
            $street = $field->street;
            $city = $field->city;
            $country = $field->country;
            $permission = $field->permission;
                
        
            // Table Header
            echo "
                <table class='user-list'>
                    <tr>
                        <th>Name</th>
                        <th>Username</th>
                        <th>email</th>
                        <th>permission</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
            ";

            // Table Body
            foreach ($users->getAll() as $row) {
            
                echo "
                    <tr>
                        <td>{$row[$firstName]} {$row[$lastName]}</td>
                        <td>{$row[$username]}</td>
                        <td>{$row[$email]}</td>
                        <td>{$row[$permission]}</td>
                        <td>{$row[$street]} {$row[$city]} {$row[$country]}</td>
                        <td>
                            <a class='btn-logout' href='../App/Controller/User/Delete.Controller.php?userId={$row[$id]}'>
                                Delete
                            </a>
                            <a class='btn-edit' href='./edit_admin.php?userId={$row[$id]}'>
                                Edit
                            </a>
                        </td>
                    </tr>
                ";
            }
            // The end of the table
            echo "</table>";
            return true;
        }
        return false;
    }
}