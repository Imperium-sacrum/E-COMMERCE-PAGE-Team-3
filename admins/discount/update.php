<?php
// session_start();
// if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
//     header("Location: ../login.php");
//     exit();
// }
// if (isset($_SESSION["user"])) {
//     header("Location: ../homepage.php");
//     exit();
// }

require_once "../../db_components/db_connect.php";
$error = false;

// // Initialize variables
// $name = $percentage = $start = $end = $msgError = "";
// $alarm = "";

// Get discount_id from URL
$id = $_GET["id"];

// query
$sql = "SELECT * FROM `discounts` WHERE discount_id = {$id}";
// run the query
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);


// Handle form submission
if (isset($_POST["update"])) {
    $name = cleanInput($_POST["name"]);
    $percentage = cleanInput($_POST["percentage"]);
    $start = cleanInput($_POST["start"]);
    $end = cleanInput($_POST["end"]);

    // Validation
    if (empty($name) || empty($percentage) || empty($start)) {
        $error = true;
        $msgError = "Required fields cannot be empty";
    } else {

        $update_sql = " UPDATE `discounts` SET `discount_name`='$name',`discount_percentage`='$percentage',`start_date`='$start',`end_date`='$end' WHERE discount_id = {$id}";
        // run the query
        $update_result = mysqli_query($connect, $update_sql);
        if ($update_result) {
            header("refresh: 3; url=../dashboard.html");
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
        Discount has been updated! .
        </div";
            } else {
                echo "<div class='alert alert-danger' role='alert'>
        Somthing went wrong, please try again!
    </div";
            }
            // // redirect 
            header("refresh: 3; url=../dashboard.html");
        } ?>

        <div class="container min-vh-100">
            <form enctype="multipart/form-data" method="POST" class="mx-auto w-50  my-5 shadow-lg p-3 mb-5 bg-body rounded">
                <h5 class="my-4 d-flex justify-content-center"> Edit the Discount</h5>

                <div class="mb-3">
                    <label for="discount_name" class="form-label">Discount Name</label>
                    <input type="text" class="form-control" id="discount_name" name="name" required value="<?= $row["discount_name"] ?>">
                </div>
                <div class="mb-3">
                    <label for="discount_percentage" class="form-label">Discount Percentage</label>
                    <input type="number" step="0.01" class="form-control" id="discount_percentage" name="percentage" required value="<?= $row["discount_percentage"] ?>">
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="datetime-local" class="form-control" id="start_date" name="start" required value="<?= $row["start_date"] ?>">
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date </label>
                    <input type="datetime-local" class="form-control" id="end_date" name="end" required value="<?= $row["end_date"] ?>">
                </div>
                <input type="submit" class="btn btn-dark mb-5" value="Update" name="update">
            </form>
        </div>
</body>

</html>

</div>
</body>

</html>