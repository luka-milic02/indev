<?php

define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);
// Includes
include(BASE_PATH . '/panel/includes/config.php');
include(BASE_PATH . '/panel/includes/database.php');
include(BASE_PATH . '/panel/includes/functions.php');
include(BASE_PATH . '/panel/includes/header.php');

// Security Check


// Fetch Posts from editorjs_test
if ($stm = $connect->prepare('SELECT * FROM editorjs_test')) {
    $stm->execute();
    $result = $stm->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);  // Fetch all posts at once
    $stm->close();
} else {
    echo 'Could not prepare select statement!';
    die();
}

?>

<div class="container">
    <h1>Editor.js Post Management</h1>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="users.php">User Management</a></li>
    </ul>
    <div>
        <table>
            <tr>
                <th>ID</th>
                <th>Heading</th>
                <th>Actions</th>
            </tr>
            <?php if (!empty($posts)) : ?>
                <?php foreach ($posts as $record) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($record['id']); ?></td>
                        <td><?php echo htmlspecialchars($record['data']['blocks'][1]['data']['text']); ?></td>
                        <td>
                            <a href="test2.php?id=<?php echo htmlspecialchars($record['id']); ?>">Edit</a> | 
                            <a href="test1.php?id=<?php echo htmlspecialchars($record['id']); ?>" 
                               onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="3">No posts found!</td>
                </tr>
            <?php endif; ?>
        </table>
        <a href="testeditor.php">Add Post</a>
    </div>
</div>

