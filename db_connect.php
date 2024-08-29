<?php
ini_set('display_errors', '1');
ini_set('error_reporting', E_ALL);

$hostname = "173.212.235.205";
$username = "joshuacodefactor_projectTeam3";
$password = "jEFEmAESTRO_!!/";
$dbname = "joshuacodefactor_e_commerce_team3";

// the host name is : 173.212.235.205
// user:joshuacodefactor_projectTeam3
// Database:joshuacodefactor_e_commerce_team3
// password:jEFEmAESTRO_!!/


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
