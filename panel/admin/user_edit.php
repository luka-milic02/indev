<?php

// Define page files and configuration
$page_title = 'Edit User';

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

//Endpoints
include(realpath(__DIR__ . '/../../panel/endpoints/user_edit_ep.php'));

?>

<div class="container">
    <h1>Edit User</h1>
    <ul>
        <li><a href="/admin/users">Back</a></li>
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

<?php include(realpath(__DIR__ . '/../includes/backend_footer.php')); ?>
