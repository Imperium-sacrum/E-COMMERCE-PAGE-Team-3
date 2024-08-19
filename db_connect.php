<?php
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);

$hostname = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "e_commerce_team3";



$connect = new mysqli($hostname, $username, $password, $dbname);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
function cleanInput($input)
{
    $data = trim($input);
    $data = strip_tags($data);
    $data = htmlspecialchars($data);

    return $data;
}
