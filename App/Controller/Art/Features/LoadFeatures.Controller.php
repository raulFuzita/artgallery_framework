<?php

namespace App\Controller\Art\Features;

use App\Model\Art\ArtEdit;
use App\Model\Art\Favorite\ArtLoadFavorite;
use App\Model\Art\Features\FeaturesModel;
use App\Model\Art\Like\ArtLike;

include_once('./includes/session.php');
include('../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged'])) {

    $id = (isset($_GET['idArt'])) ? $_GET['idArt'] : false;
    $userId = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : "";

    $features = new FeaturesModel();

    $art = new ArtEdit($id);
    $art->verifyArt();
    $features->art = $art;

    $like = new ArtLike();
    $like->setArtID($id);
    $like->setUserID($userId);
    $features->like = $like;

    $favorite = new ArtLoadFavorite();
    $favorite->setArtID($id);
    $favorite->setUserID($userId);
    $features->favorite = $favorite;
}