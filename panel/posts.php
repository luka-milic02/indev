<?php

//Includes
include('includes/config.php');
include('includes/database.php');
include('includes/functions.php');
include('includes/header.php');

//Security Check
secure();

?>
<div class="container">
    <h1>Post Management</h1>
    <ul>
        <li><a href="users.php">User Management</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
    </ul>
</div>
<?php include('includes/footer.php'); ?>