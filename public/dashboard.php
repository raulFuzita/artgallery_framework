<?php

    use App\Classes\User\FieldTable;

    include_once('./includes/session.php');
    include('../autoloader.php');
    include('./includes/header.php');

    $admin = FieldTable::Admin;
    $customer = FieldTable::User;
?>

<div class="container">
    <h1>Dashboard</h1>
    <span> Welcome 
        <?php echo ((isset($_SESSION['firstName'])) ? $_SESSION['firstName']: "Nemo")?>
    </span>
    <div class="panel">
        <ul>
        <?php
            if($_SESSION['permission'] == $admin){
                echo "
                    <li><a href='./accounts.php'>Accounts</a></li>
                    <li><a href='./artists.php'>Artists</a></li>
                    <li><a href='./create_artist.php'>Create artist</a></li>
                    <li><a href='./create_art.php'>Create art</a></li>
                    <li><a href='./create_admin.php'>Create Admin</a></li>
                    <li><a href='./art_list.php'>Test</a></li>
                    <li><a href='./arts.php'>Arts</a></li>
                ";
            } else if($_SESSION['permission'] == $customer){
                echo "<li><a href='./art_list.php'>Arts</a></li>";
            }
        ?>
            <li><a href="./my_gallery.php">My Gallery</a></li>
            <li><a href="./user_settings.php">Settings</a></li>
            <li><a href="./logout.php">Logout</a></li>
        </ul>
    </div>
</div>
    
<?php include('./includes/footer.php'); ?>