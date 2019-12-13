<?php

namespace App\Controller\Art\Features;

use App\Classes\User\FieldTable;
use App\Model\Art\Arts\ArtLoadArts;
use App\Model\Art\Features\FeaturesModel;
use App\Model\Art\Like\ArtLike;
use App\View\Art\show\ShowArts;
use App\View\Art\show\ShowArtsPanel;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;
    $customer = FieldTable::User;

    $id = (isset($_GET['idArt'])) ? $_GET['idArt'] : false;
    $userId = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : "";

    $like = new ArtLike();
    $like->setArtID($id);
    $like->setUserID($userId);

    if($like->userHasLike() > 0){
        $like->dislike();
    } else {
        if(!$like->like_art()){
            echo "Sorry, like button didn't work. Refresh the page or contact the administrator";
        }
    }

    $features = new FeaturesModel();

    $like = new ArtLike();
    $like->setUserID($userId);
    $like->allMyLikes();
    $features->like = $like;

    $load = new ArtLoadArts();

    if($load->fetchAllArts()){

        if($_SESSION['permission'] == $admin){

            $show = new ShowArtsPanel();
            $show->showYourself($load);

        } elseif($_SESSION['permission'] == $customer){

            $features->art = $load;

            $show = new ShowArts();
            $show->showYourself($features);

        } else {
            echo "You don't have permission!";
        }

    } else {
        echo "Oh, that's awkward!<br>No data to display.";
    }


} else {

}