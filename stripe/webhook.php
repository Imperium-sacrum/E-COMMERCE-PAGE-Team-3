<?php
require_once '../vendor/autoload.php';
require_once 'secrets.php';
require_once '../db_components/db_connect.php'; 

\Stripe\Stripe::setApiKey($stripeSecretKey);

// You can find your endpoint's secret in your webhook settings
$endpoint_secret = 'whsec_...';

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

try {
    $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
} catch(\UnexpectedValueException $e) {
    // Invalid payload
    http_response_code(400);
    exit();
} catch(\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    http_response_code(400);
    exit();
}

// Handle the checkout.session.completed event
if ($event->type == 'checkout.session.completed') {
    $session = $event->data->object;
    
    // Fulfill the purchase...
    $paymentIntentId = $session->payment_intent;

    // Retrieve the payment intent to get customer info
    $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);
    $customer = \Stripe\Customer::retrieve($session->customer);

    // Insert into database
    $query = "INSERT INTO orders (session_id, customer_email, amount, currency, payment_status, payment_method)
              VALUES ('$session->id', '$customer->email', '$session->amount_total', '$session->currency', 'paid', '$paymentIntent->payment_method')";

    mysqli_query($connect, $query);
}

http_response_code(200);
