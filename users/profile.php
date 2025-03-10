<?php
session_start();


if (!isset($_SESSION["username"]) && !isset($_SESSION["admin"])) {
    header("Location: ../session/login.php");
    exit();
}

// if (!isset($_SESSION["username"])) {
//     header("Location: home.php");
//     exit();
// }



require_once "../db_components/db_connect.php";

if (isset($_SESSION["admin"])) { #if i am session admin , i create a session wich will store a id
    $session = $_SESSION["admin"];
} else {
    $session = $_SESSION["username"]; # else i havin session user
}

$sql = "SELECT * FROM users WHERE user_id = $session";

$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello <?= $row["first_name"] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="../styles/profile.css">
    <style>
        .card {
            background-color: transparent;
            /* Makes the background transparent */
            border: none;
            /* Optional: Removes border if needed */
        }

        .card-body {
            background-color: transparent;
            /* Ensures inner content is also transparent */
        }
    </style>

</head>

<body>


    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-lg-6 mb-4 mb-lg-0">
                    <div class="card mb-3 bg-white" style="border-radius: .5rem;">
                        <div class="row g-0">
                            <div class="col-md-4 gradient-custom text-center text-white"
                                style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                <img src="../images/<?= $row["image"] ?>"
                                    alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                                <h5><?= $row["first_name"] ?></h5>
                                <h5><?= $row["last_name"] ?></h5>
                                <i class="far fa-edit mb-5"></i>
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-4">
                                    <h6>Information</h6>
                                    <hr class="mt-0 mb-4">
                                    <div class="row pt-1">
                                        <div class="col-6 mb-3">
                                            <h6>Email</h6>
                                            <p class="text-muted"><?= $row["email"] ?></p>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h6>User Name</h6>
                                            <p class="text-muted"><?= $row["username"] ?></p>
                                        </div>
                                        <a class="btn btn-outline-dark m-1 btn-sm" href='../user_dashboard.php?id=<?= $row["user_id"] ?>'>Orders</a>
                                        <a href="profile-edit.php" class="btn btn-outline-dark m-1 btn-sm">Edit profile</a>
                                        <a href="../chat/chat.php" class="btn btn-outline-dark m-1 btn-sm">Chat</a>
                                        <a href="../index.php" class="btn btn-outline-dark m-1 btn-sm">Home</a>
                                        <a href='delete.php?id=<?= $row["user_id"] ?>' class='btn btn-danger m-1 btn-sm'>Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <!-- <div class="container">
        <img height="200" src="../pictures/" alt="">
        <h1>Welcome </h1>
        <p></p>
        <a href="profile-edit.php" class="btn btn-success">Edit profile</a>
        <a href="./admins/dashboard.php" class="btn btn-success">Products dashboard</a>
        <a href="logout.php?logout" class="btn btn-success">Logout</a>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
</body>

</html>