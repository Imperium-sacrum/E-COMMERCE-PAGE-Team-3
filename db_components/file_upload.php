<?php
require_once "db_connect.php";

function fileUpload($pictures)
{

    if ($pictures["error"] == 4) {
        $pictureName = "avatar-1.png";
        $message = "No picture has been chosen, but you can upload an image later :)";
    } else {
        $checkIfImage = getimagesize($pictures["tmp_name"]);
        $message = $checkIfImage ? "Ok" : "Not an image";
    }

    if ($message == "Ok") {
        $ext = strtolower(pathinfo($pictures["name"], PATHINFO_EXTENSION));
        $pictureName = uniqid("") . "." . $ext;
        $destination = "images/{$pictureName}";
        move_uploaded_file($pictures["tmp_name"], $destination);
    }

    return [$pictureName, $message];
}
