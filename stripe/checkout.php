<?php
session_start();
require_once '../vendor/autoload.php';
require_once 'secrets.php';
require_once '../db_components/db_connect.php';

if (isset($_GET["checkout"])) {
    $userId = $_SESSION["username"];
    $stripe = new \Stripe\StripeClient($stripeSecretKey);

    $sql = "SELECT products.priceId, shopping_cart.quantity FROM products JOIN shopping_cart on shopping_cart.product_id = products.product_id WHERE shopping_cart.user_id = {$userId}";
    $result = mysqli_query($connect, $sql);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $prices = [];

    foreach ($rows as $row) {
        array_push($prices, [
            'price' => $row['priceId'],
            'quantity' => $row['quantity']
        ]);
    }
    $YOUR_DOMAIN = 'http://localhost:3001';

    $session = $stripe->checkout->sessions->create([
        'line_items' => $prices,
        'mode' => 'payment',
        'success_url' => $YOUR_DOMAIN . '/stripe/success.php',
    ]);

    header("HTTP/1.1 303 See Other");
    header("Location: " . $session->url);
}
