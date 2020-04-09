<?php
    require "connect.php";
    require "currentUser.php";

    //Check to make sure only users with admin privileges can run this code.
    if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) {
        $query = "SELECT * FROM photos";
        $selectAll = $db->prepare($query);
        $selectAll->execute();
        $photos = $selectAll->fetchAll();

        foreach($photos as $photo) :
            $photoId = $_GET['id'];
            if($photoId == $photo['photoId']) {
                $selectedPhoto = $photo;
            }
        endforeach;
    }
    else
    {
        //If user is not an admin redirect them to the gallery page.
        header("Location: gallery.php");
        die();
    }

    //Grab all of the genres for the select options.
    $query = "SELECT * FROM genres";
    $selectAll = $db->prepare($query);
    $selectAll->execute();
    $genres = $selectAll->fetchAll();

    //Determine the selected genre for this particular photo.
    $genreId = $selectedPhoto['genreId'];

    $query = "SELECT * FROM genres WHERE genreId = $genreId";
    $statement = $db->prepare($query);
    $statement->execute();
    $selectedGenre = $statement->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$selectedPhoto['name']?></title>
</head>
<body>
    <?php require "navBar.php"; ?>
    <form action="updatePhoto.php" method="post">
        <label for="name">Photo Name: </label>
        <input type="text" value="<?=$selectedPhoto['name']?>" name="name" required />
        <img src="<?=$selectedPhoto['fileLocation']?>" alt="<?=$selectedPhoto['name']?>" title="<?=$selectedPhoto['name']?>"/>
        <label for="description">Description: </label>
        <textarea name="description" cols="30" rows="10" required><?=$selectedPhoto['description']?></textarea>
        <select name="genreId" id="genreId">
            <?php foreach($genres as $genre) : ?>
                <option value="<?=$genre['genreId']?>" title="<?=$genre['description']?>" 
                    <?php if($genre['genreId'] == $selectedGenre['genreId']) : ?>
                        selected
                    <?php endif; ?>
                ><?=$genre['name']?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="id" value="<?=$selectedPhoto['photoId']?>" />
        <input type="submit" name="command" value="Update" />
        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this photo?')" />
    </form>
</body>
</html>