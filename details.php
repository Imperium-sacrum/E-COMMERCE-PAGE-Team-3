<?php
require_once "db_components/db_connect.php";

$cards = "";
$index = $_GET["id"];

$sql = "SELECT * FROM `products` WHERE product_id = $index";
$result = mysqli_query($connect, $sql);

if (mysqli_num_rows($result) == 0) {
  $cards = "<p>No results found</p>";
} else {
  $row = mysqli_fetch_assoc($result);
  if ($row) {
    $availabilityStatus = $row["availability"] == 1 ? "Available" : "Not Available";
    $imagePath = !empty($row["image"]) ? "images/{$row["image"]}" : "images/default.png"; // Use a default image if not available

    $cards = "
        <div class='card my-3'>
            <nav>
                <a href='../index.php'>
                    <svg class='arrow' version='1.1' viewBox='0 0 512 512' width='512px' xml:space='preserve' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                        <polygon points='352,115.4 331.3,96 160,256 331.3,416 352,396.7 201.5,256' stroke='#727272'/>
                    </svg>
                </a>
                Back to the products
                <svg class='heart' version='1.1' viewBox='0 0 512 512' width='512px' xml:space='preserve' stroke='#727272' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'>
                    <path d='M340.8,98.4c50.7,0,91.9,41.3,91.9,92.3c0,26.2-10.9,49.8-28.3,66.6L256,407.1L105,254.6c-15.8-16.6-25.6-39.1-25.6-63.9c0-51,41.1-92.3,91.9-92.3c38.2,0,70.9,23.4,84.8,56.8C269.8,121.9,302.6,98.4,340.8,98.4M340.8,83C307,83,276,98.8,256,124.8c-20-26-51-41.8-84.8-41.8C112.1,83,64,131.3,64,190.7c0,27.9,10.6,54.4,29.9,74.6L245.1,418l10.9,11l10.9-11l148.3-149.8c21-20.3,32.8-47.9,32.8-77.5C448,131.3,399.9,83,340.8,83L340.8,83z' stroke='#727272'/>
                </svg>
            </nav>
            <div class='d-flex'>
                <div class='photo'>
                    <img src='$imagePath' alt='{$row["product_name"]}' onerror='this.src=\"images/default.png\"'>
                </div>
                <div class='description'>
                    <h2>{$row["product_name"]}</h2>
                    <h1>€ {$row["price"]}</h1>
                    <p>{$row["description"]}</p>
                    <p class='product-availability'>Status: {$availabilityStatus}</p>
                    <button><a href='cart.php?id={$row["product_id"]}'>Add to Cart</a></button>
                    
                </div>
            </div>
        </div>";
  }
}

mysqli_close($connect);
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/details.css">
  <link rel="stylesheet" href="cards.css.map">



</head>

<body>
  <?php include 'components/navbar.php'; ?>
  <div class=" container">


    <?= $cards ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>