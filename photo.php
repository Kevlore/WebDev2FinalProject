<?php 
    require "connect.php";
    require "currentUser.php";

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
            header("Location: gallery.php");
        }

        if($photoId == $photo['photoId']) {
            $selectedPhoto = $photo;
        }
    endforeach;

    $genreId = $selectedPhoto['genreId'];

    $query = "SELECT * FROM genres WHERE genreId = $genreId";
    $statement = $db->prepare($query);
    $statement->execute();
    $selectedGenre = $statement->fetch();

    $query = "SELECT * FROM comments WHERE photoId = :photoId ORDER BY uploadTime DESC";
    $getComments = $db->prepare($query);
    $getComments->bindValue(':photoId', $selectedPhoto['photoId']);
    $getComments->execute();
    $comments = $getComments->fetchAll();
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
    <div id="photoFrame">
        <h2><?=$selectedPhoto['name']?></h2>
        <img src="<?=$selectedPhoto['fileLocation']?>" alt="<?=$selectedPhoto['name']?>" title="<?=$selectedPhoto['name']?>"/>
        <h5><?=$selectedPhoto['description']?></h5>
        <h5>Genre: <?=$selectedGenre['name']?></h5>
        <h6><?=$selectedPhoto['uploadTime']?></h6>
        <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) : ?>
            <a href="edit.php?id=<?=$selectedPhoto['photoId']?>">edit</a>
        <?php endif; ?>
    </div>
    <div id="commentSection">
        <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] >= 0) : ?>
            <div id="commentForm">
                <form action="uploadComment.php" method="post">
                    <label for="commentSection" id="commentSectionLabel">Leave a comment on this photo: </label>
                    <textarea name="commentArea" id="commentArea" cols="50" rows="3" required></textarea>
                    <input type="hidden" name="photoId" value="<?=$selectedPhoto['photoId']?>">
                    <input type="hidden" name="userId" value="<?=$_SESSION['userId']?>">
                    <input type="submit" name="command" value="Comment" />
                </form>
        <?php else : ?>
            <a href="loginPage.php">Log in to leave a comment</a>
        <?php endif; ?>
            </div>
            <div id="commentList">
                <?php foreach($comments as $comment) : 
                    $query = "SELECT * FROM users WHERE userId = :userId";
                    $getUser = $db->prepare($query);
                    $getUser->bindValue(':userId', $comment['userId']);
                    $getUser->execute();
                    $user = $getUser->fetch();
                ?>
                    <div class="individualComment">
                        <h7><?=$user['username']?></h7>
                        <div class="commentText"><?=$comment['text']?></div>
                    </div>
                    <?php if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0) : ?>
                        <form action="deleteComment.php" method="post">
                            <input type="hidden" name="photoId" value="<?=$selectedPhoto['photoId']?>" />
                            <input type="hidden" name="commentId" value="<?=$comment['commentId']?>" />
                            <input type="submit" name="command" value="Delete" onclick="return confirm('Are you sure you wish to delete this comment?')" />
                        </form>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
    </div>
</body>
</html>