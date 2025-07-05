<?php

$uploadDir = __DIR__ . '/../uploads/'; // Change this to your actual upload folder
$baseUrl = '/uploads/'; // Change to your accessible upload URL


// Check if file is uploaded
if (!isset($_FILES['files'])) {
    echo json_encode(['error' => 'No file uploaded']);
    exit;
}

$file = $_FILES['files'];
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
?>
