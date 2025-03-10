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

$sql = "SELECT * FROM `users`";

if ($result = mysqli_query($connect, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        // Fetching data as an associative array
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        response(200, "All products retrieved successfully", $rows);
    } else {
        // No records found
        response(404, "No products found", null);
    }
} else {
    // SQL query failed
    response(500, "Database query failed", array("error" => mysqli_error($connect)));
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
