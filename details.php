<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once "db_components/db_connect.php";

// Check if product_id is passed
if (isset($_GET['product_id'])) {
    // Clean and assign the product_id
    $product_id = (int)$_GET['product_id']; // Ensure product_id is treated as an integer to prevent SQL injection

    // Prepare and execute the query to fetch product details
    $stmt = $connect->prepare('SELECT * FROM products WHERE product_id = ?');
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if product is found
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "<div class='alert alert-danger' role='alert'>Product not found.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger' role='alert'>No product ID provided.</div>";
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['product_name']); ?> - Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Product Image -->
                <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="img-fluid img-thumbnail">
            </div>
            <div class="col-md-6">
                <!-- Product Details -->
                <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <h3>Price: €<?php echo htmlspecialchars(number_format($product['price'], 2)); ?></h3>
                <p>Category ID: <?php echo htmlspecialchars($product['category_id']); ?></p>
                <p>Discount ID: <?php echo htmlspecialchars($product['discount_id']); ?></p>
                <p>Availability: <?php echo $product['availability'] == 1 ? "Available" : "Not Available"; ?></p>

                <!-- Add to Cart Button -->
                <a href="order.php?add=<?php echo htmlspecialchars($product['product_id']); ?>" class="btn btn-primary btn-lg mt-3">Add to Cart</a>
            </div>
        </div>

        <!-- Additional Information Section -->
        <div class="row mt-5">
            <div class="col-12">
                <h5>Product ID: <?php echo htmlspecialchars($product['product_id']); ?></h5>
                <h5>Category ID: <?php echo htmlspecialchars($product['category_id']); ?></h5>
                <h5>Discount ID: <?php echo htmlspecialchars($product['discount_id']); ?></h5>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>