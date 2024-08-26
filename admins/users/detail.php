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

// Fetch all users
$sql = "SELECT * FROM users";
$result = mysqli_query($connect, $sql);

// Check if users are available
if (mysqli_num_rows($result) == 0) {
    $layout = "
    <div class='vw-100 d-flex justify-content-center mt-3'>
       <div class='alert alert-danger d-flex align-items-center' role='alert'>
            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-exclamation-triangle-fill flex-shrink-0 me-2' viewBox='0 0 16 16' role='img' aria-label='Warning:'>
                <path d='M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
            </svg>
            <div>No data found!</div>
        </div>
    </div>";
} else {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $layout = "
    <table class='table table-striped table-hover'>
        <thead class='table-dark'>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Username</th>
                <th scope='col'>Email</th>
                <th scope='col'>First Name</th>
                <th scope='col'>Last Name</th>
                <th scope='col'>Role</th>
                <th scope='col'>Status</th>
                <th scope='col'>Actions</th>
            </tr>
        </thead>
        <tbody>";

    foreach ($users as $i => $user) {
        $layout .= "
        <tr>
            <th scope='row'>" . ($i + 1) . "</th>
            <td>{$user['username']}</td>
            <td>{$user['email']}</td>
            <td>{$user['first_name']}</td>
            <td>{$user['last_name']}</td>
            <td>{$user['role']}</td>
            <td>{$user['status']}</td>
            <td>
                <a href='update.php?id={$user["user_id"]}' class='btn btn-outline-dark btn-sm'>Update</a>
                <a href='delete.php?id={$user["user_id"]}' class='btn btn-outline-danger btn-sm'>Delete</a>
            </td>
        </tr>";
    }

    $layout .= "
        </tbody>
    </table>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <div class="container min-vh-100">
        <?php echo $layout ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>