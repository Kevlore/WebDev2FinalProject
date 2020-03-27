<?php 
    require 'connect.php';

    //Determine the upload path for the uploaded photo.
    function file_upload_path($original_filename, $upload_subfolder_name = 'photos') {
        $current_folder = dirname(__FILE__);
        $path_segments = [$current_folder, $upload_subfolder_name, basename($original_filename)];
        return join(DIRECTORY_SEPARATOR, $path_segments);
    }
 
     $image_upload_detected = isset($_FILES['image']) && ($_FILES['image']['error'] === 0);
 
     //Determine if the file is an acceptable image type.
    function file_is_an_image($temporary_path, $new_path) {
        $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
        $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];
        
        $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
        $actual_mime_type        = mime_content_type($temporary_path);
        
        $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
        $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);
        
        return $file_extension_is_valid && $mime_type_is_valid;
    }
     
    //Detect if an file has been uploaded.
    if ($image_upload_detected) {
        $image_filename       = $_FILES['image']['name'];
        $temporary_image_path = $_FILES['image']['tmp_name'];
        $new_image_path       = file_upload_path($image_filename);

        //If the uploaded file is an image move the file onto the host.
        if (file_is_an_image($temporary_image_path, $new_image_path)) {
            move_uploaded_file($temporary_image_path, $new_image_path);

            //Check to make sure the name, description and image fields have been provided.
            if(strlen($_POST['name']) > 0 && strlen($_POST['description']) > 0 && isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                //Sanitize the fields.
                $photoName = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $photoName = filter_var($photoName, FILTER_SANITIZE_STRING);
                
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $description = filter_var($description, FILTER_SANITIZE_STRING);
        
                $fileLocation = 'photos' . DIRECTORY_SEPARATOR . $_FILES['image']['name'];
        
                //If the create button is clicked insert the photo form data into the database.
                if($_POST['command'] == "Create") {
                    $query = "INSERT INTO photos (name, description, fileLocation) values (:name, :description, :fileLocation)";
                    $statement = $db->prepare($query);
                    $statement->bindValue(':name', $photoName);
                    $statement->bindValue(':description', $description);
                    $statement->bindValue(':fileLocation', $fileLocation);
                    $statement->execute();
                }
                //Redirect to the gallery page after uploading image.
                header("Location: gallery.php");
                die();
            }
        }
        else {
            //If required form data is not provided then end the session.
            header("Location: fileUpload.php");
            die();
        }
    }
?>