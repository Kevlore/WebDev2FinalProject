<?php
    define('DB_DSN','mysql:host=localhost;dbname=llphotography;charset=utf8');
    define('DB_USER','llphotography');
    define('DB_PASS','KevLore!12');     

    // Create a PDO object called $db.
    $db = new PDO(DB_DSN, DB_USER, DB_PASS); 
?>