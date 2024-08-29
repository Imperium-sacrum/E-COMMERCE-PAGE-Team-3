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


$name =  $msgError = "";
if (isset($_POST["create"])) {
    $name = cleanInput($_POST["name"]);


    // validation:


    if (empty($name)) {
        $error = true;
        $msgError = "Required field";
    }
    if (!$error) {


        // query
        $sql = "INSERT INTO `product_categories`(`category_name`) VALUES ('{$name}')";

        // run the query
        $result = mysqli_query($connect, $sql);
        // show result 
        if ($result) {
            $alarm =  "<div class='alert alert-success' role='alert'>
                  Category has been created. 
            </div";
            $name =  "";
        } else {
            $alarm = "<div class='alert alert-danger' role='alert'>
               Something went wrong, please try again!  
            /div";
        }
        // // redirect 
        header("refresh: 3; url=../dashboard.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Category</title>
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
            <h5 class="my-4 d-flex justify-content-center"> Add a new Category</h5>

            <div class="mb-3">
                <label for="discount_name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="discount_name" name="name" required>
            </div>

            <input type="submit" class="btn btn-dark mb-5" value="Create" name="create">
        </form>
    </div>
</body>

</html>