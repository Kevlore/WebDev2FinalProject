<?php 
    require "connect.php";
    require "currentUser.php";

    if(isset($_POST['searchTerm']) && strlen($_POST['searchTerm']) > 0)
    {
        $searchTerm = filter_input(INPUT_POST, 'searchTerm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $searchTerm = filter_var($searchTerm, FILTER_SANITIZE_STRING);
        $searchTerm = strtoupper($searchTerm);
        $searchTerm = "%$searchTerm%";
    }

    if(isset($_POST['genreSort'])){
        $genreSort = filter_input(INPUT_POST, 'genreSort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $genreSort = filter_var($genreSort, FILTER_SANITIZE_NUMBER_INT);
    }

    if(isset($searchTerm) && isset($genreSort) && $genreSort != -1 && $genreSort != -2)
    {
        $query = "SELECT * FROM photos WHERE genreId = :genreSort AND UPPER(name) LIKE :searchTerm";
        $selectAll = $db->prepare($query);
        $selectAll->bindValue(':genreSort', $genreSort);
        $selectAll->bindValue(':searchTerm', $searchTerm);
        $selectAll->execute();
        $photos = $selectAll->fetchAll();
    }
    else if(isset($searchTerm) && isset($genreSort) && $genreSort != -2)
    {
        $query = "SELECT * FROM photos WHERE UPPER(name) LIKE :searchTerm";
        $selectAll = $db->prepare($query);
        $selectAll->bindValue(':searchTerm', $searchTerm);
        $selectAll->execute();
        $photos = $selectAll->fetchAll();
    }
    else if(isset($searchTerm))
    {
        $query = "SELECT * FROM photos WHERE UPPER(name) LIKE :searchTerm";
        $selectAll = $db->prepare($query);
        $selectAll->bindValue(':searchTerm', $searchTerm);
        $selectAll->execute();
        $photos = $selectAll->fetchAll();
    }
    else if(isset($genreSort) && $genreSort != -1 && $genreSort != -2)
    {
        $query = "SELECT * FROM photos WHERE genreId = :genreSort";
        $selectAll = $db->prepare($query);
        $selectAll->bindValue(':genreSort', $genreSort);
        $selectAll->execute();
        $photos = $selectAll->fetchAll();
    }
    else
    {
        $query = "SELECT * FROM photos";
        $selectAll = $db->prepare($query);
        $selectAll->execute();
        $photos = $selectAll->fetchAll();
    }

    //Query the genres for the genre sort.
    $query = "SELECT * FROM genres";
    $selectAll = $db->prepare($query);
    $selectAll->execute();
    $genres = $selectAll->fetchAll();
    
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
    <form action="gallery.php" method="post">
        <label for="genreSort">Sort photos by: </label>
        <select name="genreSort" id="genreSort">
            <option value="-2">Select a genre</option>
            <option value="-1">All</option>
            <?php foreach($genres as $genre) : ?>
                <option value="<?=$genre['genreId']?>" title="<?=$genre['description']?>"><?=$genre['name']?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="command" value="Sort" />
        <input type="text" name="searchTerm" />
        <input type="submit" value="Search" />
    </form>
    <div id="gallery">
        <?php foreach($photos as $photo) : ?>
            <a href="photo.php?photoId=<?=$photo['photoId']?>"><img src="<?=$photo['fileLocation']?>" alt="<?=$photo['name']?>" title="<?=$photo['name']?>"/></a>
        <?php endforeach; ?>
        <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) : ?>
            <a href="fileUpload.php">Upload a photo</a>
        <?php endif; ?>
    </div>
</body>
</html>