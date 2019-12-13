<?php
    use App\View\User\AdminSettings;

    include_once('./includes/session.php');
    require('../App/Controller/User/LoadAdminSettings.Controller.php');
    include('./includes/header.php');
?>

<div class="container">

    <h1>Edit Admin</h1>

    <form class="panel" action="../App/Controller/User/UpdateAdmin.Controller.php" method="post">

        <?php
            $user = new AdminSettings();
            if (!$user->showYourself($account)) {
                echo "<div>Sorry, data unavailable!</div>";
            }
        ?>

        <input type="submit" value="Update">
    </form>

    <a href="./accounts.php">Back</a>

</div>
    
<?php
    include('./includes/footer.php');
?>