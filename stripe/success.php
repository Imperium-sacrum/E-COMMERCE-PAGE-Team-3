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


    $userQuery = "SELECT email FROM users WHERE user_id = '$user_id'";
    $userResult = mysqli_query($connect, $userQuery);
    if (!$userResult) {
        throw new Exception('Error fetching user details: ' . mysqli_error($connect));
    }
    $user = mysqli_fetch_assoc($userResult);
    if (!$user) {
        throw new Exception('User not found.');
    }
    $userEmail = $user['email'];


    $cartQuery = "SELECT product_id, quantity FROM shopping_cart WHERE user_id = '$user_id'";
    $cartResult = mysqli_query($connect, $cartQuery);
    if (!$cartResult) {
        throw new Exception('Error fetching cart items: ' . mysqli_error($connect));
    }

    $totalAmount = 0;

    $productArr = [];
    while ($cartItem = mysqli_fetch_assoc($cartResult)) {
        $product_id = $cartItem['product_id'];
        $quantity = $cartItem['quantity'];
        $productArr[] = [$cartItem['product_id'], $cartItem['quantity']];


        $productQuery = "SELECT product_name, price FROM products WHERE product_id = '$product_id'";
        $productResult = mysqli_query($connect, $productQuery);
        if (!$productResult) {
            throw new Exception('Error fetching product details: ' . mysqli_error($connect));
        }
        $product = mysqli_fetch_assoc($productResult);
        if ($product) {
            $totalAmount += $product['price'] * $quantity;
        }
    }


    $productArrJson = json_encode($productArr);
    $orderQuery = "INSERT INTO orders (user_id, total_amount, order_status, products) VALUES ('$user_id', '$totalAmount', 'completed', '$productArrJson')";
    if (!mysqli_query($connect, $orderQuery)) {
        throw new Exception('Error inserting order: ' . mysqli_error($connect));
    }

    $clearCartQuery = "DELETE FROM shopping_cart WHERE user_id = '$user_id'";
    if (!mysqli_query($connect, $clearCartQuery)) {
        throw new Exception('Error clearing cart: ' . mysqli_error($connect));
    }


    $emailBody = "Thank you for your order!\n\n";
    $emailBody .= "Order Summary:\n";

    foreach ($productArr as $item) {
        $product_id = $item[0];
        $quantity = $item[1];
        $productQuery = "SELECT product_name, price FROM products WHERE product_id = '$product_id'";
        $productResult = mysqli_query($connect, $productQuery);
        if (!$productResult) {
            throw new Exception('Error fetching product details: ' . mysqli_error($connect));
        }
        $product = mysqli_fetch_assoc($productResult);
        if ($product) {
            $emailBody .= "{$product['product_name']} x $quantity - €" . number_format($product['price'], 2) . "\n";
        }
    }

    $emailBody .= "\nTotal Price: €" . number_format($totalAmount, 2);


    $to = $userEmail;
    $subject = "Your Order Confirmation";
    $headers = "From: no-reply@yourdomain.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    if (!mail($to, $subject, $emailBody, $headers)) {
        throw new Exception('Error sending email.');
    }

    // Display the confirmation message
    echo "
    <style>
        body {
            background-color: #FEFAE0;
            font-family: Arial, sans-serif;
        }
        .order-confirmation {
            text-align: center;
            padding: 50px;
        }
        .confirmation-icon {
            margin-bottom: 20px;
        }
        .circle {
            width: 100px;
            height: 100px;
            background-color: #5F6F52;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
        .icon-check {
            color: #F9EBC7;
            width: 50px;
            height: 50px;
        }
        h1 {
            color: #783D19;
            font-size: 2em;
        }
        p {
            color: #B99470;
            font-size: 1.2em;
        }
        .order-actions {
            margin-top: 20px;
        }
        .order-continue-button button {
            background-color: #5F6F52;
            color: #FEFAE0;
            border: none;
            padding: 10px 20px;
            font-size: 1.2em;
            cursor: pointer;
            border-radius: 5px;
        }
        .order-continue-button button:hover {
            background-color: #A9B388;
        }
    </style>
    <div class='order-confirmation'>
        <div class='confirmation-icon'>
            <div class='circle'>
                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon-check'>
                    <path d='M20 6L9 17l-5-5'></path>
                </svg>
            </div>
        </div>
        <h1>Thank you for your order!</h1>
        <p>You will receive an email shortly.</p>
        <div class='order-actions'>
            <a href='/' class='order-continue-button'>
                <button>Continue Shopping</button>
            </a>
        </div>
    </div>";
} catch (Exception $e) {
    // Display error message
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
