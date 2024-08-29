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
require_once '../../vendor/autoload.php';
require_once '../../stripe/secrets.php';
$id = $_GET["id"];
$sql = "SELECT * FROM `products` WHERE product_id = {$id}";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);



if ($row["image"] != "default.jpg") {
    unlink("../images/{$row["image"]}");
}

$stripe = new \Stripe\StripeClient($stripeSecretKey);


// to retrive a price
$priceId = $stripe->prices->retrieve($row["priceId"]);

// to bring productId
$productId = $priceId->product;

$prices = $stripe->prices->all(['product' => $productId]);


foreach ($prices->data as $price) {
    $stripe->prices->update($price->id, [
        'active' => false
    ]);
}

$stripe->products->update($productId, ['active' => false]);
$delete_sql = "DELETE FROM `products` WHERE product_id = {$id}";
mysqli_query($connect, $delete_sql);
$sqld = "DELETE FROM * FROM `reviews` WHERE product_id = {$id}";
mysqli_query($connect, $sqld);
header("location:../dashboard.php");
