<?php
    require 'connect.php';

    $query = "SELECT * FROM users";
    $selectAll = $db->prepare($query);
    $selectAll->execute();
    $users = $selectAll->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
</head>
<body>
    <?php require 'navBar.php'; ?>
    <div id="usersTable">
        <table>
            <tr>
                <th>User ID</th>
                <th>User Type</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
            </tr>
            <form action="updateUser.php" method="post">
                <?php foreach($users as $user) : ?>
                    <tr>
                        <td><?=$user['userId']?></td>
                        <input type="hidden" value="<?=$user['userId']?>" name="userId" required />
                        <td><input type="text" value="<?=$user['userType']?>" name="userType" required /></td>
                        <td><input type="text" value="<?=$user['username']?>" name="username" required /></td>
                        <td><input type="text" value="<?=$user['fullName']?>" name="fullName" required /></td>
                        <td><input type="text" value="<?=$user['email']?>" name="email" required /></td>
                        <td><input type="submit" name="command" value="Update" /></td>
                        <td><input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this user?')" /></td>
                    </tr>
                <?php endforeach; ?>
            </form>
        </table>
    </div>
    <div id="userSignup">
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
    </div>
</body>
</html>