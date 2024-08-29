<?php

session_start();


require_once "../db_components/db_connect.php";

// if (!isset($_GET["id"])) {
//     die("Error: Product ID is not specified.");
// }


$id = $_GET["id"]; // Product id from URL 


// Fetch reviews for the product

$reviews = mysqli_query($connect, "SELECT * FROM reviews WHERE product_id = '$id'");

?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Product Reviews</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container">

        <!-- Display reviews -->

        <div class="reviews-section my-5">

            <h3>Reviews for Product ID: <?php echo $id; ?></h3>

            <?php if (mysqli_num_rows($reviews) > 0): ?>

                <?php while ($review = mysqli_fetch_assoc($reviews)): ?>

                    <div class="card mb-3">

                        <div class="card-body">

                            <h5 class="card-title">Rating: <?php echo $review['rating']; ?>/5</h5>

                            <p class="card-text"><?php echo $review['comment']; ?></p>

                            <p class="card-text"><small class="text-muted">Posted on: <?php echo $review['created_at']; ?></small></p>

                        </div>

                    </div>

                <?php endwhile; ?>

            <?php else: ?>

                <p>No reviews yet for this product.</p>

            <?php endif; ?>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>