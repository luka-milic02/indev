<?php


// Define page files and configuration
$page_title = 'Dashboard';

$css_files = [
    
];

$js_files = [
    
];

// Includes
// Detect the directory
$current_dir = dirname(__FILE__);
$is_backend = strpos($current_dir, 'panel') !== false;
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
<?php include(__DIR__ . '/includes/backend_footer.php'); ?>