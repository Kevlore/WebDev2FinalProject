<?php 
    require 'connect.php';

    //Check to make sure the name, description and image fields have been set.
    if(strlen($_POST['name']) > 0 && strlen($_POST['description']) > 0 && isset($_FILES['image']) && $_FILES['image']['error'] === 0); {
        //Sanitize the fields.
        $photoName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $photoName = filter_var($photoName, FILTER_SANITIZE_STRING);
        
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = filter_var($description, FILTER_SANITIZE_STRING);

        //If the create button is clicked insert the photo form data into the database.
        if($_POST['command'] == "Create") {
            $query = "INSERT INTO photos (name, description) values (:name, :description)";
            $statement = $db->prepare($query);
            $statement->bindValue(':name', $photoName);
            $statement->bindValue(':description', $description);
            $statement->execute();
        }
    }
    else
    {
        //If required form data is not provided then end the session.
        header("Location: fileUpload.php");
        die();
    }
?>