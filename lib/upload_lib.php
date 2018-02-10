<?php
namespace lib;


function uploadAvatar($new_filename, $new_charID)
{
    $db = new Database;
    $newFile = $new_filename;
    $charID = stripslashes($new_charID);
    //Undefined | Multiple Files | $_FILES Corruption Attack
    //If this request falls under any of them, treat it invalid.
    if(!isset($newFile['error']) || is_array($newFile['error']))
    {
        throw new RuntimeException('Invalid parameters.');
    }
    $target_dir = "images/icons/characters/";
    $target_file = $target_dir . basename($newFile["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"]))
    {
        $check = getimagesize($newFile["tmp_name"]);
        if($check !== false)
        {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        }
        else
        {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    }
    else {
        if (move_uploaded_file($newFile["tmp_name"], $target_file)) {
            //echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            //$info = pathinfo($newFile["name"]);
            //$filename = basename($newFile["name"]);
            $filename = pathinfo($target_file,PATHINFO_FILENAME);
            if($charID != false) {
                $stmt = $db->prepare('SELECT USERID FROM USER_CHARACTER WHERE ID = ?');
                $stmt->execute([$charID]);
                $userID = $stmt->fetchColumn();
                if($userID == $_SESSION['ID']) {
                    $stmt = $db->prepare('UPDATE USER_CHARACTER SET AVATAR = ? WHERE ID = ?');
                    $stmt->execute([$filename, $charID]);
                }
            } elseif (!$charID) {
                return $filename;
            }
            else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }      
}
?>