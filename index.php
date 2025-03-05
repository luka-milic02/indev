<?php
// Get the requested URL
$requestUri = isset($_GET['url']) ? $_GET['url'] : '/';

// Define routes
$routes = [
    //Function Paged
    'secure/' => 'panel/admin/secure.php',
    'admin/logout' => 'panel/includes/logout.php',
    
    //Frontend Pages    
    '/' => 'frontend/index.php',          // Frontend homepage
    
    //Backend Pages
    'admin/' => 'panel/admin/login.php',                            // Login
    'admin/dashboard' => 'panel/admin/dashboard.php',               // Dashboard
    //Management
    'admin/users' => 'panel/admin/users.php',                       // User Management
    'admin/posts' => 'panel/admin/posts.php',                       // Post Management
    'admin/editpost' => 'panel/management/post_edit.php',           // Post Add
    'admin/addpost' => 'panel/management/post_add.php',             // Post Edit
    'admin/adduser' => 'panel/management/user_add.php',             // User Add
    'admin/edituser' => 'panel/management/user_edit.php',           // User Edit
];

// Load the requested page
if (isset($routes[$requestUri])) {
    require_once $routes[$requestUri];
} else {
    // Handle 404 errors
    http_response_code(404);
    echo '404 - Page not found.';
    exit;
}
?>