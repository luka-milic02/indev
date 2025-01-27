<?php
// Database credentials
$host = 'localhost';
$db = 'indev_db';
$user = 'indev_user';
$pass = 'dims3009';

try {
    // Database connection
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get JSON data from POST
    $content = file_get_contents('php://input');

    // Insert data into the database
    $stmt = $pdo->prepare("INSERT INTO editorjs_test (content) VALUES (:content)");
    $stmt->execute(['content' => $content]);

    // Send response back to the frontend
    echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>