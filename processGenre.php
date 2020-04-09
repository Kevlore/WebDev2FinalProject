<?php 
    require 'connect.php';
    require "currentUser.php";

    //Check to make sure only users with admin privileges can run this code.
    if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) {
        if(isset($_POST['genreId'])) {
            $id = filter_input(INPUT_POST, 'genreId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);
    
            $query = "SELECT * FROM genres WHERE genreId = $id";
            $statement = $db->prepare($query);
            $statement->execute();
            $selectedGenre = $statement->fetch();
        }
    
        //Check to make sure the required form fields have been provided.
        if(strlen($_POST['name']) > 0 && strlen($_POST['description']) > 0 ) {
            //Sanitize the fields.
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $name = filter_var($name, FILTER_SANITIZE_STRING);

            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $description = filter_var($description, FILTER_SANITIZE_STRING);
    
            if($_POST['command'] == "Update")
            {
                $query = "UPDATE genres SET name = :name, description = :description WHERE genreId = :id";
                $statement = $db->prepare($query);
                $statement->bindValue(':name', $name);
                $statement->bindValue(':description', $description);
                $statement->bindValue(':id', $id);
                $statement->execute();

                //Redirect user to genres table after the genre has been updated.
                 header("Location: genresTable.php");
                die();
            }
            //If the delete button is clicked remove the selected user from the database.
            else if($_POST['command'] == "Delete")
            {
                $query = "DELETE FROM genres WHERE genreId = :id";
                $statement = $db->prepare($query);
                $statement->bindValue(':id', $id, PDO::PARAM_INT);
                $statement->execute();

                //Redirect user to genres table after the genre has been deleted.
                header("Location: genresTable.php");
                die();
            }
            else if($_POST['command'] == "Create")
            {
                $query = "INSERT INTO genres (name, description) values (:name, :description)";
                $statement = $db->prepare($query);
                $statement->bindValue(':name', $name);
                $statement->bindValue(':description', $description);
                $statement->execute();

                //Redirect user to genres table after the new genre has been created.
                header("Location: genresTable.php");
                die();
            }
        }
        else
        {
            //If required form data is not provided then end the session.
            header("Location: genresTable.php");
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