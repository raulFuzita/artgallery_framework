<?php

namespace App\Controller\Art;

use App\Model\Art\ArtEdit;
use App\Model\Art\Features\FeaturesModel;
use App\Model\Artist\Artists\ArtistLoadArtists;

include('../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged']) AND $_SERVER['REQUEST_METHOD'] == 'GET') {

    $id = (isset($_GET['idArt'])) ? $_GET['idArt'] : false;

    $features = new FeaturesModel();

    $art = new ArtEdit($id);
    $art->verifyArt();
    $features->art = $art;

    $artists = new ArtistLoadArtists();
    $artists->fetchAllReferences();
    $features->artist = $artists;
}
