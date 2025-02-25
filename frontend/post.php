<?php


// Includes
// Detect the directory
$current_dir = dirname(__FILE__);
$is_backend = strpos($current_dir, 'panel') !== false;
//Include the Config
include(realpath(__DIR__ . '/../panel/includes/config.php'));

// Fetch post ID from URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $post_id = intval($_GET['id']);

    // Fetch post details
    $stmt = $connect->prepare('SELECT title, content, author, added FROM posts WHERE id = ?');
    $stmt->bind_param('i', $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();

    if (!$post) {
        echo 'Post not found.';
        die();
    }
} else {
    echo 'Invalid post ID.';
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['title']); ?></title>
</head>
<body>
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>
    <p><em>Posted by <?php echo htmlspecialchars($post['author']); ?> on <?php echo htmlspecialchars($post['added']); ?></em></p>
    <!-- Render HTML content directly (no escaping) -->
    <div><?php echo $post['content']; ?></div>
    <p><a href="../index.php">Back to Homepage</a></p>
</body>
</html>