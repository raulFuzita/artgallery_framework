<?php

/**
 * 
 * There is no data: error=nodata
 * 
 * 
 */

namespace App\Controller\Artist\Artists;

use App\Classes\User\FieldTable;
use App\Model\Artist\Artists\ArtistLoadArtists;
use App\View\Artist\show\ShowArtists;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');

if (isset($_SESSION['user-logged']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;

    if($_SESSION['permission'] == $admin){

        $load = new ArtistLoadArtists();

        if($load->fetchAllArtists()){

            $show = new ShowArtists();
            $show->showYourself($load);

        }

    } else {
        echo "Oh, that's awkward!<br>No data to display.";
    }

} else {
    header("location: ../../../../public/artists.php");
    exit();
}