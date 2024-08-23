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


$name = $percentage = $start = $end = $msgError = "";
if (isset($_POST["create"])) {
    $name = cleanInput($_POST["name"]);
    $percentage = cleanInput($_POST["percentage"]);
    $start = cleanInput($_POST["start"]);
    $end = cleanInput($_POST["end"]);






    // validation:


    if (empty($name) & empty($percentage) & empty($start) & empty($end)) {
        $error = true;
        $msgError = "Required field";
    }
    if (!$error) {


        // query
        $sql = "INSERT INTO `discounts`( `discount_name`, `discount_percentage`, `start_date`, `end_date`) VALUES ('{$name}','{$percentage}','{$start}','{$end}')";

        // run the query
        $result = mysqli_query($connect, $sql);
        // show result 
        if ($result) {
            $alarm =  "<div class='alert alert-success' role='alert'>
                  Discount has been created. 
            </div";
            $name = $image = $description = $price = $category = $discount = "";
        } else {
            $alarm = "<div class='alert alert-danger' role='alert'>
               Something went wrong, please try again!  
            /div";
        }
        // // redirect 
        header("refresh: 3; url=../dashboard.html");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Discount</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php
    if (isset($_POST["create"])) {
        echo $alarm;
    }

    ?>
    <div class="container min-vh-100">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" enctype="multipart/form-data" method="POST" class="mx-auto w-50  my-5 shadow-lg p-3 mb-5 bg-body rounded">
            <h5 class="my-4 d-flex justify-content-center"> Add a new Discount</h5>

            <div class="mb-3">
                <label for="discount_name" class="form-label">Discount Name</label>
                <input type="text" class="form-control" id="discount_name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="discount_percentage" class="form-label">Discount Percentage</label>
                <input type="number" step="0.01" class="form-control" id="discount_percentage" name="percentage">
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="datetime-local" class="form-control" id="start_date" name="start" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date </label>
                <input type="datetime-local" class="form-control" id="end_date" name="end" required>
            </div>
            <input type="submit" class="btn btn-dark mb-5" value="Create" name="create">
        </form>
    </div>
</body>

</html>