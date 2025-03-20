<?php

// Define page files and configuration
$page_title = 'Post Management';

$css_files = [
    
];

$js_files = [
    
];

// Includes
// Detect the directory
$current_dir = dirname(__FILE__);
$is_backend = strpos($current_dir, 'admin') !== false;
include(realpath(__DIR__ . '/../includes/config.php'));

// Security Check
secure();

//Endpoints
include(realpath(__DIR__ . '/../../panel/endpoints/post_fetch_ep.php'));
include(realpath(__DIR__ . '/../../panel/endpoints/post_delete_ep.php'));

?>

<div class="container">
    <h1>Post Management</h1>
    <ul>
        <li><a href="/admin/dashboard">Dashboard</a></li>
        <li><a href="/admin/users">User Management</a></li>
    </ul>
    <div>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Content</th>
                <th>Actions</th>
            </tr>
            <?php if (!empty($users)) : ?>
                <?php foreach ($users as $record) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['id']); ?></td>
                        <td><?php echo htmlspecialchars($record['title']); ?></td>
                        <td><?php echo htmlspecialchars($record['author']); ?></td>
                        <td><?php echo htmlspecialchars($record['content']); ?></td>
                        <td><?php echo htmlspecialchars($record['date']); ?></td>
                        <td>
                            <a href="editpost?id=<?php echo htmlspecialchars($record['id']); ?>">Edit</a> | 
                            <a href="posts?id=<?php echo htmlspecialchars($record['id']); ?>" 
                               onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5">No posts found!</td>
                </tr>
            <?php endif; ?>
        </table>
        <a href="/admin/addpost">Add Post</a>
    </div>
</div>

<?php include(__DIR__ . '/includes/backend_footer.php'); ?>
