<?php

    use App\View\User\UserSettings;

    include_once('./includes/session.php');
    require('../App/Controller/User/LoadSettings.Controller.php');
    include('./includes/header.php');
?>

<div class="container">

    <h1>User Settings</h1>

    <form class="panel" action="../App/Controller/User/Update.Controller.php" method="post">

        <?php
            $user = new UserSettings();
            if (!$user->showYourself($account)) {
                echo "<div>Sorry, data unavailable!</div>";
            }
        ?>

        <input type="submit" value="Update">
    </form>

    <a href="./dashboard.php">Dashboard</a>

</div>
    
<?php
    include('./includes/footer.php');
?>