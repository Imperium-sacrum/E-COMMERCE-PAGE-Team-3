<?php
session_start();
require_once "./db_components/db_connect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = (int)$_POST['product_id'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity']++;
    } else {
        $_SESSION['cart'][$productId] = ['quantity' => 1];
    }
    $qtty = 1;
    $checksql = "SELECT * FROM `shopping_cart` where product_id = $productId";
    $result = mysqli_query($connect, $checksql);
    if (mysqli_num_rows($result) == 1) {
        $updatesql = "UPDATE `shopping_cart` SET `quantity`=$qtty+1 WHERE product_id = $productId";
        mysqli_query($connect, $updatesql);
    } elseif (mysqli_num_rows($result) == 0) {
        $sql = "INSERT INTO `shopping_cart`(`product_id`, `quantity`, `user_id`) VALUES ($productId,$qtty,{$_SESSION["username"]})";
        mysqli_query($connect, $sql);
    }

    header('Location: cart.php');
    exit();
}
