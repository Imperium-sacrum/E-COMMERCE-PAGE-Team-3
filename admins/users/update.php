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
require_once "../../db_components/file_upload.php";

$id = $_GET["id"];

// Query to get the user data
$sql = "SELECT * FROM `users` WHERE user_id = {$id}";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

// Post method to handle the form submission
if (isset($_POST["update"])) {
    $uname = cleanInput($_POST["uname"]);
    $fname = cleanInput($_POST["fname"]);
    $lname = cleanInput($_POST["lname"]);
    $email = cleanInput($_POST["email"]);
    $role = cleanInput($_POST["role"]);
    $status = cleanInput($_POST["status"]);
    $pic = fileUpload($_FILES["pic"], "user");

    // If no new image is uploaded, keep the old one
    if ($_FILES["pic"]["error"] == 4) {
        $update_sql = "UPDATE `users` SET `username`='{$uname}', `first_name`='{$fname}', `last_name`='{$lname}', `email`='{$email}', `role`='{$role}', `status`='{$status}' WHERE user_id = {$id}";
    } else {
        // Delete the old picture if it exists and is not the default
        if ($row["image"] != "default.jpg") {
            unlink("../../images/{$row["image"]}");
        }
        $update_sql = "UPDATE `users` SET `username`='{$uname}', `first_name`='{$fname}', `last_name`='{$lname}', `email`='{$email}', `role`='{$role}', `status`='{$status}', `image`='{$pic[0]}' WHERE user_id = {$id}";
    }

    // Run the update query
    $update_result = mysqli_query($connect, $update_sql);

    // Handle the update result
    if ($update_result) {
        echo "<div class='alert alert-success' role='alert'>
        User has been updated! {$pic[1]}.
    </div>";
    } else {
        echo "<div class='alert alert-danger' role='alert'>
        Something went wrong, please try again!
    </div>";
    }
    // Redirect after update
    header("refresh: 3; url=../dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <main>
        <div class="container min-vh-100">
            <form enctype="multipart/form-data" method="POST" class="mx-auto w-50 my-5 shadow-lg p-3 mb-5 bg-body rounded">
                <h5 class="my-4 d-flex justify-content-center">Update User</h5>

                <div class="mb-3">
                    <label for="uname">Username</label>
                    <input type="text" class="form-control" id="uname" name="uname" value="<?= $row["username"] ?>">
                </div>

                <div class="mb-3">
                    <label for="fname">First Name</label>
                    <input type="text" class="form-control" id="fname" name="fname" value="<?= $row["first_name"] ?>">
                </div>

                <div class="mb-3">
                    <label for="lname">Last Name</label>
                    <input type="text" class="form-control" id="lname" name="lname" value="<?= $row["last_name"] ?>">
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $row["email"] ?>">
                </div>

                <div class="mb-3">
                    <label for="pic">Profile Picture</label>
                    <input type="file" class="form-control" id="pic" name="pic">
                </div>

                <div class="mb-3">
                    <label for="role">Role</label>
                    <select class="form-select" id="role" name="role">
                        <option value="admin" <?= $row["role"] == 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="user" <?= $row["role"] == 'user' ? 'selected' : '' ?>>User</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="0" <?= $row["status"] == 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="1" <?= $row["status"] == 'banned' ? 'selected' : '' ?>>Banned</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-dark mb-5" name="update">Update</button>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>