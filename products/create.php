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
require_once "../db_components/db_connect.php";
require_once "../db_components/file_upload.php";
$error = false;

$name = $image = $description = $price = $category = $discount = $msgError = "";
if (isset($_POST["create"])) {
    $name = cleanInput($_POST["name"]);
    $description = cleanInput($_POST["description"]);
    $price = cleanInput($_POST["price"]);
    $image =  fileUpload($_FILES["image"], "product");
    $category = cleanInput($_POST["category"]);
    $discount = cleanInput($_POST["discount"]);





    // validation:


    if (empty($name) & empty($price) & empty($description) & empty($image) & empty($category) & empty($discount)) {
        $error = true;
        $msgError = "Required field";
    }
    if (!$error) {


        // query
        $sql = "INSERT INTO `products`( `product_name`, `description`, `price`, `category_id`, `discount_id`, `image`) VALUES ('{$name}','{$description}','{$price}','{$category}','{$discount}','{$image[0]}')";

        // run the query
        $result = mysqli_query($connect, $sql);
        // show result 
        if ($result) {
            $alarm =  "<div class='alert alert-success' role='alert'>
                  Product successfully created. 
            </div";
            $name = $image = $description = $price = $category = $discount = "";
        } else {
            $alarm = "<div class='alert alert-danger' role='alert'>
               Something went wrong, please try again!  
            /div";
        }
        // // redirect to index.php
        // header("refresh: 3; url=index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>

    <?php
    if (isset($_POST["create"])) {
        echo $alarm;
    }

    ?>

    <main>
        <div class="container min-vh-100">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" enctype="multipart/form-data" method="POST" class="mx-auto w-50  my-5 shadow-lg p-3 mb-5 bg-body rounded">
                <h5 class="my-4 d-flex justify-content-center"> Add a new product</h5>

                <div class="mb-3">
                    <input type="text" class="form-control" id="name" aria-describedby="name" name="name" placeholder="Name">
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" id="price" aria-describedby="price" name="price" placeholder="Price">
                </div>



                <div class="mb-3">
                    <input type="file" class="form-control" id="image" aria-describedby="image" name="image" placeholder="Image">
                </div>
                <div class="mb-3 ">
                    <select class='form-select' name="category">
                        <option value="" selected>---Select Category---</option>
                        <option value="1">test 1</option>
                        <option value="2">test 2</option>

                    </select>
                </div>
                <div class="mb-3 ">
                    <select class='form-select' name="discount">
                        <option value="" selected>---Select Discount---</option>
                        <option value="1">sale 1</option>
                        <option value="2">sale 2</option>

                    </select>
                </div>
                <div class="mb-3"> <textarea class="form-control" id="exampleFormControlTextarea1" rows="" name="description" placeholder="Description"></textarea>
                </div>

                <input type="submit" class="btn btn-dark mb-5" value="Create" name="create">
            </form>
        </div>
    </main>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>