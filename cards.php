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
include 'components/navbar.php';

$sqlCN = "SELECT * FROM product_categories";
$resultCN = mysqli_query($connect, $sqlCN);
$categories = mysqli_fetch_all($resultCN, MYSQLI_ASSOC);
$category_list = "";

foreach ($categories as $category) {

  $category_name = ($category['category_name']);

  $category_list .= "<li><a href='cards.php?search=$category_name'>$category_name</a></li>";
}

// CATEGORY
$condition = isset($_GET['category']) ? $_GET['category'] : "";
$sqlCN = "SELECT * FROM product_categories";
if (!empty($condition)) {

  if (mysqli_num_rows($resultCN) > 0) {
    while ($row = mysqli_fetch_assoc($resultCN)) {
      echo  $category_list .= "<li>" . $row['category_name'] . "</li>";
    }
  } else {
    echo "<p>No categories found.</p>";
  }
  $sqlCN .= " WHERE category_name ='{$_GET['category']}'";
  $resultCN = mysqli_query($connect, $sqlCN);
  $row = mysqli_fetch_assoc($resultCN);
}

if (empty($condition)) {
  $sqlcategory = "SELECT * FROM `products`";
} else {
  $sqlcategory = "SELECT * FROM `products` WHERE category_id= " . $row["category_id"];
}

$resultCategory = mysqli_query($connect, $sqlcategory);


if (mysqli_num_rows($resultCategory) == 0) {
  $cards .= "<p>No products found in this category.</p>";
} else {
  $products = mysqli_fetch_all($resultCategory, MYSQLI_ASSOC);
  $cards = "";

  // SEARCH 
  $search = "";

  if (isset($_GET['search'])) {
    $search = $_GET['search'];
  }

  $sqlSearch = "SELECT * FROM `products` JOIN product_categories ON product_categories.category_id = products.category_id";

  if (!empty($search)) {
    $sqlSearch .= " WHERE `product_name` LIKE '%$search%' 
      OR `category_name` LIKE '%$search%' 
      ";
  }

  $resultSearch = mysqli_query($connect, $sqlSearch);
  $cards = "";

  if (mysqli_num_rows($resultSearch) == 0) {
    $cards = "<p>No results found</p>";
  } else {
    $rows = mysqli_fetch_all($resultSearch, MYSQLI_ASSOC);

    foreach ($rows as $key => $row) {
      if ($row["availability"] == 1) {
        $cards .= "
        <div class='my-3'>
          <div class='product-card'>
            <div class='card position-relative overflow-hidden'>
              <img src='images/{$row["image"]}' style='height: 400px; object-fit: cover;' class='card-img-top' alt='Image 1'>
              <div class='card-img-overlay d-flex flex-column justify-content-between align-items-center p-4 bg-dark bg-opacity-50 text-white'>
                <p class='card-title-hero text-white text-center'>{$row['product_name']}</p>
                <p class='product-price'>€ {$row['price']}</p>
                <div class='card-info '>
                  <button><a href='details.php?id={$row["product_id"]}'>Details</a></button> 
                  <button onclick='addToCart({$row["product_id"]})'>Add to Cart</button>
                </div>
              </div>
            </div>
          </div>
        </div>";
      }
    }



    if (empty($cards)) {
      $cards .= "<p>No products available in this category.</p>";
    }
  }
}



// <div class='product-card'>
// <div class='card-image'>
//  <img src='images/{$row["image"]}'>
// </div>
// <div class='card-info'>
//   <h2 class='product-name'>{$row["product_name"]}</h2>
//   <p class='product-price'>€ {$row["price"]}</p>
//    <p class='product-availability'>Status: {$availabilityStatus}</p>

//   <div class='card-info d-flex'>
//   <button onclick='addToCart({$row["product_id"]})'>Add to Cart</button>
//   <button><a href='details.php?id={$row["product_id"]}'>Details</a></button>
// </div>
// </div>
// </div>
// </div>


// TEST
//  OR `` LIKE'%$search%


// CARDS 
// $result = mysqli_query($connect, $sqlcategory);

// if (mysqli_num_rows($result) == 0) {

//   $cards = "<p>No products found</p>";
// } else {
//   $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
//   foreach ($rows as $key => $row) {
//     $availabilityStatus = $row["availability"] == 1 ? "Available" : "Not Available";
//     $cards .= "<div>
//      <div class='product-card'>
//       <div class='card-image'>
//        <img src='images/{$row["image"]}'>
//       </div>
//       <div class='card-info'>
//         <h2 class='product-name'>{$row["product_name"]}</h2>
//         <p class='product-price'>€ {$row["price"]}</p>
//          <p class='product-availability'>Status: {$availabilityStatus}</p>

//         <div class='card-info d-flex'>
//         <button><a href='order.php?id={$row["product_id"]}'>Add to Cart</a></button>
//     <button><a href='details.php?id={$row["product_id"]}'>Details</a></button>
//       </div>
//       </div>
//     </div>

// </div>



//          ";
//   }
// }




?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="stylesheet" href="styles/cards.css">
  <link rel="stylesheet" href="styles/style.css">
  <link rel="stylesheet" href="styles/.css">
  <link rel="stylesheet" href="../styles/footer.css">
</head>

<body id="cards-body">

  <h1 class="mt-5 text-dark">PRODUCTS</h1>
  <div class="search-container d-flex">

    <form role="search">
      <input class="form-control" type="search" value="<?php echo ($search) ?>" placeholder="Product or Category" aria-label="Search" name="search">
      <button class="btn-create" type="submit">Search</button>
    </form>
  </div>

  <div class="categories container">
    <ul class="categ-li d-flex flex-row text-dark justify-content-start">
      <li><a href="cards.php?category=">ALL</a></li>
      <?= $category_list ?>
    </ul>
  </div>

  <div class="container-cards section-card mt-5">
    <div class="row row-cols-xl-4 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-xs-2">
      <?= $cards ?>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- I touched this part to make it work -->
  <script>
    function addToCart(productId) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "cart_action.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send("product_id=" + productId);
      Swal.fire({
        position: "top-center",
        icon: "success",
        title: "The product has been added to the cart!!",
        showConfirmButton: false,
        timer: 2000
      });
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
<?php include 'components/footer.php';
?>

</html>