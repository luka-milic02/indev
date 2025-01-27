<?php
include(__DIR__ . '/includes/config.php');

session_start();
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Area</title>
</head>
<body>
    <h1>You must be logged in to access this page</h1>
    <a href="<?php echo BASE_URL;?>/panel/index.php">Go to Login Page</a>
</body>
</html>
