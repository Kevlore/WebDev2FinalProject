<?php
    require "connect.php";

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$selectedPhoto['name']?></title>
</head>
<body>
<a href="gallery.php"><h1>Back to Gallery</h1></a>
    <form action="fileProcessing.php">
        <h2><?=$selectedPhoto['name']?></h2>
        <img src="<?=$selectedPhoto['fileLocation']?>" alt="<?=$selectedPhoto['name']?>" title="<?=$selectedPhoto['name']?>"/>
        <h5><?=$selectedPhoto['description']?></h5>
        <h6><?=$selectedPhoto['uploadTime']?></h6>
        <input type="hidden" name="id" value="<?=$selectedPhoto['postId']?>" />
        <input type="submit" name="command" value="Update" />
        <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this photo?')" />
    </form>
</body>
</html>