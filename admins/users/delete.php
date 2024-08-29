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
$id = $_GET["id"];
$sql = "SELECT * FROM `users` WHERE user_id = {$id}";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);


if ($row["image"] != "default.jpg") {
    unlink("../images/{$row["image"]}");
}
$delete_sql = "DELETE FROM `users` WHERE user_id = {$id}";
mysqli_query($connect, $delete_sql);
header("location:../dashboard.php");
