<?php

$connect= mysqli_connect('localhost', 'indev_user', 'dims3009', 'indev_db');

if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
};
?>
