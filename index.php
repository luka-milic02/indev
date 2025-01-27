<?php

// Check the requested URI
$requestUri = $_SERVER['REQUEST_URI'];

if (strpos($requestUri, '/admin') === 0) {
    // Load CMS Admin Panel
    // Include the necessary admin files or route to the admin controller
    require_once 'panel/index.php';  // Your admin entry point
} else {
    // Load Frontend
    // Include the necessary frontend files or route to the frontend controller
    require_once 'frontend/index.php';  // Your frontend entry point
}
?>
