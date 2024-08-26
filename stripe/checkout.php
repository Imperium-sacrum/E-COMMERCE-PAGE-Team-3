<?php
require_once '../vendor/autoload.php';
require_once 'secrets.php';
require_once '../db_components/db_connect.php'; 

\Stripe\Stripe::setApiKey($stripeSecretKey);

$YOUR_DOMAIN = 'http://localhost:4242';

// Check if product_ids and quantities are set
if (!isset($_POST['product_ids']) || !isset($_POST['quantities'])) {
    die("Product IDs or Quantities were not provided.");
}

// Retrieve product IDs and quantities from the form submission
$productIds = $_POST['product_ids'];
$quantities = $_POST['quantities'];

$line_items = [];
foreach ($productIds as $index => $productId) {
    $quantity = $quantities[$index];
    
    // Retrieve product details from the database
    $result = mysqli_query($connect, "SELECT * FROM products WHERE product_id = $productId");
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        $line_items[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => $product['product_name'],
                    'description' => $product['description'],
                ],
                'unit_amount' => $product['price'] * 100, // Amount in cents
            ],
            'quantity' => $quantity,
        ];
    }
}

// Ensure we have at least one line item
if (empty($line_items)) {
    die("No valid line items found.");
}

// Create the Stripe Checkout session
$checkout_session = \Stripe\Checkout\Session::create([
  'line_items' => $line_items,
  'mode' => 'payment',
  'success_url' => $YOUR_DOMAIN . '/stripe/success.php?session_id={CHECKOUT_SESSION_ID}',
  'cancel_url' => $YOUR_DOMAIN . '/stripe/cancel.html',
]);

// Redirect to Stripe Checkout
header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);
exit();
?>
