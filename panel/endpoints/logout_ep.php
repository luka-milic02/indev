<?php

include(realpath(__DIR__ . '/../../panel/includes/config.php'));

session_destroy();

header('Location: /admin');
?>