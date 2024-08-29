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
    // if (!isset($_GET['session_id'])) {
    //     throw new Exception('Session ID is missing from the URL.');
    // }

    // $session_id = $_GET['session_id'];
    // $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
    // $paymentIntent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);

    // Extract relevant information
    // $paymentStatus = $paymentIntent->status;
    // $paymentAmount = $paymentIntent->amount_received / 100;
    // $paymentCurrency = $paymentIntent->currency;

    // Retrieve the user's cart items from the shopping_cart table
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
            $totalAmount = $totalAmount + ($product['price'] * $quantity);
           
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
        background-color: var(--cornsilk);
        font-family: Arial, sans-serif;
    }

    :root {
    --dark-olive-green: #5F6F52;
    --laurel-green: #A9B388;
    --cornsilk: #FEFAE0;
    --lemon-meringue: #F9EBC7;
    --camel: #B99470;
    --russet: #783D19;
    --highlight-green: var(--dark-olive-green);
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
        background-color: var(--highlight-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
    }

    .icon-check {
        color: var(--lemon-meringue);
        width: 50px;
        height: 50px;
    }

    h1 {
        color: var(--russet);
        font-size: 2em;
    }

    p {
        color: var(--camel);
        font-size: 1.2em;
    }

    .order-actions {
        margin-top: 20px;
    }

    .order-continue-button button {
        background-color: var(--highlight-green);
        color: var(--cornsilk);
        border: none;
        padding: 10px 20px;
        font-size: 1.2em;
        cursor: pointer;
        border-radius: 5px;
    }

    .order-continue-button button:hover {
        background-color: var(--laurel-green);
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
    // Handle error
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
