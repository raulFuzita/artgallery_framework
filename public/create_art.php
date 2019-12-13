<?php
    use App\View\Art\AllArtists;

    include_once('./includes/session.php');
    require('../App/Controller/Art/LoadOwner.Controller.php');
    include('./includes/header.php');
?>

<div class="container">

    <h1>Create Art</h1>

    <form class="panel" action="../App/Controller/Art/Create.Controller.php" method="post">
        <input class="field" type="text" name="name" placeholder="First Name" value="Mountain">
        <input class="field" type="text" name="type" placeholder="Last Name" value="modern art">

        <select name="artist" class="field">
        <?php
            $artists = new AllArtists();
            if (!$artists->showYourself($accounts)) {
                echo "<div>Sorry, data unavailable!</div>";
            }
        ?>
        </select>

        <input type="submit" value="Create">
    </form>
    <a href="./dashboard.php">Dashboard</a>

</div>

<?php include('./includes/footer.php'); ?>