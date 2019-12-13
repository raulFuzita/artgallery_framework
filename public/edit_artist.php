<?php
    use App\View\Artist\ArtistSettings;

    include_once('./includes/session.php');
    require('../App/Controller/Artist/Edit.Controller.php');
    include('./includes/header.php');
?>

<div class="container">

    <h1>Edit Artist</h1>

    <form class="panel" action="../App/Controller/Artist/Update.Controller.php" method="post">

    <?php
        $artist = new ArtistSettings();
        if (!$artist->showYourself($account)) {
            echo "<div>Sorry, data unavailable!</div>";
        }
    ?>

    <input type="submit" value="Update">
    </form>
    <a href="./artists.php">Artists</a>
    
</div>
    
<?php
    include('./includes/footer.php');
?>