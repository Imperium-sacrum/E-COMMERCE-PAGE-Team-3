<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();
session_start();
if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
    header("Location: login.php");
    exit();
}

require_once "../db_components/db_connect.php";

$categorySql = "SELECT * FROM `product_categories`";
$categoryResult = mysqli_query($connect, $categorySql);
$category = "";
$category = mysqli_fetch_all($categoryResult, MYSQLI_ASSOC);


$sql = "SELECT * FROM `products`";
$result = mysqli_query($connect, $sql);
$cards = "";

if (mysqli_num_rows($result) == 0) {
    $cards = "<p>No products found</p>";
} else {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    foreach ($rows as $key => $row) {
        $cards .= "<div>
       <div class='card my-3'>
  <nav>
    <a href='../index.php'><svg class='arrow' version='1.1' viewBox='0 0 512 512' width='512px' xml:space='preserve' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><polygon points='352,115.4 331.3,96 160,256 331.3,416 352,396.7 201.5,256 ' stroke='#727272'/></svg></a>
    Back to the products
    <svg class='heart' version='1.1' viewBox='0 0 512 512' width='512px' xml:space='preserve' stroke='#727272' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'><path d='M340.8,98.4c50.7,0,91.9,41.3,91.9,92.3c0,26.2-10.9,49.8-28.3,66.6L256,407.1L105,254.6c-15.8-16.6-25.6-39.1-25.6-63.9  c0-51,41.1-92.3,91.9-92.3c38.2,0,70.9,23.4,84.8,56.8C269.8,121.9,302.6,98.4,340.8,98.4 M340.8,83C307,83,276,98.8,256,124.8  c-20-26-51-41.8-84.8-41.8C112.1,83,64,131.3,64,190.7c0,27.9,10.6,54.4,29.9,74.6L245.1,418l10.9,11l10.9-11l148.3-149.8  c21-20.3,32.8-47.9,32.8-77.5C448,131.3,399.9,83,340.8,83L340.8,83z' stroke='#727272'/></svg>
  </nav>
  <div class='d-flex'>
  <div class='photo'>
    <img src='../images/{$row["image"]}'>
  </div>

  <div class='description'>
    <h2>{$row["product_name"]}</h2>
    <h4></h4>
    <h1>€ {$row["price"]}</h1>
    <p>{$row["description"]}</p>
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
    <link rel="stylesheet" href="../styles/cards.css">
    <link rel="stylesheet" href="../styles/style.css">
</head>
<a href=""></a>

<body id=cards-body>
    <?php include '../components/navbar.php';
    ?>

    <div class="section-card container">
        <div class="row row-cols-lg-2 row-cols-md-2 row-cols-sm-1 row-cols-xs-1">
            <?= $cards ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>