<?php 
    require 'connect.php';
    require "currentUser.php";

    //Check to make sure only users with admin privileges can run this code.
    if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) {
        if(isset($_POST['userId'])) {
            $id = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    
            $query = "SELECT * FROM users WHERE userId = $id";
            $statement = $db->prepare($query);
            $statement->execute();
            $selectedUser = $statement->fetch();
        }
    
        //Check to make sure the required form fields have been provided.
        if(strlen($_POST['userType']) > 0 && strlen($_POST['username']) > 0 && strlen($_POST['fullName']) > 0 && strlen($_POST['email']) > 0) {
            //Sanitize the fields.
            $userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userType = filter_var($userType, FILTER_SANITIZE_STRING);

            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $username = filter_var($username, FILTER_SANITIZE_STRING);
            
            $fullName = filter_input(INPUT_POST, 'fullName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $fullName = filter_var($fullName, FILTER_SANITIZE_STRING);

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var($email, FILTER_SANITIZE_STRING);
    
            if($_POST['command'] == "Update")
            {
                $query = "UPDATE users SET userType = :userType, username = :username, fullName = :fullName, email = :email WHERE userId = :id";
                $statement = $db->prepare($query);
                $statement->bindValue(':userType', $userType);
                $statement->bindValue(':username', $username);
                $statement->bindValue(':fullName', $fullName);
                $statement->bindValue(':email', $email);
                $statement->bindValue(':id', $id);
                $statement->execute();
            }
            //If the delete button is clicked remove the selected user from the database.
            else if($_POST['command'] == "Delete")
            {
                $query = "DELETE FROM users WHERE userId = :id";
                $statement = $db->prepare($query);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();
            }
        }
        else
        {
            //If required form data is not provided then end the session.
            header("Location: usersTable.php");
            die();
        }
    
        //Redirect to the users table page after updating the user.
        header("Location: usersTable.php");
        die();
    }
    else
    {
        //If user is not an admin redirect them to the gallery page.
        header("Location: gallery.php");
        die();
    }
?>