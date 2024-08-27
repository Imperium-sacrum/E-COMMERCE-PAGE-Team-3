<?php
session_start();
require 'db_components/db_connect.php'; 

$sql = "SELECT p.product_id AS id, p.product_name AS name, p.price, d.discount_percentage AS discount, p.image AS icon, p.description
        FROM products p
        LEFT JOIN discounts d ON p.discount_id = d.discount_id";
$result = mysqli_query($connect, $sql);

$products = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[$row['id']] = [
            'name' => $row['name'],
            'price' => $row['price'],
            'discount' => $row['discount'] ?? 0, 
            'icon' => $row['icon'], 
            'description' => $row['description']
        ];
    }
}

$taxRate = 0.1;

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [
        3 => ['quantity' => 2],
        4 => ['quantity' => 2],
        5 => ['quantity' => 1],
        6 => ['quantity' => 1],
    ];
}

// Handle actions: increment, decrement, delete, update
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

        case 'update':
            $newQuantity = (int)$_GET['quantity'];
            if ($newQuantity > 0) {
                $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
            } else {
                unset($_SESSION['cart'][$productId]);
            }
            break;
    }
    
    header('Location: cart.php');
    exit();
}

$totalPrice = 0;
$discountedTotalPrice = 0;
$totalDiscount = 0;

foreach ($_SESSION['cart'] as $productId => $details) {
    if (isset($products[$productId])) {
        $originalPrice = $products[$productId]['price'] * $details['quantity'];
        $discountAmount = $products[$productId]['discount'] * $details['quantity'];
        $finalPrice = $originalPrice - $discountAmount;

        $totalPrice += $originalPrice;
        $discountedTotalPrice += $finalPrice;
        $totalDiscount += $discountAmount;
    }
}

$totalTax = $discountedTotalPrice * $taxRate;
$finalTotal = $discountedTotalPrice + $totalTax + 20; 
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
                                    <th scope="col" width="60" class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['cart'] as $productId => $details): ?>
                                <?php if (isset($products[$productId])): ?>
                                <tr>
                                    <td>
                                        <figure class="itemside align-items-center">
                                            <div class="aside">
                                                <img src="images/<?= $products[$productId]['icon'] ?>" class="img-sm">
                                            </div>
                                            <figcaption class="info">
                                                <a href="#" class="title text-light" data-abc="true"><?= $products[$productId]['name'] ?></a>
                                                <p class="text-muted small"><?= $products[$productId]['description'] ?></p>
                                            </figcaption>
                                        </figure>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control select-quantity" value="<?= $details['quantity'] ?>" min="1" onchange="updateQuantity(this, <?= $productId ?>)">
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
                                    <td class="text-right trash-icon">
                                        <a href="cart.php?action=delete&product_id=<?= $productId ?>" class="btn btn-light btn-round"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </aside>
<aside class="col-lg-4">
    <div class="card-details">
        <h3>Order Summary</h3>
        <hr>
        <div class="total">
            <p>Subtotal: €<?= number_format($discountedTotalPrice, 2) ?></p>
            <p>Discount: -€<?= number_format($totalDiscount, 2) ?></p>
            <p>Tax (10%): €<?= number_format($totalTax, 2) ?></p>
            <p>Shipping: €20.00</p>
            <h3>Total (Incl. taxes): €<?= number_format($finalTotal, 2) ?></h3>
        </div>
        <form action="stripe/checkout.php" method="POST">
            <?php foreach ($_SESSION['cart'] as $productId => $details): ?>
                <input type="hidden" name="product_ids[]" value="<?= $productId ?>">
                <input type="hidden" name="quantities[]" value="<?= $details['quantity'] ?>">
            <?php endforeach; ?>
            <button type="submit" class="checkout-btn">Proceed to Checkout</button>
        </form>
    </div>
</aside>


    </div>
</div>

<!-- JavaScript to handle quantity changes -->
<script>
function updateQuantity(element, productId) {
    var quantity = element.value;
    if (quantity < 1) {
        quantity = 1;
        element.value = 1;
    }
    window.location.href = 'cart.php?action=update&product_id=' + productId + '&quantity=' + quantity;
}
</script>

</body>
</html>
