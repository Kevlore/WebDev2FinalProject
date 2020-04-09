<nav>
    <ul>
        <li>
            <a href="gallery.php">Gallery</a>
        </li>
        <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) : ?>
            <li>
                <a href="usersTable.php">Users</a>
            </li>
        <?php endif; ?>
    </ul>
</nav>