<?php

// Check if post ID is provided
if (isset($_GET['id'])) {
    // Fetch post details
    if ($stm = $connect->prepare('SELECT * FROM posts WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();
        $result = $stm->get_result();
        $post = $result->fetch_assoc();
        $stm->close();

        if (!$post) {
            echo 'No post found!';
            die();
        }
    } else {
        echo 'Could not prepare statement!';
        die();
    }
} else {
    echo 'No post ID provided!';
    die();
}

// Fetch active users for dropdown
if ($stm = $connect->prepare('SELECT id, username FROM users WHERE active = 1')) {
    $stm->execute();
    $users = $stm->get_result()->fetch_all(MYSQLI_ASSOC);
    $stm->close();
} else {
    echo 'Could not fetch users!';
    die();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = !empty($_POST['author']) ? $_POST['author'] : $post['author'];
    $date = !empty($_POST['date']) ? $_POST['date'] : $post['date'];
    $added = date('Y-m-d H:i:s'); // Updated timestamp

    if (!empty($title) && !empty($content)) {
        // Update post details
        if ($stm = $connect->prepare('UPDATE posts SET title = ?, content = ?, author = ?, date = ?, added = ? WHERE id = ?')) {
            $stm->bind_param('sssssi', $title, $content, $author, $date, $added, $_GET['id']);
            $stm->execute();
            $stm->close();

            set_message("Post \"$title\" has been updated");
            header('Location: ../posts.php');
            die();
        } else {
            echo 'Could not prepare update statement!';
            die();
        }
    } else {
        echo 'Please fill in all required fields!';
    }
};

?>