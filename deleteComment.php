<?php
    require "connect.php";
    require "currentUser.php";

    if(isset($_SESSION['userType']) && $_SESSION['userType'] == 0 && strlen($_POST['photoId']) > 0 && strlen($_POST['commentId']) > 0 ) {
        $photoId = filter_input(INPUT_POST, 'photoId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $photoId = filter_var($photoId, FILTER_SANITIZE_NUMBER_INT);

        $commentId = filter_input(INPUT_POST, 'commentId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $commentId = filter_var($commentId, FILTER_SANITIZE_NUMBER_INT);

        $query = "DELETE FROM comments WHERE commentId = :commentId";
        $statement = $db->prepare($query);
        $statement->bindValue(':commentId', $commentId, PDO::PARAM_INT);
        $statement->execute();

        //Redirect to the photo page after uploading comment.
        header("Location: photo.php?photoId=$photoId");
        die();
    }
    else
    {
        //Redirect invalid 
        header("Location: gallery.php");
        die();
    }
?>