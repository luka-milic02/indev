<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title ?? 'Indev Admin') ?></title>
    
    <?php foreach ($css_files as $css): ?>
        <link rel="stylesheet" href="<?= BASE_URL. htmlspecialchars($css) ?>">
    <?php endforeach; ?>
</head>
<body>
    <?php
    // Show navigation on all pages except index.php and secure.php
    if (basename($_SERVER['PHP_SELF']) !== 'index.php' && basename($_SERVER['PHP_SELF']) !== 'secure.php'):
    ?>
    <header>
        <nav>
            <ul style="list-style-type: none; display: flex; gap: 10px;">
                <li><a href="<?= BASE_URL . '/panel/dashboard.php'?>">Dashboard</a></li>
                <li><a href="<?= BASE_URL . '/panel/includes/logout.php'?>">Logout</a></li>
            </ul>
        </nav>
    </header>
    <?php endif; ?>