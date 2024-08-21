<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ob_start();
// session_start();
// if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
//     header("Location: login.php");
//     exit();
// }

require_once "db_components/db_connect.php";



$condition = isset($_GET['category']) ? $_GET['category'] : "";
$sqlCN = "SELECT * FROM product_categories";
if (!empty($condition)) {
  $sqlCN .= " WHERE category_name ='{$_GET['category']}'";
  $resultCN = mysqli_query($connect, $sqlCN);
  $row = mysqli_fetch_assoc($resultCN);
}

if (empty($condition)) {
  $sqlcategory = "SELECT * FROM `products`";
} else {
  $sqlcategory = "SELECT * FROM `products` WHERE category_id= " . $row["category_id"];
}







$result = mysqli_query($connect, $sqlcategory);
$cards = "";

if (mysqli_num_rows($result) == 0) {

  $cards = "<p>No products found</p>";
} else {
  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
  foreach ($rows as $key => $row) {
    $availabilityStatus = $row["availability"] == 1 ? "Available" : "Not Available";
    $cards .= "<div>
     <div class='product-card'>
      <div class='card-image'>
       <img src='images/{$row["image"]}'>
      </div>
      <div class='card-info'>
        <h2 class='product-name'>{$row["product_name"]}</h2>
        <p class='product-price'>€ {$row["price"]}</p>
         <p class='product-availability'>Status: {$availabilityStatus}</p>
        <div class='card-info d-flex'>
        <button><a href='order.php?index={$row["product_id"]}'>Add to Cart</a></button>
    <button><a href='details.php?index={$row["product_id"]}'>Details</a></button>
      </div>
      </div>
    </div>
      
</div>

       
           
         ";
  }
}



mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="styles/cards.css">
  <link rel="stylesheet" href="styles/style.css">
</head>
<a href=""></a>


<body id=cards-body>
  <?php include 'components/navbar.php';
  ?>
  <h1 class="mt-5 text-dark">PRODUCTS</h1>
  <div class="categories ">
    <ul class="categ-li  d-flex flex-row text-dark justify-content-start">
      <li><a href="cards.php?category=Meat">Meat</a></li>
      <li><a href="cards.php?category=Vegetables">Vegetables</a></li>
      <li><a href="cards.php?category=Grains">Grains</a></li>
      <li><a href="cards.php?category=Other">Other</a></li>
      <li><a href="cards.php?category=">All</a></li>


    </ul>
  </div>
  <div class="section-card mt-5">
    <div class="row row-cols-lg-5 row-cols-md-3 row-cols-sm-1 row-cols-xs-1">
      <?= $cards ?>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <div class="row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-xs-1">

  </div>
</body>

</html>