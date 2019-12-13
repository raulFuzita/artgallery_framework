<?php

/*
 * TABLE OF RETURNS
 * 
 * Artist inexistent: artterror=artinexistent
 * User exist: arterror=artexist
 * Inexistent field: required=emptyfield
 * Password and Confirm password don't match: passworderror=nomatch
 * SQL problem or no valid values: fatalerror=sqlproblem&novalues
 * Data has been updated: update=successfully
 */

namespace App\Controller\Art;

use App\Model\Art\ArtUpdate;

include_once('../../includes/session.php');
include('../../../autoloader.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // session_start();

    $reference = (isset($_POST['idArt'])) ? $_POST['idArt'] : ""; // Real art
    $name = (isset($_POST['name'])) ? $_POST['name'] : "";
    $type = (isset($_POST['type'])) ? $_POST['type'] : "";
    $artistId = (isset($_POST['artistId'])) ? $_POST['artistId'] : "";

    $update = new ArtUpdate();

    if($update->require_properties($reference, $name, $type)){

        $update->setReference($reference)->
        setName($name)->
        setType($type)->setArtistId($artistId);

        if (!$update->verifyArt()) {
            header("location: ../../../public/edit_art.php?idArt=$reference&arterror=artinexistent");
            exit();
        } else {
            
            if(!$update->hasChanged()){
                header("location: ../../../public/edit_art.php?idArt=$reference");
                exit();
            } else {
                    
                if(!$update->updateData()){
                    header("location: ../../../public/edit_art.php?idArt=$reference&fatalerror=sqlproblem&novalues");
                    exit();
                } else {
                    header("location: ../../../public/edit_art.php?idArt=$reference&update=successfully");
                }
            }
        }

    } else {
        header("location: ../../../public/edit_art.php?idArt=$reference&required=emptyfield");
        exit();
    }
    
} else {
    header("location: ../../../public/edit_art.php?");
    exit();
}
