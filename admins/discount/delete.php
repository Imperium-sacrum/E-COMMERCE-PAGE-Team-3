<?php

// session_start();
// if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
//     header("Location: ../login.php");
//     exit();
// }
// if (isset($_SESSION["user"])) {
//     header("Location: ../homepage.php");
//     exit();
// }

require_once "../../db_components/db_connect.php";
$id = $_GET["id"];
$sql = "SELECT * FROM `discounts` WHERE discount_id = {$id}";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);



$delete_sql = "DELETE FROM `discounts` WHERE discount_id  = {$id}";
mysqli_query($connect, $delete_sql);
header("location:../dashboard.html");
