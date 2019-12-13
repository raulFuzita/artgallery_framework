<?php

namespace App\Controller\Artist\Artists;

use App\Classes\User\FieldTable;
use App\Model\Artist\Artists\ArtistLoadArtists;
use App\View\Artist\show\ShowArtists;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['search']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;

    if($_SESSION['permission'] == $admin){
    
        $search = $_GET['search'];

        $load = new ArtistLoadArtists();
        $load->setText($search);
    
        if($load->search()){

            $show = new ShowArtists();
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

