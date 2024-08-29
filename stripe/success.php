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

    $cartQuery = "SELECT product_id, quantity FROM shopping_cart WHERE user_id = $user_id";
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
     
        $productQuery = "SELECT price FROM products WHERE product_id = $product_id";
        $productResult = mysqli_query($connect, $productQuery);
        $product = mysqli_fetch_assoc($productResult);

        if ($product) {
            $totalAmount += $product['price'] * $quantity;
        }
    }

    $sql = "DELETE FROM shopping_cart WHERE user_id = $user_id";
    mysqli_query($connect, $sql);

    $productArr = json_encode($productArr);
    $orderQuery = "INSERT INTO orders (user_id, total_amount, order_status, products)
    VALUES ('$user_id', '$totalAmount', 'completed', '$productArr')";
    mysqli_query($connect, $orderQuery);

    echo "
    <style>
        body {
            background-color: var(--lemon-meringue);
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        :root {
            --dark-olive-green: #5F6F52;
            --lemon-meringue: #F9EBC7;
            --russet: #783D19;
            --camel: #B99470;
        }

        .order-confirmation {
            text-align: center;
            padding: 50px;
            background-color: var(--lemon-meringue);
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .circle, .icon-check {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .circle {
            width: 100px;
            height: 100px;
            background-color: var(--dark-olive-green);
            border-radius: 50%;
            margin-bottom: 20px;
            position: relative;
        }

        .icon-check {
            color: var(--lemon-meringue);
            width: 50px;
            height: 50px;
        }

        h1 {
            color: var(--russet);
            font-size: 2em;
            margin-bottom: 20px;
        }

        p {
            color: var(--camel);
            font-size: 1.2em;
        }

        .order-actions {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .order-continue-button button {
            background-color: var(--dark-olive-green);
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 1.2em;
            cursor: pointer;
            border-radius: 5px;
        }

        .order-continue-button button:hover {
            background-color: var(--camel);
        }

        .shin-logo {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            position: relative;
            display: none;
        }

        .shin-circle {
            stroke-dasharray: 502;
            stroke-dashoffset: 502;
            animation: draw-circle 2s ease forwards;
        }

        .shin-text {
            font-size: 30px;
            text-anchor: middle;
            font-family: Arial, sans-serif;
            fill: black;
            opacity: 0;
            animation: fadeInText 2s ease forwards;
            animation-delay: 2s;
            dominant-baseline: middle;
        }

        @keyframes draw-circle {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: scale(0.5);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fadeInText {
            to {
                opacity: 1;
            }
        }
    </style>

    <div class='order-confirmation'>
        <div class='circle' id='checkmarkContainer'>
            <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon-check'>
                <path d='M20 6L9 17l-5-5'></path>
            </svg>
        </div>

        <svg class='shin-logo' id='shinLogoContainer' viewBox='0 0 100 100'>
            <circle class='shin-circle' cx='50' cy='50' r='40' stroke='black' stroke-width='2' fill='none' />
            <text x='50%' y='50%' class='shin-text'>SHIN</text>
        </svg>

        <h1>Thank you for your shopping with us!</h1>

        <div class='order-actions'>
            <a href='/' class='order-continue-button'>
                <button>Continue Shopping</button>
            </a>
        </div>
    </div>

    <script>
       document.addEventListener('DOMContentLoaded', function() {
        const checkmarkContainer = document.getElementById('checkmarkContainer');
        const shinLogoContainer = document.getElementById('shinLogoContainer');

        checkmarkContainer.addEventListener('animationend', function() {
            checkmarkContainer.style.display = 'none'; // Hide the checkmark container
            shinLogoContainer.style.display = 'block'; // Show the SHIN logo
        });

        setTimeout(function() {
            checkmarkContainer.style.animation = 'fadeOut 0.5s forwards';
        }, 100); // Adjust the delay as needed
    });
    </script>
    ";
    
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
