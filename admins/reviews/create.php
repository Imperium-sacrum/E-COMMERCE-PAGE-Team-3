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

$error = false;

$product_id = $user_id = $rating = $msgError = "";

if (isset($_POST["create"])) {
    $product_id = cleanInput($_POST["product_id"]);
    $user_id = cleanInput($_POST["user_id"]);
    $rating = cleanInput($_POST["rating"]);

    if (empty($product_id) || empty($user_id) || empty($rating)) {
        $error = true;
        $msgError = "All fields are required.";
    }
    if (!$error) {
        $sql = "INSERT INTO `reviews` (`product_id`, `user_id`, `rating`, `created_at`, `updated_at`) 
                VALUES ('{$product_id}', '{$user_id}', '{$rating}', NOW(), NOW())";

        $result = mysqli_query($connect, $sql);

        if ($result) {
            $alarm = "<div class='alert alert-success' role='alert'>
                        Review successfully created.
                      </div>";
            $product_id = $user_id = $rating = "";
        } else {
            $alarm = "<div class='alert alert-danger' role='alert'>
                        Something went wrong, please try again!
                      </div>";
        }
        header("refresh: 3; url=../dashboard.html");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    if (isset($_POST["create"])) {
        echo $alarm;
    }
    ?>
    <main>
        <div class="container min-vh-100">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="mx-auto w-50 my-5 shadow-lg p-3 mb-5 bg-body rounded">
                <h5 class="my-4 d-flex justify-content-center">Add a New Review</h5>

                <div class="mb-3">
                    <input type="text" class="form-control" id="product_id" name="product_id" placeholder="Product ID" value="<?php echo $product_id; ?>">
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" id="user_id" name="user_id" placeholder="User ID" value="<?php echo $user_id; ?>">
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" id="rating" name="rating" placeholder="Rating" value="<?php echo $rating; ?>">
                </div>

                <input type="submit" class="btn btn-dark mb-5" value="Create" name="create">
            </form>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>