<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define page files and setup
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

// Handle File Upload (same as in the Edit Post)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $uploadDir = __DIR__ . '/../uploads/'; // Adjust this path as needed
    $baseUrl = '/uploads/'; // Adjust for public URL path

    // Check if file is uploaded
    if (!isset($_FILES['file'])) {
        echo json_encode(['error' => 'No file uploaded']);
        exit;
    }

    $file = $_FILES['file'];
    $allowedExtensions = ['jpg', 'png', 'gif', 'jpeg', 'svg', 'mp4', 'webm', 'ogg', 'pdf', 'zip'];
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($fileExtension, $allowedExtensions)) {
        echo json_encode(['error' => 'Invalid file type']);
        exit;
    }

    // Generate a unique filename
    $filename = uniqid() . '.' . $fileExtension;
    $destination = $uploadDir . $filename;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        echo json_encode([
            'success' => true,
            'file' => [
                'url' => $baseUrl . $filename, // URL where the file can be accessed
            ]
        ]);
    } else {
        echo json_encode(['error' => 'Failed to move uploaded file']);
    }
    exit; // End after handling the upload
}

// Endpoints
include(realpath(__DIR__ . '/../../panel/endpoints/post_add_ep.php'));

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
            <!-- Replace the textarea with Jodit editor -->
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

<script>
console.log('jodit_setup.js is running');

document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM fully loaded. Initializing Jodit editor...');

    if (typeof Jodit === 'undefined') {
        console.error('Jodit library is not loaded.');
        return;
    }

    var editor = new Jodit("#content", {
        uploader: {
            url: "/panel/add_new_post.php", // Same file for testing
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
                url: "/panel/add_new_post.php", // Same file for testing
            }
        }
    });

    console.log('Jodit editor initialized successfully.');
});
</script>

<?php include(realpath(__DIR__ . '/../includes/backend_footer.php')); ?>
