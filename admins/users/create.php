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



$error = false;

$uname = $fname = $lname = $email = $pass = $pictures = $role = $status = '';
$unameError = $fnameError = $lnameError = $emailError = $passError = $ImgError = $roleError = $statusError = '';


if (isset($_POST["submit"])) {
    $uname = cleanInput($_POST["uname"]);
    $fname = cleanInput($_POST["fname"]);
    $lname = cleanInput($_POST["lname"]);
    $role = cleanInput($_POST["role"]);
    $pic = fileUpload($_FILES["pic"]); # the secound prameter will be by default "user"
    $email = cleanInput($_POST["email"]);
    $pass = cleanInput($_POST["pass"]);
    $status = cleanInput($_POST["status"]);


    // validation:


    if (empty($fname)) {
        $error = true;
        $fnameError = "Required field";
    } elseif (strlen($fname) < 3) {
        $error = true;
        $fnameError = "First name is too short. Please enter at least 3 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
        $error = true;
        $fnameError = "First name can only contain letters and space. No numbers or special characters allowed.";
    }
    #==============
    if (empty($lname)) {
        $error = true;
        $lnameError = "Required field";
    } elseif (strlen($lname) < 3) {
        $error = true;
        $lnameError = "First name is too short. Please enter at least 3 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lname)) {
        $error = true;
        $lnameError = "First name can only contain letters and space. No numbers or special characters allowed.";
    }
    #==============
    if (empty($uname)) {
        $error = true;
        $unameError = "Required field";
    } elseif (strlen($uname) < 3) {
        $error = true;
        $unameError = "First name is too short. Please enter at least 3 characters.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $uname)) {
        $error = true;
        $unameError = "First name can only contain letters and space. No numbers or special characters allowed.";
    }
    #==============
    if (empty($role)) {
        $error = true;
        $roleError = "Required field";
    }
    #==============
    if (empty($email)) {
        $error = true;
        $emailError = "Required field";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter a valid email address.";
    } else {
        # query for search if email already exist
        $sqlEmail = "SELECT email FROM users WHERE email = '$email'";
        #run the query
        $result = mysqli_query($connect, $sqlEmail);
        if (mysqli_num_rows($result) != 0) {
            $error = true;
            $emailError = "This email is already registered.";
        }
    }
    #===============

    if (empty($pass)) {
        $error = true;
        $passError = "Required field";
    } elseif (strlen($pass) < 6) {
        $error = true;
        $passError = "Password is too short. Please enter at least 6 characters.";
    }
    #===============

    if (!$error) {
        $pass = hash('sha256', $pass);

        $sql = "INSERT INTO `users`( `username`, `email`, `password`, `first_name`, `last_name`, `image`, `role`, `status`) VALUES ('{$uname}','{$email}','{$pass}','{$fname}','{$lname}','{$pic[0]}','{$role}','{$status}')";

        $res = mysqli_query($connect, $sql);
        if ($res) {
            echo "<div class='alert alert-success' role='alert'>
        
        <p>Account creation is complete. You can now log in.</p>
        <hr>
        <p class='mb-0'>$pic[1]</p>
      </div>";
            $fname = $lname = $email = $role = $uname = $status = "";
            header("refresh: 3; url=../dashboard.html");
        } else {
            #show errors not insert
            echo "<div class='alert alert-danger' role='alert'>
        <p>something went wrong. Please try again later.</p>
  
      </div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creat a user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <div class="container min-vh-100">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" enctype="multipart/form-data" method="POST" class="mx-auto w-50  my-5 shadow-lg p-3 mb-5 bg-body rounded">
            <h5 class="my-4 d-flex justify-content-center
            ">Create a new User</h5>
            <div class="mb-3">
                <label for="uname" class="form-label">User name</label>
                <input type="text" class="form-control" id="uname" placeholder="User name" name="uname" value="<?= $uname ?>">
                <p class="text-danger"><?= $unameError ?></p>
            </div>
            <div class="mb-3">
                <label for="fname" class="form-label">First name</label>
                <input type="text" class="form-control" id="fname" placeholder="First name" name="fname" value="<?= $fname ?>">
                <p class="text-danger"><?= $fnameError ?></p>
            </div>
            <div class="mb-3">
                <label for="lname" class="form-label">Last name</label>
                <input type="text" class="form-control" id="lname" placeholder="Last name" name="lname" value="<?= $lname ?>">
                <p class="text-danger"><?= $lnameError ?></p>
            </div>
            <div class="mb-3 ">
                <select class='form-select' name="role">
                    <option value="" selected>---Select the role---</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pic" class="form-label">Picture</label>
                <input type="file" class="form-control" id="pic" name="pic">
            </div>
            <div class="mb-3 ">
                <select class='form-select' name="status">
                    <option value="">---Select the Status---</option>
                    <option value="active" selected>Active</option>
                    <option value="banned">banned</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" value="<?= $email ?>">
                <p class="text-danger"><?= $emailError ?></p>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Password</label>
                <input type="password" class="form-control" id="pass" name="pass">
                <p class="text-danger"><?= $passError ?></p>
            </div>
            <div class="mb-3">
                <button type="submit" name="submit" class="btn btn-outline-dark my-5">Create</button>
            </div>





        </form>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>