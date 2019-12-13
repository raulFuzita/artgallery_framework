<?php

namespace App\Controller\Art;

use App\Classes\User\FieldTable;
use App\Model\Artist\Artists\ArtistLoadArtists;

include('../autoloader.php');

if (isset($_SESSION['user-logged']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;

    if($_SESSION['permission'] == $admin){

        $accounts = new ArtistLoadArtists();
        $accounts->fetchAllReferences();
    }

}
