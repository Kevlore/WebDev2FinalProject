<?php
    require 'connect.php';
    require 'currentUser.php';

    //Check to make sure only users with admin privileges can run this code.
    if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) {

        if(isset($_POST['photoSort'])) {
            $photoSort = filter_input(INPUT_POST, 'photoSort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $photoSort = filter_var($photoSort, FILTER_SANITIZE_STRING);

            $query = "SELECT * FROM photos ORDER BY $photoSort ASC";
            $selectAll = $db->prepare($query);
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
    <title>Photos</title>
</head>
<body>
    <?php require 'navBar.php'; ?>
    <div id="photosTable">
        <form action="photosTable.php" method="post">
            <label for="photoSort">Sort the photos by: </label>
            <select name="photoSort" id="photoSort">
                <option value="name">Name</option>
                <option value="uploadTime">Upload Date</option>
            </select>
            <input type="submit" name="command" value="Sort" />
        </form>
        <table>
            <tr>
                <th>Photo ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Genre ID</th>
                <th>Upload Date</th>
            </tr>
            <form action="updatePhoto.php" method="post">
                <?php foreach($photos as $photo) : ?>
                    <tr>
                        <td><?=$photo['photoId']?></td>
                        <input type="hidden" value="<?=$photo['photoId']?>" name="id" required />
                        <td><input type="text" value="<?=$photo['name']?>" name="name" required /></td>
                        <td><input type="text" value="<?=$photo['description']?>" name="description" required /></td>
                        <td><input type="text" value="<?=$photo['genreId']?>" name="genreId" required /></td>
                        <td><?=$photo['uploadTime']?></td>
                        <input type="hidden" value="update" name="createType" />
                        <td><input type="submit" name="command" value="Update" /></td>
                        <td><input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this photo?')" /></td>
                    </tr>
                <?php endforeach; ?>
            </form>
        </table>
    </div>
</body>
</html>