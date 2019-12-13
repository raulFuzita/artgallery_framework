<?php

namespace App\Controller\Artist;

use App\Model\Artist\ArtistEdit;

include('../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged']) AND $_SERVER['REQUEST_METHOD'] == 'GET') {

    $id = (isset($_GET['idArtist'])) ? $_GET['idArtist'] : false;

    $account = new ArtistEdit($id);
    $account->verifyArtist();

}
