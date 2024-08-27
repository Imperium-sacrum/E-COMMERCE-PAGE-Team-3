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

$error = false;
$total_amount = $order_status = $products = $user_id = $msgError = "";

if (isset($_POST["create"])) {
    $total_amount = cleanInput($_POST["total_amount"]);
    $order_status = cleanInput($_POST["order_status"]);
    $products = cleanInput($_POST["products"]);
    $user_id = cleanInput($_POST["user_id"]);

    // Validación básica:
    if (empty($total_amount) || empty($order_status) || empty($products) || empty($user_id)) {
        $error = true;
        $msgError = "All fields are required.";
    }

    if (!$error) {
        // Insertar nueva orden
        $sql = "INSERT INTO `orders`(`total_amount`, `order_status`, `products`, `user_id`, `created_at`, `updated_at`) 
                VALUES ('{$total_amount}', '{$order_status}', '{$products}', '{$user_id}', NOW(), NOW())";

        // Ejecutar la consulta
        $result = mysqli_query($connect, $sql);

        // Mostrar resultado
        if ($result) {
            $alarm = "<div class='alert alert-success' role='alert'>
                        Order successfully created.
                      </div>";
            $total_amount = $order_status = $products = $user_id = "";
        } else {
            $alarm = "<div class='alert alert-danger' role='alert'>
                        Something went wrong, please try again!
                      </div>";
        }

        // Redirigir
        header("refresh: 3; url=../dashboard.html");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php
    if (isset($_POST["create"])) {
        echo $alarm;
    }
    ?>
    <main>
        <div class="container min-vh-100">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="POST" class="mx-auto w-50 my-5 shadow-lg p-3 mb-5 bg-body rounded">
                <h5 class="my-4 d-flex justify-content-center">Add a New Order</h5>

                <div class="mb-3">
                    <input type="text" class="form-control" id="total_amount" name="total_amount" placeholder="Total Amount" value="<?= $total_amount ?>">
                </div>

                <div class="mb-3">
                    <select class='form-select' name="order_status">
                        <option value="" selected>---Select Order Status---</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="mb-3">
                    <textarea class="form-control" id="products" name="products" placeholder="Products (e.g., Product1, Product2, ...)" rows="3"><?= $products ?></textarea>
                </div>

                <div class="mb-3">
                    <input type="text" class="form-control" id="user_id" name="user_id" placeholder="User ID" value="<?= $user_id ?>">
                </div>

                <input type="submit" class="btn btn-dark mb-5" value="Create" name="create">
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>