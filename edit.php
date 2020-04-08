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
        <input type="hidden" name="id" value="<?=$selectedPhoto['photoId']?>" />
        <input type="submit" name="command" value="Update" />
        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this photo?')" />
    </form>
</body>
</html>