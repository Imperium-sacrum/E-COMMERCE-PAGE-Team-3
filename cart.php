<?php
session_start();

// Define product data with FontAwesome icons, names, prices, and discounts
$products = [
    1 => ['name' => 'Iphone 11 pro', 'price' => 900, 'discount' => 100, 'icon' => 'fa-mobile-alt', 'description' => '256GB, Navy Blue'],
    2 => ['name' => 'Samsung galaxy Note 10', 'price' => 900, 'discount' => 50, 'icon' => 'fa-tablet-alt', 'description' => '256GB, Navy Blue'],
    3 => ['name' => 'Canon EOS M50', 'price' => 1199, 'discount' => 0, 'icon' => 'fa-camera', 'description' => 'Onyx Black'],
    4 => ['name' => 'MacBook Pro', 'price' => 1799, 'discount' => 200, 'icon' => 'fa-laptop', 'description' => '1TB, Graphite'],
];

$taxRate = 0.1; // 10% tax rate

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
            } else {
                unset($_SESSION['cart'][$productId]);
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
$discountedTotalPrice = 0;
$totalDiscount = 0;

foreach ($_SESSION['cart'] as $productId => $details) {
    $originalPrice = $products[$productId]['price'] * $details['quantity'];
    $discountAmount = $products[$productId]['discount'] * $details['quantity'];
    $finalPrice = $originalPrice - $discountAmount;

    $totalPrice += $originalPrice;
    $discountedTotalPrice += $finalPrice;
    $totalDiscount += $discountAmount;
}

$totalTax = $discountedTotalPrice * $taxRate;
$finalTotal = $discountedTotalPrice + $totalTax + 20; // Add shipping (20) to the final total
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="styles/shoppingcart.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <aside class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <a href="index.php" class="btn btn-light"><i class="fas fa-arrow-left"></i> Continue shopping</a>
                    <h2 class="mt-4">Shopping cart</h2>
                    <p>You have <?= array_sum(array_column($_SESSION['cart'], 'quantity')) ?> items in your cart</p>
                    <div class="table-responsive">
                        <table class="table table-borderless table-shopping-cart">
                            <thead class="text-muted">
                                <tr class="small text-uppercase">
                                    <th scope="col">Product</th>
                                    <th scope="col" width="120">Quantity</th>
                                    <th scope="col" width="120">Price</th>
                                    <th scope="col" class="text-right d-none d-md-block" width="200"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['cart'] as $productId => $details): ?>
                                <tr>
                                    <td>
                                        <figure class="itemside align-items-center">
                                            <div class="aside"><i class="fas <?= $products[$productId]['icon'] ?> icon-sm"></i></div>
                                            <figcaption class="info"> <a href="#" class="title text-light" data-abc="true"><?= $products[$productId]['name'] ?></a>
                                                <p class="text-muted small"><?= $products[$productId]['description'] ?></p>
                                            </figcaption>
                                        </figure>
                                    </td>
                                    <td>
                                        <select class="form-control" onchange="location = this.value;">
                                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                                <option value="cart.php?action=<?= $i > $details['quantity'] ? 'increment' : 'decrement' ?>&product_id=<?= $productId ?>" <?= $i == $details['quantity'] ? 'selected' : '' ?>><?= $i ?></option>
                                            <?php endfor; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="price-wrap">
                                            <var class="price">€<?= number_format($products[$productId]['price'] * $details['quantity'], 2) ?></var> 
                                            <?php if ($products[$productId]['discount'] > 0): ?>
                                                <small class="text-muted"> €<?= number_format($products[$productId]['price'] - $products[$productId]['discount'], 2) ?> each </small>
                                                <p class="discount-amount">Discount: -€<?= number_format($products[$productId]['discount'] * $details['quantity'], 2) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="text-right d-none d-md-block">
                                        <a href="cart.php?action=delete&product_id=<?= $productId ?>" class="btn btn-light btn-round"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </aside>
        <aside class="col-lg-4">
            <div class="card-details">
                <h3>Card details</h3>
                <form>
                    <div class="form-group">
                        <label>Card type</label>
                        <div>
                            <img src="images/mastercard.png" alt="MasterCard">
                            <img src="images/" alt="Visa">
                            <img src="images/americanexpress.png" alt="Amex">
                            <img src="images/paypal.png" alt="PayPal">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Cardholder's Name</label>
                        <input type="text" class="form-control" placeholder="Cardholder's Name">
                    </div>
                    <div class="form-group">
                        <label>Card Number</label>
                        <input type="text" class="form-control" placeholder="Card Number">
                    </div>
                    <div class="form-group">
                        <label>Expiration</label>
                        <input type="text" class="form-control" placeholder="MM/YY">
                    </div>
                    <div class="form-group">
                        <label>CVV</label>
                        <input type="text" class="form-control" placeholder="CVV">
                    </div>
                    <hr>
                    <div class="total">
                        <p>Subtotal: €<?= number_format($discountedTotalPrice, 2) ?></p>
                        <p>Discount: -€<?= number_format($totalDiscount, 2) ?></p>
                        <p>Tax (10%): €<?= number_format($totalTax, 2) ?></p>
                        <p>Shipping: €20.00</p>
                        <h3>Total (Incl. taxes): €<?= number_format($finalTotal, 2) ?></h3>
                    </div>
                    <button class="checkout-btn">€<?= number_format($finalTotal, 2) ?> CHECKOUT →</button>
                </form>
            </div>
        </aside>
    </div>
</div>

</body>
</html>
