<?php

namespace App\Controller\Art\Favorite;

use App\Model\Art\Favorite\ArtLoadFavorite;
use App\View\Art\show\ShowFavorites;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');
// session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['page'])) {

    if(isset($_SESSION['permission'])){
    
        $page = (isset($_GET['page'])) ? $_GET['page'] : 0;

        $userId = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : 0;

        $load = new ArtLoadFavorite();
        $load->setID($userId);
        $load->setCurrentPage($page);
    
        if($load->getNext()){
    
            $show = new ShowFavorites();
            $show->showYourself($load);
    
        } else {
            echo $load->getError();
            echo "<br>Problem with SQL statement or there is no page set!";
            echo "<br>Page value: ".$load->getCurrentPage();
            echo "<br>GET value: ".$page;
        }
    
    } else {
        echo "You don't have permission!";
    }

} else {
    echo "Request method is not a GET, GET doesn't have page variable.";
}

