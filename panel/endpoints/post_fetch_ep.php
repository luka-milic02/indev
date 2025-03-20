<?php

// Fetch Posts
if ($stm = $connect->prepare('SELECT * FROM posts')) {
    $stm->execute();
    $result = $stm->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);  // Fetch all users at once
    $stm->close();
} else {
    echo 'Could not prepare select statement!';
    die();
};

?>