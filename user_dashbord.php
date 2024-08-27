<?php
// ob_start();
// session_start();
// if (!isset($_SESSION["username"]) && !isset($_SESSION["admin"])) {
//     header("Location: session/login.php");
//     exit();
// }
// if (isset($_SESSION["admin"])) {
//     header("Location: admins/dashboard");
//     exit();
// }
require_once "db_components/db_connect.php";
$id = $_GET["id"];

// Fetch the reviews for the product

$sql = "SELECT users.user_id as User_ID, users.username, users.email , shopping_cart.product_id, shopping_cart.quantity FROM users JOIN shopping_cart ON shopping_cart.user_id = users.user_id where shopping_cart.user_id = $id";

// run the query
$result = mysqli_query($connect, $sql);
// fetch data
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
foreach ($row as  $value) {
    $productId = "{$value["product_id"]}";
}


$sql_orders = "SELECT * FROM `orders` WHERE user_id=$id";
$result_orders = mysqli_query($connect, $sql_orders);
$row_orders = mysqli_fetch_all($result_orders, MYSQLI_ASSOC);


$layout = "";
foreach ($row_orders as  $value_orders) {
    $layout .= "

  
<div class=' shadow-lg p-3 m-5 bg-body rounded' >
<div class='clearfix'>


  <div class= 'd-flex justify-content-start'>
      <dl class='w-50 m-5'>
        <dt>Name</dt>
        <dd>{$value_orders["products"]}</dd>

        <dt>Status</dt>
        <dd>{$value_orders["order_status"]}</dd>

        <dt>Ordered at</dt>
        <dd>{$value_orders["created_at"]}</dd>
    
  
   </div>
   
  

  <div class='d-flex '> 
  <a href='users/leave-reviews.php?id='{$productId}' class='btn btn-outline-secondary d-flex justify-content-center m-3 w-25'>Leave a review</a>

  
  </div>
 
    <hr>

</div>
</div>
";
}





?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/details.css">
    <link rel="stylesheet" href="cards.css.map">
</head>

<body>
    <!-- Navbar -->
    <?php include 'components/navbar.php'; ?>


    <?php echo $layout ?>


    <!-- Footer start -->
    <?php include 'components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"