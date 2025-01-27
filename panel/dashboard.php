<?php


//Includes
include(__DIR__ . '/../panel/includes/config.php');

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