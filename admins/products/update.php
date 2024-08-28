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

$id = $_GET["id"];

// query
$sql = "SELECT * FROM `products` WHERE product_id = {$id}";
// run the query
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);


// category table 
$sql_category = "SELECT * FROM `product_categories`";
$result_category = mysqli_query($connect, $sql_category);
$categories = mysqli_fetch_all($result_category, MYSQLI_ASSOC);
$option_category = "";
foreach ($categories as  $value) {
    if ($row["category_id"] == $value["category_id"]) {
        $option_category .= "<option value='{$value["category_id"]}' selected>{$value["category_name"]}</option>";
    } else {
        $option_category .= "<option value='{$value["category_id"]}'>{$value["category_name"]}</option>";
    }
}
// discount table 

$sql_discount = "SELECT * FROM `discounts`";
$result_discount = mysqli_query($connect, $sql_discount);
$discounts = mysqli_fetch_all($result_discount, MYSQLI_ASSOC);
$option_discount = "";
foreach ($discounts as  $value) {
    if ($row["discount_id"] == $value["discount_id"]) {
        $option_discount .= "<option value='{$value["discount_id"]}' selected>{$value["discount_name"]}</option>";
    } else {
        $option_discount .= "<option value='{$value["discount_id"]}'>{$value["discount_name"]}</option>";
    }
}
// post method
if (isset($_POST["update"])) {
    $name = cleanInput($_POST["name"]);
    $description = cleanInput($_POST["description"]);
    $price = cleanInput($_POST["price"]);
    $image =  fileUpload($_FILES["image"], "product");
    $category = cleanInput($_POST["category"]);
    $discount = cleanInput($_POST["discount"]);
    $availability = cleanInput($_POST["availability"]);

    //stripe
    $stripe = new \Stripe\StripeClient($stripeSecretKey);

    // to search for an existing price
    $priceId = $stripe->prices->retrieve($row["priceId"]);

    // to find product id
    $productId = $priceId->product;

    $oldPriceId = $priceId->id;

    $product = $stripe->products->update($productId, [
        "name" => $name,
        "description" => $description
    ]);

    if ($price != $row["price"]) {
        // to create a price
        $priceId = $stripe->prices->create([
            'unit_amount' => $price * 100,
            'currency' => 'usd',
            'product' => $product->id
        ]);


    // to deactivate a price
    $deactivated_price = $stripe->prices->update($oldPriceId, [
        'active' => false,
    ]);

    # checking if a picture has been selected in the input for the image 
    if ($_FILES["image"]["error"] == 4) {
        $update_sql = "UPDATE `products` SET `product_name`='{$name}',`description`='{$description}',`price`='{$price}',`category_id`='{$category}', priceId = '{$priceId->id}',`discount_id`='{$discount}',`availability`='{$availability}' WHERE product_id = {$id}";
    } else {
        //  delete the old picture

        if ($row["image"] != "product.jpg") {
            unlink("../images/{$row["image"]}");
        }
        $update_sql = "UPDATE `products` SET `product_name`='{$name}',`description`='{$description}',`price`='{$price}',`category_id`='{$category}', priceId = '{$priceId->id}',`discount_id`='{$discount}',`image`='$image[0]',`availability`='{$availability}' WHERE product_id = {$id}";
    }
    // run the query
    $update_result = mysqli_query($connect, $update_sql);
}
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
        // redirect 
        header("refresh: 3; url=../dashboard.html");
    } ?>



    <main>
        <div class="container min-vh-100">
            <form enctype="multipart/form-data" method="POST" class="mx-auto w-50  my-5 shadow-lg p-3 mb-5 bg-body rounded">
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
                    <select class='form-select' name="category">
                        <option value='null'>Select a category</option>
                        <?= $option_category ?>
                    </select>
                </div>
                <div class="mb-3 ">
                    <label for="availability">Availabilityt</label>
                    <?php
                    if ($row["availability"] == '1') {
                        echo '<select class="form-select" name="availability" id="availability">
                        
                        <option value="1"selected >Available</option>
                        <option value="0">Not available</option>

                    </select>';
                    } else {
                        echo ' <select class="form-select" name="availability" id="availability">
                        
                        <option value="1" >Available</option>
                        <option value="0" selected>Not available</option>

                    </select>';
                    }
                    ?>
                </div>
                <div class="mb-3 ">
                    <div class="mb-3 ">
                        <select class='form-select' name="discount">
                            <option value='null'>NO discount</option>
                            <?= $option_discount ?>
                        </select>
                    </div>

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