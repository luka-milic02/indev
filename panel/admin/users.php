<?php


// Define page files and configuration
$page_title = 'User Management';

$css_files = [
    
];

$js_files = [
    
];

// Includes
// Detect the directory
$current_dir = dirname(__FILE__);
$is_backend = strpos($current_dir, 'panel') !== false;
include(realpath(__DIR__ . '/../includes/config.php'));

// Security Check
secure();

// User Deletion
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    if ($stm = $connect->prepare('DELETE FROM users WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();
        $stm->close();

        set_message('User has been deleted');
        header('Location: /admin/users');
        die();
    } else {
        echo 'Could not prepare delete statement!';
        die();
    }
}

// Fetch Users
if ($stm = $connect->prepare('SELECT * FROM users')) {
    $stm->execute();
    $result = $stm->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);  // Fetch all users at once
    $stm->close();
} else {
    echo 'Could not prepare select statement!';
    die();
}
?>

<div class="container">
    <h1>User Management</h1>
    <ul>
        <li><a href="/admin/dashboard">Dashboard</a></li>
        <li><a href="/admin/posts">Post Management</a></li>
    </ul>
    <div>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php if (!empty($users)) : ?>
                <?php foreach ($users as $record) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['id']); ?></td>
                        <td><?php echo htmlspecialchars($record['username']); ?></td>
                        <td><?php echo htmlspecialchars($record['email']); ?></td>
                        <td><?php echo $record['active'] ? 'Active' : 'Inactive'; ?></td>
                        <td>
                            <a href="edituser?id=<?php echo htmlspecialchars($record['id']); ?>">Edit</a> | 
                            <a href="users?id=<?php echo htmlspecialchars($record['id']); ?>" 
                               onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">No users found!</td>
                </tr>
            <?php endif; ?>
        </table>
        <a href="/admin/adduser">Add User</a>
    </div>
</div>

<?php include(__DIR__ . '/includes/backend_footer.php'); ?>
