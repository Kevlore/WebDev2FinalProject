<?php 
    require "connect.php";
    require "currentUser.php";

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
    <div id="loginBar">
        <?php if(!isset($_SESSION['userId'])) : ?>
            <a href="loginPage.php">Go to login page</a>
        <?php else : ?>
            <p><?=$_SESSION['loginMessage'] . $_SESSION['username']?></p>
            <a href="logout.php">Logout</a>
        <?php endif; ?>
    </div>
    <?php require "navBar.php"; ?>

    <?php foreach($photos as $photo) : ?>
        <a href="photo.php?photoId=<?=$photo['photoId']?>"><img src="<?=$photo['fileLocation']?>" alt="<?=$photo['name']?>" title="<?=$photo['name']?>"/></a>
    <?php endforeach; ?>
    <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) : ?>
        <a href="fileUpload.php">Upload a photo</a>
    <?php endif; ?>
</body>
</html>