<?php
    include_once('./includes/session.php');
    include('./includes/header.php');
?>

<div class="container">

    <h1>My Gallery</h1>

    <form action="" method="post">

        <a href="./dashboard.php">Dashboard</a>
        <!-- When you type something searchContent method fires passing 
                the content typed as an argument.
            -->
        <input class="searchBox" type="text" placeholder="Search" onkeyup="searchContent(this.value)">
            
        <div id="ajax-content"></div>
        <div class="my-3" id="numPagination"></div>

    </form>

</div>

<script src="../resources/Pagination_Bootstrap/Pagination.ajax.js"></script>
<script src="../resources/Pagination_Bootstrap/Pagination.js"></script>
<script src="./js/art/load_favorites.js"></script>

<?php include('./includes/footer.php'); ?>