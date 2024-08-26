<?php
session_start();

// Redirect to login if the user is not logged in
// if (!isset($_SESSION["user_id"])) {
//     header("Location: ../login.php");
//     exit();
// }

require_once "../db_components/db_connect.php";

$id = $_GET["id"]; // Product ID from the URL

// Handle the form submission via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id']; // Get the logged-in user ID from session
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');

    // Insert the review into the database
    $sqlReview = "INSERT INTO `reviews`(`product_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`) 
                  VALUES ('$product_id', '$user_id', '$rating', '$comment', '$created_at', '$updated_at')";
    $resultReview = mysqli_query($connect, $sqlReview);

    if ($resultReview) {
        echo "<div class='alert alert-success' role='alert'>Review sent successfully.</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Something went wrong, please try again!</div>";
    }
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <!-- Alert area for showing success/error messages -->
        <div id="alert-area"></div>

        <!-- Review form -->
        <form id="review-form" class="mx-auto w-50 my-5 shadow-lg p-3 mb-5 bg-body rounded">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($id); ?>"> <!-- Product ID -->
            <div class="mb-3">
                <label for="rating">Rating:</label>
                <input class="form-control" type="number" name="rating" min="1" max="5" required>
            </div>
            <div class="mb-3">
                <label for="comment">Comment:</label>
                <textarea class="form-control" name="comment" required></textarea>
            </div>
            <input type="submit" class="btn btn-outline-secondary mb-5" value="Send">
        </form>
    </div>

    <script>
        // AJAX form submission
        document.getElementById('review-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting the default way

            let formData = new FormData(this);

            fetch('leave-reviews.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text()) // Use text() to get HTML response
                .then(html => {
                    let alertArea = document.getElementById('alert-area');
                    alertArea.innerHTML = html; // Display the alert message
                    document.getElementById('review-form').reset(); // Optionally clear the form
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>