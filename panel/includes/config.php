<?php

session_start();

//Path Definition for URLs
define('BASE_URL',  'http://' . $_SERVER['HTTP_HOST']);

//Includes
// Path Definition for Includes
define('BASE_PATH', realpath(__DIR__ . '/../..'));

// Include shared resources
include(BASE_PATH . '/panel/includes/database.php');
include(BASE_PATH . '/panel/includes/functions.php');

// Include the appropriate header file based on the directory
if ($is_backend) {
    include(BASE_PATH . '/panel/includes/backend_header.php');
} else {
    include(BASE_PATH . '/frontend/includes/frontend_header.php');
}

?>