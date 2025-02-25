<?php

// Check the requested URI
$requestUri = $_SERVER['REQUEST_URI'];

if (strpos($requestUri, '/admin') === 0) {
    // Load CMS Admin Panel
    require_once 'panel/index.php';
} else {
    // Load Frontend
    require_once 'frontend/index.php';
}
?>
