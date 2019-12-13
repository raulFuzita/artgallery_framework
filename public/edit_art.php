<?php
    use App\View\Art\ArtSettings;

    include_once('./includes/session.php');
    require('../App/Controller/Art/Edit.Controller.php');
    include('./includes/header.php');
?>

<div class="container">

    <h1>Edit Art</h1>

    <form class="panel" action="../App/Controller/Art/Update.Controller.php" method="post">

    <?php
        $pieceOfArt = new ArtSettings();
        if (!$pieceOfArt->showYourself($features)) {
            echo "<div>Sorry, data unavailable!</div>";
        }
    ?>

    <input type="submit" value="Update">
    </form>
    <a href="./arts.php">Arts</a>
    
</div>
    
<?php
    include('./includes/footer.php');
?>