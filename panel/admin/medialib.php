<?php
session_start();

//Endpoints
include(realpath(__DIR__ . '/../../panel/endpoints/media_upload_ep.php'));

// Fetch uploaded files
$files = glob($uploadDir . '*'); // Get all files in the upload directory
?>

<!DOCTYPE html>
<html>
<head>
    <title>Media Upload Test</title>
    <style>
        .mediaItem {
            display: inline-block;
            margin: 10px;
            text-align: center;
        }
        img, video {
            max-width: 200px;
            display: block;
        }
    </style>
</head>
<body>
    <h1>Media Upload Test</h1>

    <!-- File Upload Form -->
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Upload</button>
    </form>

    <!-- Display Uploaded Files -->
    <h2>Uploaded Files</h2>
    <div id="mediaGallery">
        <?php foreach ($files as $file): ?>
            <?php $fileUrl = '/../panel/uploads/' . basename($file); ?>
            <div class="mediaItem">
                <?php if (strpos(mime_content_type($file), 'image') === 0): ?>
                    <img src="<?= $fileUrl ?>" alt="Uploaded Image">
                <?php elseif (strpos(mime_content_type($file), 'video') === 0): ?>
                    <video controls>
                        <source src="<?= $fileUrl ?>" type="<?= mime_content_type($file) ?>">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>
                <p><?= basename($file) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>