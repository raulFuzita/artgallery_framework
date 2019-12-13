<?php
    use App\View\Art\ViewArt;
    use App\View\Art\ViewFeatures;

    include_once('./includes/session.php');
    require('../App/Controller/Art/Features/LoadFeatures.Controller.php');
    include('./includes/header.php');
?>

<div class="container">

    <h1>View a Piece of Art</h1>

    <div class="panel">

        <?php
            $pieceOfArt = new ViewArt();
            if (!$pieceOfArt->showYourself($features)) {
                echo "<div>Sorry, data unavailable!</div>";
            }

            $featuresOfArt = new ViewFeatures;
            if (!$featuresOfArt->showYourself($features)) {
                echo "<div>Sorry, data unavailable!</div>";
            }
        ?>
        
    </div>

    <?php
    
        // Return to the right page
        $link = "./arts.php";
        
        if(isset($_GET['favorite'])){
            $link = "./".$_GET['favorite'].".php";
        } else if(isset($_GET['arts'])){
            $link = "./".$_GET['arts'].".php";
        }

        echo "<a href='{$link}'>Back</a>";
    ?>

</div>

<?php include('./includes/footer.php'); ?>