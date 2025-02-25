<?php
// Define page files and setup
$page_title = 'Edit Post';

$css_files = [
    '/panel/js/jodites2021/jodit.min.css',
];

$js_files = [
    '/panel/js/jodites2021/jodit.min.js',
    '/panel/js/jodit_setup.js'
];

// Includes
// Detect the directory
$current_dir = dirname(__FILE__);
$is_backend = strpos($current_dir, 'panel') !== false;
//Include the Config
include(__DIR__ . '/../includes/config.php');

// Security Check
secure();

// Check if post ID is provided
if (isset($_GET['id'])) {
    // Fetch post details
    if ($stm = $connect->prepare('SELECT * FROM posts WHERE id = ?')) {
        $stm->bind_param('i', $_GET['id']);
        $stm->execute();
        $result = $stm->get_result();
        $post = $result->fetch_assoc();
        $stm->close();

        if (!$post) {
            echo 'No post found!';
            die();
        }
    } else {
        echo 'Could not prepare statement!';
        die();
    }
} else {
    echo 'No post ID provided!';
    die();
}

// Fetch active users for dropdown
if ($stm = $connect->prepare('SELECT id, username FROM users WHERE active = 1')) {
    $stm->execute();
    $users = $stm->get_result()->fetch_all(MYSQLI_ASSOC);
    $stm->close();
} else {
    echo 'Could not fetch users!';
    die();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = !empty($_POST['author']) ? $_POST['author'] : $post['author'];
    $date = !empty($_POST['date']) ? $_POST['date'] : $post['date'];
    $added = date('Y-m-d H:i:s'); // Updated timestamp

    if (!empty($title) && !empty($content)) {
        // Update post details
        if ($stm = $connect->prepare('UPDATE posts SET title = ?, content = ?, author = ?, date = ?, added = ? WHERE id = ?')) {
            $stm->bind_param('sssssi', $title, $content, $author, $date, $added, $_GET['id']);
            $stm->execute();
            $stm->close();

            set_message("Post \"$title\" has been updated");
            header('Location: ../posts.php');
            die();
        } else {
            echo 'Could not prepare update statement!';
            die();
        }
    } else {
        echo 'Please fill in all required fields!';
    }
}
?>

<div class="container">
        <h1>Edit Post</h1>
        <ul>
            <li><a href="../posts.php">Back</a></li>
        </ul>
        <div>
            <form method="post">
                <label for="title">Title:</label><br>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br>

                <label for="content">Content:</label><br>
                <!-- Replace the textarea with Jodit -->
                <textarea id="content" name="content" rows="5"><?php echo htmlspecialchars($post['content']); ?></textarea><br>

                <label for="author">Author:</label><br>
                <select id="author" name="author">
                    <option value="">-- Select Author --</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['username']; ?>" <?php if ($post['author'] == $user['username']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($user['username']); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label for="date">Date (optional):</label><br>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($post['date']); ?>"><br>

                <input type="submit" value="Save Changes">
            </form>
        </div>
    </div>

    </script>
</body>
</html>

<?php include(realpath(__DIR__ . '/../includes/backend_footer.php')); ?>