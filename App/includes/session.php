<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

// exit();

// if(!isset($_SESSION['user-logged'])){
//     header("Location: ./public/login.php");
// } else {
//     header("Location: ./public/dashboard.php");    
// }