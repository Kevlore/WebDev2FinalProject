<?php
    require 'connect.php';
    require 'currentUser.php';

    if(strlen($_POST['username']) > 0 && strlen($_POST['password']) > 0) {
        
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        //Salt and Hash Password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        if(strlen($_POST['fullName']) > 0 && strlen($_POST['email']) > 0)
        {
            $fullName = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $fullName = filter_var($fullName, FILTER_SANITIZE_STRING);

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);

            $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userType = filter_var($userType, FILTER_SANITIZE_NUMBER_INT);
        }
        
        //If the create button is clicked insert the photo form data into the database.
        if($_POST['command'] == "Create") {
            $query = "INSERT INTO users (username, password, fullName, email, userType) values (:username, :password, :fullName, :email, :userType)";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':password', $passwordHash);
            $statement->bindValue(':fullName', $fullName);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':userType', $userType);
            $statement->execute();

            if(isset($_POST['createType']) && $_POST['createType'] == "new")  {
                //If this create is triggered from the admin users table page then redirect to the user table page.
                header("Location: usersTable.php");
                die();
            }
            else
            {
                //Redirect to the gallery page after registering.
                header("Location: loginPage.php");
                die();
            }
        }
        else if($_POST['command'] == "Login") {
            $query = "SELECT * FROM users";
            $selectAll = $db->prepare($query);
            $selectAll->execute();
            $users = $selectAll->fetchAll();

            //Determine the currently targeted user based off of the username.
            foreach($users as $user) :
                if($user['username'] == $username) {
                    $selectedUser = $user;
                }
            endforeach;

            foreach($users as $user) :
                if($selectedUser['username'] == $username && password_verify($password, $selectedUser['password'])) {
                    $_SESSION['userId'] = $selectedUser['userId'];
                    $_SESSION['userType'] = $selectedUser['userType'];
                    $_SESSION['username'] = $selectedUser['username'];
                    $_SESSION['loginMessage'] = "You have successfully logged in: ";

                    //If username and password is correct send user back to gallery page.
                    header("Location: gallery.php");
                    die();
                }
                else
                {
                    //If username and password is incorrect send user back to login page.
                    $_SESSION['loginMessage'] = "Incorrect username or password entered." . strlen($selectedUser['password']);
                    header("Location: loginPage.php");
                    die();
                }
            endforeach;
        }
        else
        {
            //If required form data is not provided then end the session.
            header("Location: registerAccount.php");
            die();
        }
    }
    else
    {
        //If required form data is not provided then end the session.
        header("Location: registerAccount.php");
        die();
    }
?>