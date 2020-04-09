<?php
    require 'connect.php';
    require 'currentUser.php';

    //Check to make sure only users with admin privileges can run this code.
    if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) {
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
    <title>Genres</title>
</head>
<body>
    <?php require 'navBar.php'; ?>
    <div id="genresTable">
        <table>
            <tr>
                <th>Genre ID</th>
                <th>Genre</th>
                <th>Description</th>
            </tr>
            <form action="processGenre.php" method="post">
                <?php foreach($genres as $genre) : ?>
                    <tr>
                        <td><?=$genre['genreId']?></td>
                        <input type="hidden" value="<?=$genre['genreId']?>" name="genreId" required />
                        <td><input type="text" value="<?=$genre['name']?>" name="name" required /></td>
                        <td><input type="text" value="<?=$genre['description']?>" name="description" required /></td>
                        <td><input type="submit" name="command" value="Update" /></td>
                        <td><input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this genre?')" /></td>
                    </tr>
                <?php endforeach; ?>
            </form>
        </table>
    </div>
    <div id="genreCreate">
        <form action="processGenre.php" method="post">
            <label for="name">Genre: </label>
            <input type="text" name="name" id="name" required />
            <label for="description">Description</label>
            <input type="text" name="description" id="description" required />
            <input type="submit" name="command" value="Create" />
        </form>
    </div>
</body>
</html>