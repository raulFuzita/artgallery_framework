<?php
    include_once('./includes/session.php');
    include('./includes/header.php');
?>

<div class="container">

    <h1>Signup</h1>

    <form class="panel" action="../App/Controller/User/Signup.Controller.php" method="post">
        <input class="field" type="text" name="first-name" placeholder="First Name" value="john">
        <input class="field" type="text" name="last-name" placeholder="Last Name" value="doe">
        <input class="field" type="text" name="username" placeholder="Username" value="jdoe">
        <input class="field" type="text" name="email" placeholder="Email" value="joe@gmail.com">
        <input class="field" type="password" name="password" placeholder="password" value="123">
        <input class="field" type="password" name="confirm-password" placeholder="confirm password" value="123">
        <input type="submit" value="Signup">
    </form>
    <a href="./login.php">Login</a>

</div>
    
<?php include('./includes/footer.php'); ?>