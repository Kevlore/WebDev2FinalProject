<?php 
    require "connect.php";
    require "currentUser.php";

    if(!isset($_SESSION['userId'])) { ?>
        <a href=""></a>
    <?php
    }

    $query = "SELECT * FROM photos";
    $selectAll = $db->prepare($query);
    $selectAll->execute();
    $photos = $selectAll->fetchAll();

    foreach($photos as $photo) :
        if(filter_input(INPUT_GET, 'photoId', FILTER_VALIDATE_INT)) {
            $photoId = $_GET['photoId'];
        }
        else
        {
            header("Location: /gallery.php");
        }

        if($photoId == $photo['photoId']) {
            $selectedPhoto = $photo;
            $uploadTime = $photo['uploadTime'];
        }
    endforeach;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo</title>
</head>
<body>
    <?php require "navBar.php"; ?>
    <h2><?=$selectedPhoto['name']?></h2>
    <img src="<?=$selectedPhoto['fileLocation']?>" alt="<?=$selectedPhoto['name']?>" title="<?=$selectedPhoto['name']?>"/>
    <h5><?=$selectedPhoto['description']?></h5>
    <h6><?=$selectedPhoto['uploadTime']?></h6>
    <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) : ?>
        <a href="edit.php?id=<?=$selectedPhoto['photoId']?>">edit</a>
    <?php endif; ?>
</body>
</html>