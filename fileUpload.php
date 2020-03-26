<?php 
    require 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Upload</title>
</head>
<body>
    <form action="fileProcessing.php" method="post" enctype="multipart/form-data">
        <label for="name">Photo Name: </label>
        <input type="text" name="name" id="name" />
        <label for="description">Description: </label>
        <input type="text" name="description" id="description" />
        <label for="genre">Select a genre: </label>
        <select id="genre"></select>
        <label for="image">Image: </label>
        <input type="file" name="image" id="image" />
        <input type="submit" name="command" value="Create" />
    </form>
</body>
</html>