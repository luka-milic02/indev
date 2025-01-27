<?php
// Check if the current script is login.php
if (basename($_SERVER['PHP_SELF']) !== 'index.php' && basename($_SERVER['PHP_SELF']) !== 'secure.php') :
?>
    <header>
        <nav>
            <ul style="list-style-type: none; display: flex; gap: 10px;">
                <li><a href="<?php echo BASE_URL;?>/panel/dashboard.php">dashboard</a></li>
                <li><a href="<?php echo BASE_URL;?>/panel/includes/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
<?php endif; ?>
