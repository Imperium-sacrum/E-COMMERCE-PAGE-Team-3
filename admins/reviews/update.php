<?php
session_start();
if (!isset($_SESSION["username"]) && !isset($_SESSION["admin"])) {
    header("Location: ../../session/login.php");
    exit();
}
if (isset($_SESSION["username"])) {
    header("Location: ../../index.php");
    exit();
}
require_once "../../db_components/db_connect.php";
require_once "../../db_components/file_upload.php";

$review_id = $_GET["id"];

// $sql_product = "SELECT * FROM `products` WHERE product_id = {$product_id}";
// $result_product = mysqli_query($connect, $sql_product);
// $product = mysqli_fetch_assoc($result_product);


$sql_review = "SELECT * FROM `reviews` WHERE review_id = {$review_id}";
$result_review = mysqli_query($connect, $sql_review);
$review = mysqli_fetch_assoc($result_review);

// Actualizar reseña
if (isset($_POST["update_review"])) {
    $rating = cleanInput($_POST["rating"]);
    $comment = cleanInput($_POST["comment"]);
    $updated_at = date("Y-m-d H:i:s");

    $update_review_sql = "UPDATE `reviews` SET `rating`='{$rating}', `comment`='{$comment}', `updated_at`='{$updated_at}' WHERE review_id = {$review_id}";

    $update_review_result = mysqli_query($connect, $update_review_sql);

    if ($update_review_result) {
        echo "<div class='alert alert-success' role='alert'>Review has been updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Something went wrong. Please try again.</div>";
    }

    // Redirect after update
    header("refresh: 3; url=../dashboard.html");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container min-vh-100">
        <form method="POST" class="mx-auto w-50 my-5 shadow-lg p-3 mb-5 bg-body rounded">
            <h5 class="my-4 d-flex justify-content-center">Update Review</h5>

            <div class="mb-3">
                <label for="rating">Rating</label>
                <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" value="<?= $review["rating"] ?>">
            </div>

            <div class="mb-3">
                <label for="comment">Comment</label>
                <textarea class="form-control" id="comment" name="comment"><?= $review["comment"] ?></textarea>
            </div>

            <input type="submit" class="btn btn-dark mb-5" value="Update Review" name="update_review">
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>