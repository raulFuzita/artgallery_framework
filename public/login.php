<?php 
    include_once('./includes/session.php');
    include('./includes/header.php');
?>

<div class="container">
    
    <h1>Login</h1>

    <form class="panel" action="../App/Controller/User/Login.Controller.php" method="post">
        <input class="field" type="text" name="credential" value="CCT">
        <input class="field" type="password" name="password" value="Dublin">
        <input type="submit" value="Login">
    </form>
    <a href="./signup.php">Signup</a>

</div>

<?php include('./includes/footer.php'); ?>