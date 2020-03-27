<?php 
    require "connect.php";

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
    <a href="gallery.php"><h1>Back to Gallery</h1></a>
    <h2><?=$selectedPhoto['name']?></h2>
    <img src="<?=$selectedPhoto['fileLocation']?>" alt="<?=$selectedPhoto['name']?>" title="<?=$selectedPhoto['name']?>"/>
    <h5><?=$selectedPhoto['description']?></h5>
    <h6><?=$selectedPhoto['uploadTime']?></h6>
</body>
</html>