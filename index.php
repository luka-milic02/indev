<?php
// Get the requested URL
$requestUri = isset($_GET['url']) ? $_GET['url'] : '/';

// Define routes
$routes = [
    // Function Pages
    'secure' => 'panel/admin/secure.php',
    'admin/logout' => 'panel/endpoints/logout_ep.php',
    
    // Frontend Pages    
    '/' => 'frontend/index.php',          // Frontend homepage
    
    // Backend Pages
    'admin' => 'panel/admin/login.php',                            // Login
    'admin/dashboard' => 'panel/admin/dashboard.php',               // Dashboard
    // Management
    'admin/users' => 'panel/admin/users.php',                       // User Management
    'admin/posts' => 'panel/admin/posts.php',                       // Post Management
    'admin/editpost' => 'panel/admin/post_edit.php',           // Post Edit
    'admin/addpost' => 'panel/admin/post_add.php',             // Post Add
    'admin/adduser' => 'panel/admin/user_add.php',             // User Add
    'admin/edituser' => 'panel/admin/user_edit.php',           // User Edit
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