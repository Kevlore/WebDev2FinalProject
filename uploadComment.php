<?php 
    require 'connect.php';
    require "currentUser.php";

    //Check to make sure only users with admin or logged in privileges can run this code.
    if(isset($_SESSION['userType']) && $_SESSION['userType'] >= 0) {
        //Check to make sure the fields have been provided.
        if(strlen($_POST['userId']) > 0 && strlen($_POST['commentArea']) > 0 && strlen($_POST['photoId']) > 0) {
            //Sanitize the fields.
            $userId = filter_input(INPUT_POST, 'userId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
            
            $commentArea = filter_input(INPUT_POST, 'commentArea', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $commentArea = filter_var($commentArea, FILTER_SANITIZE_STRING);

            $photoId = filter_input(INPUT_POST, 'photoId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $photoId = filter_var($photoId, FILTER_SANITIZE_NUMBER_INT);
    
            if($_POST['command'] == "Comment") {
                $query = "INSERT INTO comments (userId, text, photoId) values (:userId, :commentArea, :photoId)";
                $statement = $db->prepare($query);
                $statement->bindValue(':userId', $userId);
                $statement->bindValue(':commentArea', $commentArea);
                $statement->bindValue(':photoId', $photoId);
                $statement->execute();

                //Redirect to the photo page after uploading comment.
                header("Location: photo.php?photoId=$photoId");
                die();
            }
        }
        else
        {
            //If required form data is not provided then end the session.
            header("Location: gallery.php");
            die();
        }
    }
    else
    {
        //If user is not an admin redirect them to the gallery page.
        header("Location: gallery.php");
        die();
    }
    
?>