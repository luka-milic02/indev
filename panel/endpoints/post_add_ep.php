<?php

// Fetch active users for the author dropdown
$users = [];
if ($result = $connect->query("SELECT username FROM users WHERE active = 1 ORDER BY username")) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row['username'];
    }
}

// Handle Post Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = !empty($_POST['author']) ? trim($_POST['author']) : $users[0];  // Default to the first active user
    $date = !empty($_POST['date']) ? $_POST['date'] : date('Y-m-d');  // Current date if empty

    if (!empty($title) && !empty($content)) {
        if ($stm = $connect->prepare('INSERT INTO posts (title, content, author, date) VALUES (?, ?, ?, ?)')) {
            $stm->bind_param('ssss', $title, $content, $author, $date);
            $stm->execute();
            $stm->close();

            set_message("A new post titled '$title' has been added");
            header('Location: /admin/posts');
            exit;
        } else {
            set_message('Could not prepare insert statement!');
        }
    } else {
        set_message('Please fill in all fields!');
    }
}

?>