<?php

/*
 * TABLE OF RETURNS
 * 
 * Artist exist: arterror=artexist
 * Failed to create an artist: createart=error
 * Artist create successfully:  createart=successfully
 * Required fields: required=emptyfield
 * 
 */

namespace App\Controller\Art;

use App\Model\Art\ArtCreate;

include_once('../../includes/session.php');
include('../../../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged']) AND isset($_SESSION['permission'])) {

    // (isset($_POST[''])) ? $_POST['']: "";
    $name = (isset($_POST['name'])) ? $_POST['name']: "";
    $type = (isset($_POST['type'])) ? $_POST['type']: "";
    $artistId = (isset($_POST['artist'])) ? $_POST['artist']: "";

    $create = new ArtCreate();

    $create->setName($name)->
        setType($type)->
        setArtistId($artistId);
    
    if(!$create->require_properties($name, $type, $artistId)){
        header("location: ../../../public/create_art.php?required=emptyfield");
        exit();
    } else {

        if ($create->is_art_available() > 0) {
            header("location: ../../../public/create_art.php?arterror=artexist");
            exit();
        } else {
    
            if (!$create->addArt()) {
                header("location: ../../../public/create_art.php?createart=error");
                exit();
            } else {
                // **************  ARTIST CREATED SUCCESSFULLY ****************
                header("location: ../../../public/create_art.php?createart=successfully");
                exit();
            }
                
        } // End available
    }

    
} else {
    header("location: ../../../public/create_art.php");
    exit();
}