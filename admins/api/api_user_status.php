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

header("Content-Type: application/json");
header("Access-Control-Allow-Method: GET");
header("Access-Control-Allow-Origin: *");

$id = $_GET["id"];
$sql = "UPDATE users SET status = !STATUS WHERE user_id = $id";
if ($result = mysqli_query($connect, $sql)) {

    response(200, "user status changed", null);
} else {
    // No records found
    response(404, "No user found", null);
}

// Closing database connection
mysqli_close($connect);

/**
 * Function to send a JSON response
 *
 * @param int $status HTTP status code
 * @param string $status_message Status message
 * @param mixed $data Data to be included in the response
 */
function response($status, $status_message, $data)
{
    header("HTTP/1.1 $status $status_message");

    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;

    echo json_encode($response, JSON_PRETTY_PRINT);
}
