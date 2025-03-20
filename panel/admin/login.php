<?php

// Define page files and configuration
$page_title = 'Indev Login';

$css_files = [
    
];

$js_files = [
    
];

// Includes
$noheader = true;
// Detect the directory
$current_dir = dirname(__FILE__);
$is_backend = strpos($current_dir, 'admin') !== false;
include(realpath(__DIR__ . '/../includes/config.php'));


//Endpoints
include(realpath(__DIR__ . '/../../panel/endpoints/login_ep.php'));


?>

<form method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <input type="submit" value="Login">
</form>


