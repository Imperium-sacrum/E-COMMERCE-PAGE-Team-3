<?php
require_once "db_connect.php";


function fileUpload($picture, $source = "user")
{

    if ($picture["error"] == 4) { // checking if a file has been selected, it will return 0 if you choose a file, and 4 if you didn't
        $pictureName = "avatar-1.png"; // the file name will be product.png (default picture for a user that doesn't have a photo)
        $message = "No picture has been chosen, but you can upload an image later :)";
        if ($source == "product") {
            $pictureName = "product.jpg";
        }
    } else {
        $checkIfImage = getimagesize($picture["tmp_name"]); // checking if you selected an image, return false if you didn't select an image
        $message = $checkIfImage ? "Ok" : "Not an image";
    }

    if ($message == "Ok") {
        $ext = strtolower(pathinfo($picture["name"], PATHINFO_EXTENSION)); // taking the extension data from the image
        $pictureName = uniqid("") . "." . $ext; // changing the name of the picture to random string and numbers
        $destination = "../images/{$pictureName}";  // where the file will be saved
        move_uploaded_file($picture["tmp_name"], $destination); // moving the file to the pictures folder
        if ($source == "product") {
            $destination = "../images/{$pictureName}";
        }
    }

    return [$pictureName, $message]; // returning an array with two values, the name of the picture and the message
}
