<?php
session_start();

// Redirect to login if the user is not logged in
// if (!isset($_SESSION["user_id"])) {
//     header("Location: ../login.php");
//     exit();
// }

require_once "../db_components/db_connect.php";

// Product ID from the URL
$product_id = isset($_GET["id"]) ? $_GET["id"] : '';

// Handle the form submission via AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];  // Correct the variable name here
    $user_id = $_SESSION['username']; // Make sure this is the correct key, you might mean $_SESSION['user_id'] if using a user ID instead of a username
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];


    // Correctly build the SQL query
    $sqlReview = "INSERT INTO `reviews`(`product_id`, `user_id`, `rating`, `comment`) 
                  VALUES ('$product_id', '$user_id', '$rating', '$comment')";


    $resultReview = mysqli_query($connect, $sqlReview);

    if ($resultReview) {
        echo "<div class='alert alert-success' role='alert'>Review sent successfully.</div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>Something went wrong, please try again!</div>";
    }
    // header("refresh: 3; url= view-reviews.php");
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
    <link rel="stylesheet" href="/styles/style.css">

</head>

<body>
    <div class="reglog">
        <div id="alert-area"></div>
        <form id="review-form" method="POST" class="mx-auto">
            <h1 class="mb-3">Submit Your Review <img style="width: 35px;" src="../images/reviews.png" alt=""></h1>

            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">

            <div class="mb-3 input-box">
                <input class="form-control" type="number" name="rating" min="1" max="5" placeholder="Rating (1-5)" required>
            </div>

            <div class="mb-3 input-box">
                <textarea class="form-control" name="comment" placeholder="Your Comment" required></textarea>
            </div>

            <div class="mb-3 input-box">
                <input type="submit" class="btn btn-signup-a" value="Submit Review">
            </div>
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