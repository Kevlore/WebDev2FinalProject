<?php 
    require "connect.php";

    $query = "SELECT * FROM photos";
    $selectAll = $db->prepare($query);
    $selectAll->execute();
    $photos = $selectAll->fetchAll();

?>

    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Gallery</title>
</head>
<body>
    <?php
        foreach($photos as $photo) :
    ?>
            <img src="<?=$photo['fileLocation']?>" alt="<?=$photo['name']?>" title="<?=$photo['name']?>"/>
    <?php
        endforeach;
    ?>
</body>
</html>