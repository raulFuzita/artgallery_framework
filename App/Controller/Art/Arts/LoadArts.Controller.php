<?php

/**
 * 
 * There is no data: error=nodata
 * 
 * 
 */
namespace App\Controller\Art\Arts;

use App\Classes\User\FieldTable;
use App\Model\Art\Arts\ArtLoadArts;
use App\Model\Art\Features\FeaturesModel;
use App\Model\Art\Like\ArtLike;
use App\View\Art\show\ShowArts;
use App\View\Art\show\ShowArtsPanel;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');


if (isset($_SESSION['user-logged']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;
    $customer = FieldTable::User;

    $userId = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : 0;

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
    header("location: ../../../../public/arts.php");
    exit();
}