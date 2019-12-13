<?php

/*
 * TABLE OF RETURNS
 * 
 * Artist inexistent: artisterror=artistinexistent
 * User exist: usererror=userexist
 * Inexistent field: required=emptyfield
 * Password and Confirm password don't match: passworderror=nomatch
 * SQL problem or no valid values: fatalerror=sqlproblem&novalues
 * Data has been updated: update=successfully
 */

namespace App\Controller\Artist;

use App\Model\Artist\ArtistUpdate;

include('../../../autoloader.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    session_start();

    $reference = (isset($_POST['idArtist'])) ? $_POST['idArtist'] : ""; // Real art
    $firstName = (isset($_POST['first-name'])) ? $_POST['first-name'] : "";
    $lastName = (isset($_POST['last-name'])) ? $_POST['last-name'] : "";
    $website = (isset($_POST['website'])) ? $_POST['website'] : "";
    $street = (isset($_POST['street'])) ? $_POST['street'] : "";
    $city = (isset($_POST['city'])) ? $_POST['city'] : "";
    $country = (isset($_POST['country'])) ? $_POST['country'] : "";

    $update = new ArtistUpdate();

    if($update->require_properties($reference, $firstName, $lastName)){

        $update->setReference($reference)->
        setFirstName($firstName)->
        setLastName($lastName)->
        setWebsite($website)->
        setStreet($street)->
        setCity($city)->
        setCountry($country);

        if (!$update->verifyArtist()) {
            header("location: ../../../public/edit_artist.php?idArtist={$reference}&artisterror=artistinexistent");
            exit();
        } else {
            
            if(!$update->hasChanged()){
                header("location: ../../../public/edit_artist.php?idArtist={$reference}");
                exit();
            } else {
                    
                if(!$update->updateData()){
                    header("location: ../../../public/edit_artist.php?idArtist={$reference}&fatalerror=sqlproblem&novalues");
                    exit();
                } else {
                    header("location: ../../../public/edit_artist.php?update=successfully&idArtist={$reference}");
                }
            }
        }

    } else {
        header("location: ../../../public/edit_artist.php?idArtist={$reference}&required=emptyfield");
        exit();
    }
    
} else {
    header("location: ../../../public/edit_artist.php");
    exit();
}
