<?php  
    require "currentUser.php";
    session_unset();
    header("Location: gallery.php");
    die();
?>