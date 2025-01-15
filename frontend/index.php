<?php

// Includes
include('./panel/includes/config.php');
include('./panel/includes/database.php');

// Fetch all posts
$posts = [];
if ($stm = $connect->prepare('SELECT id, title FROM posts ORDER BY added DESC')) {
    $stm->execute();
    $result = $stm->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);
    $stm->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            background: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin: 10px 0;
        }
        a {
            color: #007BFF;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Homepage</h1>
        <p>Below is a list of posts:</p>
        <ul>
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <li><a href="./frontend/post.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No posts available.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
