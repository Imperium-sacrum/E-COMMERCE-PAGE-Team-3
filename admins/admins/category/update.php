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

// // Initialize variables
// $name = $percentage = $start = $end = $msgError = "";
// $alarm = "";

// Get discount_id from URL
$id = $_GET["id"];

// query
$sql = "SELECT * FROM `product_categories` WHERE category_id = {$id}";
// run the query
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);


// Handle form submission
if (isset($_POST["update"])) {
    $name = cleanInput($_POST["name"]);


    // Validation
    if (empty($name)) {
        $error = true;
        $msgError = "Required fields cannot be empty";
    } else {

        $update_sql = " UPDATE `product_categories` SET `category_name`='{$name}' WHERE category_id = {$id}";
        // run the query
        $update_result = mysqli_query($connect, $update_sql);
        if ($update_result) {
            header("refresh: 3; url=../dashboard.php");
        }
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Discount</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container min-vh-100">
        <?php
        if (isset($_POST["update"])) {
            if ($update_result) {
                echo "<div class='alert alert-success' role='alert'>
        Category has been updated! .
        </div";
            } else {
                echo "<div class='alert alert-danger' role='alert'>
        Somthing went wrong, please try again!
    </div";
            }
            // // redirect to index.php
            header("refresh: 3; url=../dashboard.php");
        } ?>

        <div class="container min-vh-100">
            <form enctype="multipart/form-data" method="POST" class="mx-auto w-50  my-5 shadow-lg p-3 mb-5 bg-body rounded">
                <h5 class="my-4 d-flex justify-content-center"> Edit the Category</h5>

                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="name" required value="<?= $row["category_name"] ?>">
                </div>

                <input type="submit" class="btn btn-dark mb-5" value="Update" name="update">
            </form>
        </div>
</body>

</html>

</div>
</body>

</html>