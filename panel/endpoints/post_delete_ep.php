<?php

// Post Deletion
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    if ($stm = $connect->prepare('DELETE FROM posts WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();
        $stm->close();

        set_message('Post has been deleted');
        header('Location: /admin/posts');
        die();
    } else {
        echo 'Could not prepare delete statement!';
        die();
    }
};

?>