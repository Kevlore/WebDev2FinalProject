<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Create Account</title>
</head>
<body>
    <?php require "navBar.php"; ?>
    <form action="processLogin.php" method="post">
        <!-- The possibility for an ajax check to see if the username is already registered -->
        <label for="username">Username: </label>
        <input type="text" name="username" id="username" placeholder="Username" required/>
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" placeholder="Password" required/>
        <label for="passwordConfirm">Confirm password: </label>
        <input type="password" name="passwordConfirm" id="passwordConfirm" placeholder="Confirm Password" required/>
        <label for="fullName">Full Name:</label>
        <input type="text" name="fullName" id="fullName" required/>
        <!-- The possibility for an ajax check to see if the email is already registered -->
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" required/>
        <input type="hidden" name='userType' value='1' />
        <input type="submit" name="command" value="Create" />
    </form>
    <script src="javascript/confirmPassword.js?1"></script>
</body>
</html>
