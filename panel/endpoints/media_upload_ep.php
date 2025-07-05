<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define the upload directory
$uploadDir = (__DIR__ . '/../uploads/');

// Debugging: Print the upload directory path
var_dump($uploadDir);

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Debugging: Print the uploaded file details
    var_dump($file);

    // Validate file type (e.g., allow only images and videos)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'video/mp4'];
    if (!in_array($file['type'], $allowedTypes)) {
        echo "<p style='color: red;'>Invalid file type. Only images (JPEG, PNG, GIF) and videos (MP4) are allowed.</p>";
    }

    // Validate file size (e.g., 10MB limit)
    $maxSize = 10 * 1024 * 1024; // 10MB
    if ($file['size'] > $maxSize) {
        echo "<p style='color: red;'>File size exceeds the limit.</p>";
    }

    // Generate a unique filename
    $fileName = uniqid() . '-' . basename($file['name']);
    $filePath = $uploadDir . $fileName;

    // Debugging: Print the file path
    var_dump($filePath);

    // Move the file to the upload directory
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        echo "<p style='color: green;'>File uploaded successfully!</p>";
    } else {
        echo "<p style='color: red;'>Failed to upload file.</p>";
    }

    header('Location: /admin/media');
    exit();
};
?>