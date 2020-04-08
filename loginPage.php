<?php
    require "currentUser.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <a href="gallery.php"><h1>Back to Gallery</h1></a>
    <form action="processLogin.php" method="post">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username" required />
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" required />
        <input type="submit" name="command" value="Login" />
            <?php if(!isset($_SESSION['userId']) && isset($_SESSION['loginMessage'])) : ?>
                <p><?=$_SESSION['loginMessage']?></p>
            <?php
                session_unset();
                endif; 
            ?>
        <p>
            Or click <a href="registerAccount.php">here</a> to register a new account.
        </p>
    </form>
</body>
</html>