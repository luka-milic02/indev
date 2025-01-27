<?php

// Includes
include(__DIR__ . '/includes/config.php');

// Security Check
secure();

// Post Deletion
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    if ($stm = $connect->prepare('DELETE FROM posts WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();
        $stm->close();

        set_message('Post has been deleted');
        header('Location: posts.php');
        die();
    } else {
        echo 'Could not prepare delete statement!';
        die();
    }
}

// Fetch Posts
if ($stm = $connect->prepare('SELECT * FROM posts')) {
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
    <h1>Post Management</h1>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="users.php">User Management</a></li>
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
                            <a href="./management/post_edit.php?id=<?php echo htmlspecialchars($record['id']); ?>">Edit</a> | 
                            <a href="posts.php?id=<?php echo htmlspecialchars($record['id']); ?>" 
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
        <a href="./management/post_add.php">Add Post</a>
    </div>
</div>

<?php include('includes/footer.php'); ?>
