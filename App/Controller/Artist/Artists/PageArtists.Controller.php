<?php

namespace App\Controller\Artist\Artists;

use App\Classes\User\FieldTable;
use App\Model\Artist\Artists\ArtistLoadArtists;
use App\View\Artist\show\ShowArtists;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['page']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;

    if($_SESSION['permission'] == $admin){
    
        $page = $_GET['page'];

        $load = new ArtistLoadArtists();
        $load->setCurrentPage($page);
    
        if($load->getNext()){
    
            $show = new ShowArtists();
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

