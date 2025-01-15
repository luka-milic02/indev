<?php

// Includes
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);

include(BASE_PATH . '/panel/includes/config.php');
include(BASE_PATH . '/panel/includes/database.php');
include(BASE_PATH . '/panel/includes/functions.php');
include(BASE_PATH . '/panel/includes/header.php');

// Security Check
secure();

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
        header('Location: ../users.php');
        die();
    } else {
        echo 'Could not prepare update statement!';
        die();
    }
}
?>

<div class="container">
    <h1>Edit User</h1>
    <ul>
        <li><a href="../users.php">Back</a></li>
    </ul>
    <div>
        <form method="post">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>
            
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required><br>
            
            <label for="password">Password (leave blank to keep current):</label><br>
            <input type="password" id="password" name="password"><br>
            
            <label for="active">Active:</label><br>
            <select id="active" name="active">
                <option value="1" <?php if ($user['active'] == 1) echo 'selected'; ?>>Yes</option>
                <option value="0" <?php if ($user['active'] == 0) echo 'selected'; ?>>No</option>
            </select><br>
            
            <input type="submit" value="Save Changes">
        </form>
    </div>
</div>

<?php include('../includes/footer.php'); ?>
