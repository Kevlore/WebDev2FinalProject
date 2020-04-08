<?php 
    require 'connect.php';
    require 'currentUser.php';

    //Check to make sure only users with admin privileges can run this code.
    if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) {
        //Retrieves all columns from the genres table in the database.
        $query = "SELECT * FROM genres";
        $selectAll = $db->prepare($query);
        $selectAll->execute();
        $genres = $selectAll->fetchAll();
    }
    else
    {
        //If user is not an admin redirect them to the gallery page.
        header("Location: gallery.php");
        die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Upload</title>
</head>
<body>
    <?php require "navBar.php"; ?>
    <form action="fileProcessing.php" method="post" enctype="multipart/form-data">
        <label for="name">Photo Name: </label>
        <input type="text" name="name" id="name" required/>
        <label for="description">Description: </label>
        <input type="text" name="description" id="description" required/>
        <label for="genre">Select a genre: </label>
        <select id="genre">
            <?php 
                foreach($genres as $genre) :
            ?>
            <option value="<?=$genre['genreId']?>" title="<?=$genre['description']?>"><?=$genre['name']?></option>
            <?php 
                endforeach;
            ?>
        </select>
        <label for="image">Image: </label>
        <input type="file" name="image" id="image" required/>
        <input type="submit" name="command" value="Create" />
    </form>
</body>
</html>