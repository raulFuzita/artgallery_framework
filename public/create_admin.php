<?php
    include_once('./includes/session.php');
    include('./includes/header.php');
?>

<div class="container">

    <h1>Create Admin</h1>

    <form class="panel" action="../App/Controller/User/CreateAdmin.Controller.php" method="post">
        <input class="field" type="text" name="first-name" placeholder="First Name" value="Will">
        <input class="field" type="text" name="last-name" placeholder="Last Name" value="Smith">
        <input class="field" type="text" name="username" placeholder="Username" value="wsmith">
        <input class="field" type="text" name="email" placeholder="Email" value="will@gmail.com">
        <input class="field" type="password" name="password" placeholder="password" value="123">
        <input class="field" type="password" name="confirm-password" placeholder="confirm password" value="123">
        <input type="submit" value="Create">
    </form>

    <a href="./dashboard.php">Dashboard</a>

</div>
    
<?php include('./includes/footer.php'); ?>