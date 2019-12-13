<?php

namespace App\Controller\Artist;

use App\Model\Art\ArtEdit;
use App\Model\Art\Features\FeaturesModel;
use App\Model\Artist\ArtistEdit;

include('../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged'])) {

    $artId = (isset($_GET['idArt'])) ? $_GET['idArt'] : false;
    $artistId = (isset($_GET['idArtist'])) ? $_GET['idArtist'] : false;
    // $userId = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : "";

    $features = new FeaturesModel();

    $art = new ArtEdit($artId);
    $art->verifyArt();
    $features->art = $art;

    $artist = new ArtistEdit($artistId);
    $artist->verifyArtist();
    $features->artist = $artist;
    
}