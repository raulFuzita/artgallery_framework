<?php
    include_once('./includes/session.php');
    include('./includes/header.php');
?>

<div class="container">

    <h1>Create Artist</h1>

    <form class="panel" action="../App/Controller/Artist/Create.Controller.php" method="post">
        <input class="field" type="text" name="first-name" placeholder="First Name" value="john">
        <input class="field" type="text" name="last-name" placeholder="Last Name" value="doe">
        <input class="field" type="text" name="website" placeholder="website" value="www.modernart.com">
        <hr>
        <input class="field" type="text" name="street" placeholder="street" value="Somewhere">
        <input class="field" type="text" name="city" placeholder="city" value="Dublin">
        <input class="field" type="text" name="country" placeholder="country" value="Ireland">
        <input type="submit" value="Create">
    </form>
    <a href="./dashboard.php">Dashboard</a>

</div>

<?php include('./includes/footer.php'); ?>