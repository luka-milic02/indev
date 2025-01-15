<?php

define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);

include(BASE_PATH . '/panel/includes/config.php');
include(BASE_PATH . '/panel/includes/database.php');
include(BASE_PATH . '/panel/includes/functions.php');
include(BASE_PATH . '/panel/includes/header.php');

//Security Check
secure();

?>
<div class="container">
    <h1>Dashboard</h1>
    <ul>
        <li><a href="users.php">User Management</a></li>
        <li><a href="posts.php">Post Management</a></li>
    </ul>
</div>
<?php include('includes/footer.php'); ?>