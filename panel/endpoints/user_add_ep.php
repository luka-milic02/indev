<?php

// Handle User Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $active = isset($_POST['active']) ? intval($_POST['active']) : 0;

    if (!empty($username) && !empty($email) && !empty($password)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $hashed = password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
            
            if ($stm = $connect->prepare('INSERT INTO users (username, email, password, active) VALUES (?, ?, ?, ?)')) {
                $stm->bind_param('sssi', $username, $email, $hashed, $active);
                $stm->execute();
                $stm->close();

                set_message("A new user $username has been added");
                header('Location: /admin/users');
                die();
            } else {
                echo 'Could not prepare insert statement!';
            }
        } else {
            echo 'Invalid email format!';
        }
    } else {
        echo 'Please fill in all fields!';
    }
};

?>