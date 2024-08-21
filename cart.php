<?php
session_start();

// Sample product data
$products = [
    1 => ['name' => 'Bobr', 'price' => 900, 'image' => '', 'description' => '256GB, Navy Blue'],
    2 => ['name' => 'Bobr', 'price' => 900, 'image' => '', 'description' => '256GB, Navy Blue'],
    3 => ['name' => 'Bobr', 'price' => 1199, 'image' => '', 'description' => 'Onyx Black'],
    4 => ['name' => 'Bobr', 'price' => 1799, 'image' => '', 'description' => '1TB, Graphite'],
];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        1 => ['quantity' => 2],
        2 => ['quantity' => 2],
        3 => ['quantity' => 1],
        4 => ['quantity' => 1],
    ];
}

// Handle actions: increment, decrement, delete
if (isset($_GET['action'])) {
    $productId = (int)$_GET['product_id'];

    switch ($_GET['action']) {
        case 'increment':
            $_SESSION['cart'][$productId]['quantity']++;
            break;

        case 'decrement':
            if ($_SESSION['cart'][$productId]['quantity'] > 1) {
                $_SESSION['cart'][$productId]['quantity']--;
            }
            break;

        case 'delete':
            unset($_SESSION['cart'][$productId]);
            break;
    }
    
    header('Location: cart.php');
    exit();
}

$totalPrice = 0;
foreach ($_SESSION['cart'] as $productId => $details) {
    $totalPrice += $products[$productId]['price'] * $details['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
    <div class="cart">
        <a href="index.php" class="continue-shopping"><i class="fas fa-arrow-left"></i> Continue shopping</a>
        <h2>Shopping cart</h2>
        <p>You have <?= array_sum(array_column($_SESSION['cart'], 'quantity')) ?> items in your cart</p>
        
        <?php foreach ($_SESSION['cart'] as $productId => $details): ?>
        <div class="cart-item">
            <img src="<?= $products[$productId]['image'] ?>" alt="<?= $products[$productId]['name'] ?>">
            <div class="cart-item-details">
                <h4><?= $products[$productId]['name'] ?></h4>
                <p><?= $products[$productId]['description'] ?></p>
            </div>
            <div class="cart-item-quantity">
                <a href="cart.php?action=decrement&product_id=<?= $productId ?>"><i class="fas fa-minus"></i></a>
                <?= $details['quantity'] ?>
                <a href="cart.php?action=increment&product_id=<?= $productId ?>"><i class="fas fa-plus"></i></a>
            </div>
            <div class="cart-item-price">$<?= $products[$productId]['price'] * $details['quantity'] ?></div>
            <div class="cart-item-remove"><a href="cart.php?action=delete&product_id=<?= $productId ?>"><i class="fas fa-trash"></i></a></div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="cart-summary">
        <h2>Card details</h2>
        <div class="form-group">
            <label>Card type</label>
            <div>
                <img src="/" alt="MasterCard">
                <img src="/" alt="Visa">
                <img src="/" alt="Amex">
                <img src="/" alt="PayPal">
            </div>
        </div>
        <div class="form-group">
            <label>Cardholder's Name</label>
            <input type="text" placeholder="Cardholder's Name">
        </div>
        <div class="form-group">
            <label>Card Number</label>
            <input type="text" placeholder="Card Number">
        </div>
        <div class="form-group">
            <label>Expiration</label>
            <input type="text" placeholder="MM/YY">
        </div>
        <div class="form-group">
            <label>CVV</label>
            <input type="text" placeholder="CVV">
        </div>
        <div class="total">
        <p>Subtotal: €<?= number_format($totalPrice, 2) ?></p>
            <p>Shipping: €20.00</p>
            <h3>Total(Incl. taxes): €<?= number_format($totalPrice + 20, 2) ?></h3>
        </div>
        <button class="checkout-btn">€<?= number_format($totalPrice + 20, 2) ?> CHECKOUT →</button>
    </div>
</div>

</body>
</html>
