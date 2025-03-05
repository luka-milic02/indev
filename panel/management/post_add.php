<?php

// Define page files and
$page_title = 'Add New Post';

$css_files = [
    '/panel/js/jodites2021/jodit.min.css',
    '/panel/css/main.css'
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

// Fetch active users for the author dropdown
$users = [];
if ($result = $connect->query("SELECT username FROM users WHERE active = 1 ORDER BY username")) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row['username'];
    }
}

// Handle Post Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = !empty($_POST['author']) ? trim($_POST['author']) : $users[0];  // Default to the first active user
    $date = !empty($_POST['date']) ? $_POST['date'] : date('Y-m-d');  // Current date if empty

    if (!empty($title) && !empty($content)) {
        if ($stm = $connect->prepare('INSERT INTO posts (title, content, author, date) VALUES (?, ?, ?, ?)')) {
            $stm->bind_param('ssss', $title, $content, $author, $date);
            $stm->execute();
            $stm->close();

            set_message("A new post titled '$title' has been added");
            header('Location: /admin/posts');
            exit;
        } else {
            set_message('Could not prepare insert statement!');
        }
    } else {
        set_message('Please fill in all fields!');
    }
}
?>

<div class="container">
    <h1 class="testclass">Add Post</h1>
    <ul>
        <li><a href="/admin/posts">Back</a></li>
    </ul>
    <div>
        <form method="post">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" required><br>

            <label for="content">Content:</label><br>
            <textarea id="content" name="content"></textarea><br>

            <label for="author">Author (select active user):</label><br>
            <select id="author" name="author">
                <?php foreach ($users as $user) : ?>
                    <option value="<?php echo $user; ?>"><?php echo $user; ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="date">Post Date (optional):</label><br>
            <input type="date" id="date" name="date"><br>

            <input type="submit" value="Add Post">
        </form>
    </div>
</div>


<?php include(realpath(__DIR__ . '/../includes/backend_footer.php')); ?>