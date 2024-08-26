<?php
session_start();

if (!isset($_SESSION["username"]) && !isset($_SESSION["admin"])) {
    header("Location: ../session/login.php");
    exit();
}


if (isset($_SESSION["admin"])) {
    header("Location: ../home.php");
    exit();
}

require_once "../db_components/db_connect.php";

$id = $_GET["id"];
$sql = "SELECT * FROM users WHERE user_id = $id ";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

if ($row["image"] != "avatar-1.png") {
    unlink("../images/{$row["image"]}");
}

$sqlDelete = "DELETE FROM `users` WHERE user_id = $id ";
mysqli_query($connect, $sqlDelete);
header("Location: ../session/logout.php?logout");
