<?php

define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);

include(BASE_PATH . '/panel/includes/config.php');
include(BASE_PATH . '/panel/includes/database.php');
include(BASE_PATH . '/panel/includes/functions.php');
include(BASE_PATH . '/panel/includes/header.php');


secure();

echo "<h1>You are on the test page</h1>";


?>