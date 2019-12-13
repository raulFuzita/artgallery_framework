<?php

namespace App\Controller\Art\Favorite;

use App\Model\Art\Favorite\ArtLoadFavorite;
use App\View\Art\show\ShowFavorites;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');
// session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['search'])) {

    if(isset($_SESSION['permission'])){
    
        $search = (isset($_GET['search'])) ? $_GET['search'] : "";
        $userId = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : 0;

        $load = new ArtLoadFavorite();
        $load->setID($userId);
        $load->setText($search);
    
        if($load->search()){

            $show = new ShowFavorites();
            $show->showYourself($load);
    
        } else {
            echo "<br>Problem with SQL statement or there is no text to search!";
            echo "<br>Search value: ".$load->getText();
            echo "<br>GET value: ".$search;
        }
    
    } else {
        echo "You don't have permission!";
    }

} else {
    echo "Request method is not a GET, GET doesn't have page variable.";
}

