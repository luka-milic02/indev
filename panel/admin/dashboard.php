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
$is_backend = strpos($current_dir, 'admin') !== false;
include(realpath(__DIR__ . '/../../panel/includes/config.php'));

//Endpoints
include(realpath(__DIR__ . '/../../panel/endpoints/testendpoint.php'));

//Security Check
secure();

?>
<div class="container">
    <h1>Dashboard</h1>
    <ul>
        <li><a href="/admin/users">User Management</a></li>
        <li><a href="/admin/posts">Post Management</a></li>
    </ul>
</div>
