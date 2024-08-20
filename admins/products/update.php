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
require_once "../../db_components/file_upload.php";
$id = $_GET["id"];

// query
$sql = "SELECT * FROM `products` WHERE product_id = {$id}";
// run the query
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

// post method
if (isset($_POST["create"])) {
    $name = cleanInput($_POST["name"]);
    $description = cleanInput($_POST["description"]);
    $price = cleanInput($_POST["price"]);
    $image =  fileUpload($_FILES["image"], "product");
    $category = cleanInput($_POST["category"]);
    $discount = cleanInput($_POST["discount"]);
    # checking if a picture has been selected in the input for the image 
    if ($_FILES["image"]["error"] == 4) {
        $update_sql = "UPDATE `products` SET `product_name`='{$name}',`description`='{$description}',`price`='{$price}',`category_id`='{$category}',`discount_id`='{$discount}' WHERE product_id = {$id}";
    } else {
        //  delete the old picture

        if ($row["image"] != "product.jpg") {
            unlink("../images/{$row["image"]}");
        }
        $update_sql = "UPDATE `products` SET `product_name`='{$name}',`description`='{$description}',`price`='{$price}',`category_id`='{$category}',`discount_id`='{$discount}',`image`='$image[0]' WHERE product_id = {$id}";
    }
    // run the query
    $update_result = mysqli_query($connect, $update_sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <?php
    if (isset($_POST["update"])) {
        if ($update_result) {
            echo "<div class='alert alert-success' role='alert'>
        Product has been updated! {$image[1]}.
        </div";
        } else {
            echo "<div class='alert alert-danger' role='alert'>
        Somthing went wrong, please try again!
    </div";
        }
        // // redirect to index.php
        // header("refresh: 3; url=index.php");
    } ?>

    <main>
        <div class="container min-vh-100">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" enctype="multipart/form-data" method="POST" class="mx-auto w-50  my-5 shadow-lg p-3 mb-5 bg-body rounded">
                <h5 class="my-4 d-flex justify-content-center"> Update </h5>

                <div class="mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" aria-describedby="name" name="name" value="<?= $row["product_name"] ?>">
                </div>

                <div class="mb-3">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" id="price" aria-describedby="price" name="price" value="<?= $row["price"] ?>">
                </div>



                <div class="mb-3">
                    <label for="image">Picture</label>
                    <input type="file" class="form-control" id="image" aria-describedby="image" name="image">
                </div>
                <div class="mb-3 ">
                    <label for="category">Category</label>
                    <?php
                    if ($row["category_id"] == '1') {
                        echo '<select class="form-select" name="category" id="category">
                        
                        <option value="1" selected >test 1</option>
                        <option value="2">test 2</option>

                    </select>';
                    } else {
                        echo ' <select class="form-select" name="category" id="category">
                        
                        <option value="1" >test 1</option>
                        <option value="2" selected>test 2</option>

                    </select>';
                    }
                    ?>
                </div>
                <div class="mb-3 ">
                    <label for="discount">Discount</label>
                    <?php
                    if ($row["discount_id"] == '1') {
                        echo '<select class="form-select" name="discount" id="discount">
                        
                        <option value="1"selected >sale 1</option>
                        <option value="2">sale 2</option>

                    </select>';
                    } else {
                        echo ' <select class="form-select" name="discount" id="discount">
                        
                        <option value="1" >sale 1</option>
                        <option value="2" selected>sale 2</option>

                    </select>';
                    }
                    ?>
                </div>
                <div class="mb-3"> <textarea class="form-control" id="exampleFormControlTextarea1" rows="" name="description"><?= $row["description"] ?></textarea>
                </div>

                <input type="submit" class="btn btn-dark mb-5" value="Update" name="update">
            </form>
        </div>
    </main>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>