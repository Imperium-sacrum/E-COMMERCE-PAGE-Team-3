<?php

session_start();

require_once '../vendor/autoload.php';
require_once 'secrets.php';
require_once '../db_components/db_connect.php'; 

\Stripe\Stripe::setApiKey($stripeSecretKey);

try {
    // Retrieve the user_id from the session
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User is not logged in.');
    }

    $user_id = $_SESSION['user_id'];

    // Assuming this is the real session ID from Stripe checkout
    $session_id = $_GET['session_id'];
    $checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
    $customer = \Stripe\Customer::retrieve($checkout_session->customer);

    $paymentIntent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);

    // Extract relevant information
    $paymentStatus = $paymentIntent->status;
    $paymentAmount = $paymentIntent->amount_received;
    $paymentCurrency = $paymentIntent->currency;
    $paymentMethod = $paymentIntent->payment_method;
    $customerEmail = $customer->email;

    // Insert order into database using the user_id
    $query = "INSERT INTO orders (user_id, session_id, customer_email, amount, currency, payment_status, payment_method)
              VALUES ('$user_id', '$session_id', '$customerEmail', '$paymentAmount', '$paymentCurrency', '$paymentStatus', '$paymentMethod')";

    mysqli_query($connect, $query);

    echo "<h1>Thank you for your order!</h1>";

} catch (Exception $e) {
    // Handle error
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>
