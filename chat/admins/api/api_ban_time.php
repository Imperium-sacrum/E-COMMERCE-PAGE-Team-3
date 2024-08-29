<?php
session_start();


if (!isset($_SESSION["username"]) && !isset($_SESSION["admin"])) {
    header("Location: ../../session/login.php");
    exit();
}

if (isset($_SESSION["username"])) {
    header("Location: ../../index.php");
    exit();
}


require_once "../../db_components/db_connect.php";


$id = $val = "";


header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Origin: *");


if (isset($_GET["id"]) && isset($_GET["val"])) {
    $id = intval($_GET["id"]);
    $val = $_GET["val"];


    $val = str_replace("T", " ", $val);


    $val = substr($val, 0, 16) . ":00";


    $sql = "UPDATE `users` SET `timeBan`='$val' WHERE `user_id`=$id";

    if ($result = mysqli_query($connect, $sql)) {
        response(200, "User status changed", null);
    } else {

        response(500, "SQL error: " . mysqli_error($connect), null);
    }
} else {

    response(400, "Missing parameters", null);
}


mysqli_close($connect);

/**
 * 
 *
 * @param int 
 * @param string 
 * @param mixed 
 */
function response($status, $status_message, $data)
{
    header("HTTP/1.1 $status $status_message");

    $response = array(
        'status' => $status,
        'status_message' => $status_message,
        'data' => $data
    );

    echo json_encode($response, JSON_PRETTY_PRINT);
}
