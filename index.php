<?php
// ob_start();
// session_start();

// if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
//     header("Location: login.php");
//     exit();
// }


require_once  "db_connect.php";

?>
<!DOCTYPE html>
<html lang="en">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="styles/style.css">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce</title>
</head>

<body>
    <!-- Navbar -->
    <?php include 'components/navbar.php';
    ?>
    <!-- Hero goes here -->
    <?php include 'components/hero.php';
    ?>


    <!-- Index File goes here -->




    <!-- Footer start -->
    <?php include 'components/footer.php';
    ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>