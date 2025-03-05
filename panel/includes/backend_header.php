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
if ($noheader != true) {
?>
    <header>
        <nav>
            <ul style="list-style-type: none; display: flex; gap: 10px;">
                <li><a href="/admin/dashboard">Dashboard</a></li>
                <li><a href="/admin/logout">Logout</a></li>
            </ul>
        </nav>
    </header>
<?php }; ?>