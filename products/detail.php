<?php

// session_start();
// if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
//     header("Location: login.php");
//     exit();
// }
// if (isset($_SESSION["user"])) {
//     header("Location: homepage.php");
//     exit();
// }
require_once "../db_components/db_connect.php";

// #query for session
// $sql_admin = "SELECT * FROM user WHERE user_id =" . $_SESSION["admin"];
// #run
// $result_admin = mysqli_query($conn, $sql_admin);
// #fetch
// $row_admin = mysqli_fetch_assoc($result_admin);

$id = $_GET["id"];
// query
$sql = "SELECT * FROM `products` WHERE product_id= $id";
// run the query
$result = mysqli_query($connect, $sql);
// fetch data
$row = mysqli_fetch_assoc($result);
$layout = "
  
<div class='m-5 shadow-lg p-3 mb-5 bg-body rounded' >
<div class='clearfix'>
  <img src='../images/{$row["image"]}' class=' img-thumbnail col-md-6 float-md-start mb-3 ms-md-3 ' alt='{$row["product_name"]}' />

  <div class= 'd-flex justify-content-start'>
      <dl class='w-50 m-5'>
        <dt>Name</dt>
        <dd>{$row["product_name"]}</dd>

        <dt>Price</dt>
        <dd>{$row["price"]}</dd>
  
   </div>
   
  <div class='d-flex justify-content-start '>  
    <p class='w-50 m-5'><i>{$row["description"]}</i></p>
  </div>

  <div class='d-flex '> 
  <a href='update.php?id={$row["product_id"]}' class='btn btn-outline-dark d-flex justify-content-center m-3 w-25'>Update</a>
  <br>
  <a href='delete.php?id={$row["product_id"]}' class='btn btn-outline-danger d-flex justify-content-center w-25 m-3'>Delete</a>
  </div>
 
  

</div>
</div>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>


    <div class="container min-vh-100">
        <?php echo $layout ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>