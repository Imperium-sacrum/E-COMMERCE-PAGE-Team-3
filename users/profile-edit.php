<?php


# none users if they try to access the dashboard
// if (!isset($_SESSION["user"]) && !isset($_SESSION["admin"])) {
//     header("Location: login.php"); //<--location landing page
//     exit();
// }


include '../components/navbar.php';
require_once "../db_components/db_connect.php";
require_once "../db_components/file_upload.php";




// if (isset($_SESSION["admin"])) {
//     $session = $_SESSION["admin"];
//     $backTo = "dashboard.php";
// } else {
//     $session = $_SESSION["user"];
//     $backTo = "home.php";
// }
if (isset($_SESSION["admin"])) { #if i am session admin , i create a session wich will store a id
    $session = $_SESSION["admin"];
} else {
    $session = $_SESSION["username"]; # else i havin session user
    ;
}

$sql = "SELECT * FROM users WHERE user_id = $session";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

// $username = $email = $password = $first_name = $last_name = $hashedPassword = "";

if (isset($_POST["edit"])) {
    $username = cleanInput($_POST["username"]);
    $email = cleanInput($_POST["email"]);
    $password = cleanInput($_POST["password"]);

    $first_name = cleanInput($_POST["first_name"]);
    $last_name = cleanInput($_POST["last_name"]);
    $image = fileUpload($_FILES["image"]);
    $hashedPassword = !empty($password) ? hash('sha256', $password) : $row['password'];


    if ($_FILES["image"]["error"] == 4) {
        $sqlUpdate = "UPDATE users SET username = '$username', email = '$email', `password` = '$hashedPassword', first_name = '$first_name', last_name = '$last_name' WHERE user_id =  $session";
    } else {
        if ($row["image"] != 'avatar-1.png') // avatar.jpg for default picture
        {
            unlink("../images/" . $row["image"]);
        }
        $sqlUpdate = "UPDATE users SET username = '$username', email = '$email', `password` = '$hashedPassword', first_name = '$first_name', last_name = '$last_name',  `image` ='$image[0]' WHERE user_id =  $session";
    }
    $result = mysqli_query($connect, $sqlUpdate);

    if ($result) {

        header("location: profile.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello <?= $row["first_name"] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles/style.css">
</head>

<body>
    <?php
    ?>
    <div class="container rounded bg-white mt-5 mb-5">
        <form enctype="multipart/form-data" method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img src="../images/<?= $row["image"] ?>" width="150" class="rounded-circle mt-5"><span class="font-weight-bold"><?= $row["username"] ?></span><span class="text-black-50"><?= $row["email"] ?></span><span> </span></div>
                </div>
                <div class="col-md-5 border-right">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile Settings</h4>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"><label class="labels">Name</label><input type="text" name="first_name" class="form-control mb-3" value="<?= $row["first_name"] ?>"></div>
                            <div class="col-md-6"><label class="labels">Surname</label><input type="text" name="last_name" class="form-control mb-3" value="<?= $row["last_name"] ?>"></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12"><label class="labels">User Name</label><input type="text" name="username" class="form-control mb-3" value="<?= $row["username"] ?>"></div>
                            <div class="col-md-12"><label class="labels">Email ID</label><input type="email" name="email" class="form-control mb-3" value="<?= $row["email"] ?>"></div>
                            <div class="col-md-12">
                                <label class="labels">Password</label>
                                <input type="password" name="password" class="form-control mb-3" placeholder="Enter new password (leave blank to keep current password)">
                            </div>
                        </div>
                        <input type="file" name="image" class="form-control mb-3">
                        <div class="mt-5 text-center"><input type="submit" name="edit" value="Update profile" class="btn"></div>
                    </div>
                </div>

            </div>
    </div>
    </div>
    </form>
    </div>



</body>

</html>