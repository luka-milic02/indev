<?php

// Includes
define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']);

include(BASE_PATH . '/panel/includes/config.php');
include(BASE_PATH . '/panel/includes/database.php');
include(BASE_PATH . '/panel/includes/functions.php');
include(BASE_PATH . '/panel/includes/header.php');

// Security Check
// Fetch active users for the author dropdown
$users = [];
if ($result = $connect->query("SELECT username FROM users WHERE active = 1 ORDER BY username")) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row['username'];
    }
}

// Handle Post Creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $title = trim($_POST['title']);
    $author = !empty($_POST['author']) ? trim($_POST['author']) : $users[0];  // Default to the first active user
    $date = !empty($_POST['date']) ? $_POST['date'] : date('Y-m-d');  // Current date if empty

    // Ensure content (from Editor.js) is set and sanitize it
    $content = isset($_POST['content']) ? json_encode($_POST['content']) : '';

    if (!empty($title) && !empty($content)) {
        if ($stm = $connect->prepare('INSERT INTO editorjs_test (title, author, date, data) VALUES (?, ?, ?, ?)')) {
            $stm->bind_param('ssss', $title, $author, $date, $content);
            $stm->execute();
            $stm->close();

            set_message("A new post titled '$title' has been added.");
            header('Location: test1.php');
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
    <h1>Add Post with Editor.js</h1>
    <ul>
        <li><a href="test1.php">Back</a></li>
    </ul>
    <div>
        <form method="POST">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" required><br>

            <label for="author">Author (select active user):</label><br>
            <select id="author" name="author">
                <?php foreach ($users as $user) : ?>
                    <option value="<?php echo $user; ?>"><?php echo $user; ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="date">Post Date (optional):</label><br>
            <input type="date" id="date" name="date"><br>

            <div id="editorjs"></div>

            <input type="hidden" name="content" id="content" />

            <input type="submit" value="Add Post">
        </form>
    </div>
</div>

<!-- Editor.js Scripts -->
<script src="editorjs.umd.js"></script>
<script src="./editor_tools/header.umd.js"></script>

<script>
    // Initialize Editor.js
    const editor = new EditorJS({
        holder: 'editorjs',
        tools: {
            header: {
                class: Header, // Loaded from CDN
                inlineToolbar: true,
                config: {
                    placeholder: 'Enter a header',
                }
            },
        }
    });

// Save button functionality
document.getElementById('saveButton').addEventListener('click', async () => {
            const outputData = await editor.save();
            fetch('save_editor.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(outputData),
            })
            .then(response => response.json())
            .then(data => {
                console.log('Saved:', data);
                alert('Content saved with ID: ' + data.id);
            })
            .catch(error => {
                console.error('Error saving:', error);
                alert('Save failed!');
            });
        });
</script>

<?php include('../includes/footer.php'); ?>
