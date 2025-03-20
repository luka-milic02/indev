<?php

// Check if user ID is provided
if (isset($_GET['id'])) {
    // Fetch user details
    if ($stm = $connect->prepare('SELECT * FROM users WHERE id = ?')) { 
        $stm->bind_param('s', $_GET['id']);
        $stm->execute();
        $result = $stm->get_result();
        $user = $result->fetch_assoc();
        $stm->close();
        
        if (!$user) {
            echo 'No user found!';
            die();
        }
    } else {
        echo 'Could not prepare statement!';
        die();
    }
} else {
    echo 'No user ID provided!';
    die();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    // Check if password is updated
    if (!empty($_POST['password'])) {
        $hashed = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 10]);
    } else {
        // Use existing password if not changed
        $hashed = $user['password'];
    }

    // Update user details
    if ($stm = $connect->prepare('UPDATE users SET username = ?, email = ?, password = ?, active = ? WHERE id = ?')) {
        $stm->bind_param('ssssi', $_POST['username'], $_POST['email'], $hashed, $_POST['active'], $_GET['id']);
        $stm->execute();
        $stm->close();
        
        set_message("User " . $_POST['username'] . " has been updated");
        header('Location: /admin/users');
        die();
    } else {
        echo 'Could not prepare update statement!';
        die();
    }
};

?>