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

//Endpoints
include(realpath(__DIR__ . '/../../panel/endpoints/user_add_ep.php'));
?>

<div class="container">
    <h1>Add User</h1>
    <ul>
        <li><a href="/admin/users">Back</a></li>
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
