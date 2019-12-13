<?php

/*
 * TABLE OF RETURNS
 * 
 * Artist exist: arterror=artexist
 * Failed to create an artist: createartist=error
 * Artist create successfully:  createuser=successfully
 * Required fields: required=emptyfield
 * 
 */

namespace App\Controller\Artist;

use App\Model\Artist\ArtistCreate;

include_once('../../includes/session.php');
include('../../../autoloader.php');
// session_start();

if (isset($_SESSION['user-logged']) AND isset($_SESSION['permission'])) {

    $firstName = (isset($_POST['first-name'])) ? $_POST['first-name'] : "";
    $lastName = (isset($_POST['last-name'])) ? $_POST['last-name'] : "";
    $website = (isset($_POST['website'])) ? $_POST['website'] : "";
    $street = (isset($_POST['street'])) ? $_POST['street'] : "";
    $city = (isset($_POST['city'])) ? $_POST['city'] : "";
    $country = (isset($_POST['country'])) ? $_POST['country'] : "";

    $create = new ArtistCreate();

    $create->setFirstName($firstName)->
        setLastName($lastName)->
        setWebsite($website)->
        setStreet($street)->
        setCity($city)->
        setCountry($country);
    
    if(!$create->require_properties($firstName, $lastName)){
        header("location: ../../../public/create_artist.php?required=emptyfield");
        exit();
    } else {

        if ($create->is_artist_available() > 0) {
            header("location: ../../../public/create_artist.php?artisterror=artistexist");
            exit();
        } else {
    
            if (!$create->addArtist()) {
                header("location: ../../../public/create_artist.php?createartist=error");
                exit();
            } else {
                // **************  ARTIST CREATED SUCCESSFULLY ****************
                header("location: ../../../public/create_artist.php?creatartist=successfully");
                exit();
            }
                
        } // End available
    }

    
} else {
    header("location: ../../../public/create_artist.php");
    exit();
}