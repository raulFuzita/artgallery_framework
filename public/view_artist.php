<?php
    use App\View\Art\ViewArtist;

    include_once('./includes/session.php');
    require('../App/Controller/Artist/ShowArtist.Controller.php');
    include('./includes/header.php');
?>

<div class="container">

    <h1>View an Artist</h1>

    <div class="panel">

        <?php
            $pieceOfArt = new ViewArtist();
            if (!$pieceOfArt->showYourself($features)) {
                echo "<div>Sorry, data unavailable!</div>";
            }
        ?>
        
    </div>

    <?php

        // Return to the right page
        $reference = (isset($_GET['idArt'])) ? "?idArt=".$_GET['idArt'] : "";
        $returnPage = "";

        if(isset($_GET['favorite'])){
            $returnPage = "&favorite=".$_GET['favorite'];
        } else if(isset($_GET['arts'])){
            $returnPage = "&arts=".$_GET['arts'];
        }

        echo "<a href='view_art.php{$reference}{$returnPage}'>Back</a>";
    ?>

</div>

<?php include('./includes/footer.php'); ?>