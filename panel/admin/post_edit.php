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

//Endpoints
include(realpath(__DIR__ . '/../../panel/endpoints/post_edit_ep.php'));

?>

<div class="container">
        <h1>Edit Post</h1>
        <ul>
            <li><a href="/admin/posts">Back</a></li>
        </ul>
        <div>
            <form method="post">
                <label for="title">Title:</label><br>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br>

                <label for="content">Content:</label><br>
                <!-- Replace the textarea with Jodit -->
                <textarea id="editor" name="content" rows="5"><?php echo htmlspecialchars($post['content']); ?></textarea><br>

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

<script>
console.log('jodit_setup.js is running');

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded. Initializing Jodit editor...');

    if (typeof Jodit === 'undefined') {
        console.error('Jodit library is not loaded.');
        return;
    }

    var editor = new Jodit("#editor", {
    uploader: {
        url: "/panel/endpoints/jodit_upload_ep.php",
        format: "json",
        isSuccess: function (resp) {
            return resp.success; // Jodit expects a 'success' key in the response
        },
        getMessage: function (resp) {
            return resp.error || "Upload failed";
        }
    },
    filebrowser: {
        ajax: {
            url: "/panel/endpoints/jodit_upload_ep.php",
        }
    }
});

    console.log('Jodit editor initialized successfully.');
});
</script>

<?php include(realpath(__DIR__ . '/../includes/backend_footer.php')); ?>