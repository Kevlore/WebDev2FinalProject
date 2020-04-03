<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
</head>
<body>
    <a href="gallery.php"><h1>Back to Gallery</h1></a>
    <form action="processLogin.php" method="post">
        <!-- The possibility for an ajax check to see if the username is already registered -->
        <label for="username">Username: </label>
        <input type="text" name="username" id="username" />
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" />
        <label for="passwordConfirm">Confirm password: </label>
        <input type="password" name="passwordConfirm" id="passwordConfirm" />
        <label for="fullName">Full Name:</label>
        <input type="text" name="fullName" id="fullName" />
        <!-- The possibility for an ajax check to see if the email is already registered -->
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" />
        <input type="hidden" name='userType' value='1' />
        <input type="submit" name="command" value="Create" />
    </form>
</body>
</html>
