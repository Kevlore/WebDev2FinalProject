<?php
    require 'connect.php';

    if(strlen($_POST['username']) > 0 && strlen($_POST['password']) > 0 && strlen($_POST['fullName']) > 0 && strlen($_POST['email'])) {
        
        $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = filter_var($username, FILTER_SANITIZE_STRING);

        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_var($password, FILTER_SANITIZE_STRING);
        
        $fullName = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fullName = filter_var($fullName, FILTER_SANITIZE_STRING);

        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $userType = filter_var($userType, FILTER_SANITIZE_NUMBER_INT);
        
        //If the create button is clicked insert the photo form data into the database.
        if($_POST['command'] == "Create") {
            $query = "INSERT INTO users (username, password, fullName, email, userType) values (:username, :password, :fullName, :email, :userType)";
            $statement = $db->prepare($query);
            $statement->bindValue(':username', $username);
            $statement->bindValue(':password', $password);
            $statement->bindValue(':fullName', $fullName);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':userType', $userType);
            $statement->execute();
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

    //Redirect to the gallery page after uploading image.
    header("Location: loginPage.php");
    die();
?>