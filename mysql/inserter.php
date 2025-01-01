<?php
// Database connection (adjust if needed)
$connect = mysqli_connect('localhost', 'indev_user', 'dims3009', 'indev_db');

if (!$connect) {
    die('Connection failed: ' . mysqli_connect_error());
}

// Adding a new user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_user') {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $password = $_POST['password'];

    // Hash the password using bcrypt
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert the user into the database
    $sql = "INSERT INTO users (username, email, password, active) VALUES (?, ?, ?, 1)"; // '1' means active
    $stmt = $connect->prepare($sql);

    // Bind the parameters to the SQL query
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // Execute the query and check if the insertion was successful
    if ($stmt->execute()) {
        echo "User successfully added!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Deleting a user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_user') {
    $username_to_delete = mysqli_real_escape_string($connect, $_POST['username_to_delete']);

    // Prepare the SQL query to delete the user
    $sql_delete = "DELETE FROM users WHERE username = ?";
    $stmt_delete = $connect->prepare($sql_delete);

    // Bind the parameter to the SQL query
    $stmt_delete->bind_param("s", $username_to_delete);

    // Execute the query and check if the deletion was successful
    if ($stmt_delete->execute()) {
        echo "User successfully deleted!";
    } else {
        echo "Error: " . $stmt_delete->error;
    }

    // Close the statement
    $stmt_delete->close();
}

// Close the connection
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
</head>
<body>
    <h1>Register a New User</h1>
    <form action="" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <input type="hidden" name="action" value="add_user">
        <button type="submit">Register</button>
    </form>

    <h1>Delete a User</h1>
    <form action="" method="POST">
        <label for="username_to_delete">Username to Delete:</label><br>
        <input type="text" id="username_to_delete" name="username_to_delete" required><br><br>

        <input type="hidden" name="action" value="delete_user">
        <button type="submit">Delete User</button>
    </form>
</body>
</html>
