<?php

namespace App\Controller\Art\Arts;

use App\Classes\User\FieldTable;
use App\Model\Art\Arts\ArtLoadArts;
use App\Model\Art\Features\FeaturesModel;
use App\Model\Art\Like\ArtLike;
use App\View\Art\show\ShowArts;
use App\View\Art\show\ShowArtsPanel;

include_once('../../../includes/session.php');
include('../../../../autoloader.php');
// session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET['page']) AND isset($_SESSION['permission'])) {

    $admin = FieldTable::Admin;
    $customer = FieldTable::User;

    $page = (isset($_GET['page'])) ? $_GET['page'] : 0;
    $userId = (isset($_SESSION['userId'])) ? $_SESSION['userId'] : 0;

    $features = new FeaturesModel();

    $like = new ArtLike();
    $like->setUserID($userId);
    $like->allMyLikes();
    $features->like = $like;

    $load = new ArtLoadArts;
    $load->setCurrentPage($page);

    if($load->getNext()){
    
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
        echo $load->getError();
        echo "<br>Problem with SQL statement or there is no page set!";
        echo "<br>Page value: ".$load->getCurrentPage();
        echo "<br>GET value: ".$page;
    }

} else {
    echo "Request method is not a GET, GET doesn't have page variable.";
}

