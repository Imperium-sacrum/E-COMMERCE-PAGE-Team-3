<?php
session_start();

require_once '../vendor/autoload.php';
require_once 'secrets.php';
require_once '../db_components/db_connect.php'; 

\Stripe\Stripe::setApiKey($stripeSecretKey);

try {
    if (!isset($_SESSION['username'])) {
        throw new Exception('User is not logged in.');
    }

    $user_id = $_SESSION['username'];

    // Check if session_id is present in the URL
    if (!isset($_GET['session_id'])) {
        throw new Exception('Session ID is missing from the URL.');
    }

    $session_id = $_GET['session_id'];
    $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
    $paymentIntent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);

    // Extract relevant information
    $paymentStatus = $paymentIntent->status;
    $paymentAmount = $paymentIntent->amount_received / 100;
    $paymentCurrency = $paymentIntent->currency;

    // Retrieve the user's cart items from the shopping_cart table
    $cartQuery = "SELECT product_id, quantity FROM shopping_cart WHERE user_id = $user_id";
    $cartResult = mysqli_query($connect, $cartQuery);

    if (!$cartResult) {
        throw new Exception('Error fetching cart items: ' . mysqli_error($connect));
    }

    while ($cartItem = mysqli_fetch_assoc($cartResult)) {
        $product_id = $cartItem['product_id'];
        $quantity = $cartItem['quantity'];

     
        $productQuery = "SELECT price FROM products WHERE product_id = $product_id";
        $productResult = mysqli_query($connect, $productQuery);
        $product = mysqli_fetch_assoc($productResult);

        if ($product) {
            $totalAmount = $product['price'] * $quantity;

            // Insert order into the orders table
            $orderQuery = "INSERT INTO orders (user_id, total_amount, order_status, products)
                           VALUES ('$user_id', '$totalAmount', 'completed', '$product_id')";
            mysqli_query($connect, $orderQuery);
        }
    }

    echo "<h1>Thank you for your order!</h1>";

} catch (Exception $e) {
    // Handle error
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
