<?php
session_start();

require_once "db_components/db_connect.php";

$id = $_SESSION["username"];

// Fetch orders for the logged-in user
$sql_orders = "SELECT * FROM `orders` WHERE user_id=$id";
$result_orders = mysqli_query($connect, $sql_orders);
$row_orders = mysqli_fetch_all($result_orders, MYSQLI_ASSOC);

$productIds = [];
foreach ($row_orders as $order) {
    $orderProducts = json_decode($order["products"], true);
    foreach ($orderProducts as $product) {
        $productIds[] = $product[0]; // Assuming $product[0] is the product_id
    }
}

// Prepare condition for SQL query
$condition = implode(" OR product_id = ", $productIds);
$sqlproducts = "SELECT * FROM products WHERE product_id = $condition";

$resultProducts = mysqli_query($connect, $sqlproducts);
$productsInfo = mysqli_fetch_all($resultProducts, MYSQLI_ASSOC);

$layout = "";
foreach ($productsInfo as $product) {
    $layout .= "
    <div class='shadow-lg p-3 m-5 bg-body rounded'>
        <div class='clearfix'>
            <div class='d-flex justify-content-start'>
                <dl class='w-50 m-5'>
                    <dt>Name</dt>
                    <dd>{$product["product_name"]}</dd>
                    <dt>Price</dt>
                    <dd>{$product["price"]}</dd>
                </dl>
            </div>
            <div class='d-flex'>
                <a href='users/leave-reviews.php?id={$product["product_id"]}' class='btn btn-outline-secondary d-flex justify-content-center m-3 w-25'>Leave a review</a>
            </div>
            <hr>
        </div>
    </div>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/details.css">
    <link rel="stylesheet" href="cards.css.map">
    <link rel="stylesheet" href="styles/orders.css">
    
</head>

<body>
    <!-- Navbar -->

    <!-- Back to Home Button -->
    <div class="container mt-4">
        <a href="index.php" class="btn btn-primary">Back to Home</a>
    </div>

    <?php echo $layout ?>


    <!-- Footer start -->
    <?php include 'components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
