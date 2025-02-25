<?php

// Define page files and configuration
$page_title = 'Add User';

$css_files = [
    
];

$js_files = [
    
];

// Includes
// Detect the directory
$current_dir = dirname(__FILE__);
$is_backend = strpos($current_dir, 'panel') !== false;
include(__DIR__ . '/../includes/config.php');

// Security Check
secure();

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
                header('Location: ../users.php');
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
}
?>

<div class="container">
    <h1>Add User</h1>
    <ul>
        <li><a href="../users.php">Back</a></li>
    </ul>
    <div>
        <form method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" required><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required><br>

            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>

            <label for="active">Active:</label><br>
            <select id="active" name="active">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select><br>

            <input type="submit" value="Add User">
        </form>
    </div>
</div>

<?php include(realpath(__DIR__ . '/../includes/backend_footer.php')); ?>
