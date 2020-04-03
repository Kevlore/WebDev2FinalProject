<?php 
    require 'connect.php';

    if(isset($_POST['id'])) {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    }

    //Check to make sure the name, description and image fields have been provided.
    if(strlen($_POST['name']) > 0 && strlen($_POST['description']) > 0 ) {
        //Sanitize the fields.
        $photoName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $photoName = filter_var($photoName, FILTER_SANITIZE_STRING);
        
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($description, FILTER_SANITIZE_STRING);

        if($_POST['command'] == "Update")
        {
            $query = "UPDATE photos SET name = :name, description = :description WHERE photoId = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':name', $photoName);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':id', $id);
            $statement->execute();
        }
        //If the delete button is clicked remove the selected post from the database.
        else if($_POST['command'] == "Delete")
        {
            $query = "DELETE FROM photos WHERE photoId = :id";
            $statement = $db->prepare($query);
            $statement->bindValue(':id', $id, PDO::PARAM_INT);
            $statement->execute();
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
?>