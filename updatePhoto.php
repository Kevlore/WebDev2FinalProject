<?php 
    require 'connect.php';
    require "currentUser.php";

    //Check to make sure only users with admin privileges can run this code.
    if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) {
        if(isset($_POST['id'])) {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    
            $query = "SELECT * FROM photos WHERE photoId = $id";
            $statement = $db->prepare($query);
            $statement->execute();
            $selectedPhoto = $statement->fetch();
        }
    
        //Check to make sure the name, description and image fields have been provided.
        if(strlen($_POST['name']) > 0 && strlen($_POST['description']) > 0 && strlen($_POST['genreId']) > 0) {
            //Sanitize the fields.
            $photoName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $photoName = filter_var($photoName, FILTER_SANITIZE_STRING);
            
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $description = filter_var($description, FILTER_SANITIZE_STRING);

            $genreId = filter_input(INPUT_POST, 'genreId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $genreId = filter_var($genreId, FILTER_SANITIZE_NUMBER_INT);
    
            if($_POST['command'] == "Update")
            {
                $query = "UPDATE photos SET name = :name, description = :description, genreId = :genreId WHERE photoId = :id";
                $statement = $db->prepare($query);
                $statement->bindValue(':name', $photoName);
                $statement->bindValue(':description', $description);
                $statement->bindValue(':id', $id);
                $statement->bindValue(':genreId', $genreId);
                $statement->execute();

                if(isset($_POST['createType']) && $_POST['createType'] == "update") {
                    //If this update was triggered from the photos table then redirect user back to that page after updating photo.
                    header("Location: photosTable.php");
                    die();
                }
            }
            //If the delete button is clicked remove the selected post from the database.
            else if($_POST['command'] == "Delete")
            {
                $query = "DELETE FROM photos WHERE photoId = :id";
                $statement = $db->prepare($query);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();
    
                if(!unlink($selectedPhoto['fileLocation'])) {
                    echo ("This photo could not be deleted due to an error.");
                }
                else
                {
                    echo ("This photo was successfully deleted.");
                }

                if(isset($_POST['createType']) && $_POST['createType'] == "update") {
                    //If this update was triggered from the photos table then redirect user back to that page after deleting photo.
                    header("Location: photosTable.php");
                    die();
                }
            }
        }
        else
        {
            //If required form data is not provided then end the session.
            header("Location: edit.php");
            die();
        }
    
        //Redirect to the gallery page after uploading image.
        header("Location: gallery.php");
        die();
    }
    else
    {
        //If user is not an admin redirect them to the gallery page.
        header("Location: gallery.php");
        die();
    }
    
?>