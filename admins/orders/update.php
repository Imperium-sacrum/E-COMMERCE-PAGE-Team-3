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

$id = $_GET["id"];

// Consulta para obtener los detalles de la orden
$sql = "SELECT * FROM `orders` WHERE order_id = {$id}";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

// post method
if (isset($_POST["update"])) {
    $total_amount = cleanInput($_POST["total_amount"]);
    $order_status = cleanInput($_POST["order_status"]);
    $products = cleanInput($_POST["products"]);

    // Actualización de la orden
    $update_sql = "UPDATE `orders` SET 
        `total_amount`='{$total_amount}', 
        `order_status`='{$order_status}', 
        `products`='{$products}',
        `updated_at`=NOW() 
        WHERE order_id = {$id}";

    $update_result = mysqli_query($connect, $update_sql);

    // Mostrar mensajes según el resultado
    if ($update_result) {
        echo "<div class='alert alert-success' role='alert'>
        Order has been updated successfully!
        </div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>
        Something went wrong, please try again!
        </div>";
    }

    // Redirección
    header("refresh: 3; url=../dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <main>
        <div class="container min-vh-100">
            <form method="POST" class="mx-auto w-50 my-5 shadow-lg p-3 mb-5 bg-body rounded">
                <h5 class="my-4 d-flex justify-content-center">Update Order</h5>

                <div class="mb-3">
                    <label for="total_amount">Total Amount</label>
                    <input type="text" class="form-control" id="total_amount" name="total_amount" value="<?= $row["total_amount"] ?>">
                </div>

                <div class="mb-3">
                    <label for="order_status">Order Status</label>
                    <select class="form-select" id="order_status" name="order_status">
                        <option value="pending" <?= $row["order_status"] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="completed" <?= $row["order_status"] == 'completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="cancelled" <?= $row["order_status"] == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="products">Products</label>
                    <textarea class="form-control" id="products" name="products" rows="3"><?= $row["products"] ?></textarea>
                </div>

                <input type="submit" class="btn btn-dark mb-5" value="Update" name="update">
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>