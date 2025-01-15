<?php

define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);

include(BASE_PATH . '/panel/includes/config.php');
include(BASE_PATH . '/panel/includes/database.php');
include(BASE_PATH . '/panel/includes/functions.php');
include(BASE_PATH . '/panel/includes/header.php');

if (isset($_SESSION['id'])) {
    header('Location: dashboard.php');
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    // Prepare the query to get the user by username
    if ($stm = $connect->prepare("SELECT * FROM users WHERE username = ? AND active = 1")) {
        $stm->bind_param('s', $_POST['username']);
        $stm->execute();
        $result = $stm->get_result();
        $user = $result->fetch_assoc();

        // Check if user exists and verify password
        if ($user && password_verify($_POST['password'], $user['password'])) {
            // User is authenticated
            // Password is correct, start session
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email']; // Fixed the missing equals sign
            $_SESSION['username'] = $user['username'];
            
            set_message("You have successfuly logged in!" . $_SESSION['username']);
            header('Location: dashboard.php');
            
            echo "<h1>You are logged in!</h1>";
        } else {
            // Incorrect password or user not found
            echo "<p>Incorrect username or password.</p>";
        }


    //Closing the statement
    $stm->close();
    } else {
        echo "Error preparing the SQL statement.";
    }
}

include('includes/footer.php');
?>

<form method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <input type="submit" value="Login">
</form>
