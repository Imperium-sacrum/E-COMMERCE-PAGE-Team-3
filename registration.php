<?php
require_once "db_components/db_connect.php";
require_once "db_components/file_upload.php";

if (isset($_SESSION['username'])) {
    header("Location: users/profile.php");
    exit();
}
$error = false;

$uname = $fname = $lname = $email = $pass = $pictures = '';
$unameError = $fnameError = $lnameError = $emailError = $passError = $ImgError = '';



if (isset($_POST['btn-signup'])) {

    $uname = cleanInput($_POST["username"]);

    $email = cleanInput($_POST["email"]);

    $password = cleanInput($_POST["password"]);

    $fname = cleanInput($_POST["first_name"]);

    $lname = cleanInput($_POST["last_name"]);

    $pictures = fileUpload($_FILES['image']); // 'picture'


    if (empty($uname)) {
        $error = true;
        $unameError = "user name can't be empty!";
    } elseif (strlen($uname) < 3) {
        $error = true;
        $unameError = "user name can't be less than 2 chars";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $uname)) {
        $error = true;
        $unameError = "user name must contain only letters and spaces!";
    }

    if (empty($fname)) {
        $error = true;
        $fnameError = "first name can't be empty!";
    } elseif (strlen($fname) < 3) {
        $error = true;
        $fnameError = "first name can't be less than 2 chars";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
        $error = true;
        $fnameError = "first name must contain only letters and spaces!";
    }

    if (empty($lname)) {
        $error = true;
        $lnameError = "last name can't be empty!";
    } elseif (strlen($lname) < 3) {
        $error = true;
        $lnameError = "last name can't be less than 2 chars";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lname)) {
        $error = true;
        $lnameError = "last name must contain only letters and spaces!";
    }


    if (empty($email)) {
        $error = true;
        $emailError = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please type a valid email!";
    } else {
        $searchIfEmailExists = "SELECT Email FROM users WHERE Email = '$email'";

        $result = mysqli_query($connect, $searchIfEmailExists);
        if (mysqli_num_rows($result) != 0) {
            $error = true;
            $emailError = "Email already exists!";
        }
    }

    if (empty($password)) {
        $error = true;
        $passError = "Password can't be empty!";
    } elseif (strlen($password) < 6) {
        $error = true;
        $passError = "Password can't be less than 6 Chars";
    }


    if (!$error) {
        $password = hash('sha256', $password);

        $sql = "INSERT INTO users (username,first_name, last_name,email, password, image) VALUES ('$uname', '$fname','$lname','$email','$password','$pictures[0]')";

        $result = mysqli_query($connect, $sql);

        if ($result) {
            echo "<div class='alert alert-success' role='alert'>
                    <h4 class='alert-heading'>Registered Successfully!</h4>
                    <p>You successfully created a new account on our website!<br></p>
                    <hr>
                    <p class='mb-0'>$pictures[1]</p>
                  </div>";
            $fname = $lname = $email = "";
        } else {
            echo "<div class='alert alert-danger' role='alert'>
            <h3>Something went wrong, please try again later!</h3>
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
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <div class="reglog">
        <div class="reglog_content">

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="POST" class="mx-auto">
                <h1 class="mb-3">Hello</h1>
                <div class="mb-3 input-box d-flex">
                    <button type="submit" class="btn btn-trans " name="btn-signup">SIGN UP</button>
                    <button type="button" class="btn btn-trans ">
                        <a class="text-decoration-none text-dark" href="login.php">LOG IN</a>
                    </button>
                </div>
                <div class="mb-3 input-box">
                    <!-- <label for="username">Username</label> -->
                    <input type="text" placeholder="Username" class="form-control" id="username" name="username" value="<?= $uname ?>">
                    <p class="text-danger"><?= $unameError ?></p>
                </div>

                <div class="mb-3 input-box">
                    <!-- <label for="name">First name</label> -->
                    <input type="text" placeholder="First Name" class="form-control" id="name" name="first_name" value="<?= $fname ?>">
                    <p class="text-danger"><?= $fnameError ?></p>
                </div>

                <div class="mb-3 input-box">
                    <!-- <label for="lastName">Last name</label> -->
                    <input type="text" placeholder="Last Name" class="form-control" id="lastName" name="last_name" value="<?= $lname ?>">
                    <p class="text-danger"><?= $lnameError ?></p>
                </div>

                <div class="mb-3 input-box">
                    <!-- <label for="image">Image</label> -->
                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <div class="mb-3 input-box">
                    <!-- <label for="email">Email</label> -->
                    <input type="email" placeholder="Email addresse" class="form-control" id="email" name="email" value="<?= $email ?>">
                    <p class="text-danger"><?= $emailError ?></p>
                </div>

                <div class="mb-3 input-box">
                    <!-- <label for="password">Password</label> -->
                    <input type="password" placeholder="Password" class="form-control" id="password" name="password">
                    <p class="text-danger"><?= $passError ?></p>
                </div>

                <div class="mb-3 input-box">
                    <input type="checkbox" onclick="myFunction()"> Show Password
                </div>
                <div class="mb-3 input-box">
                    <button type="submit" class="btn btn-signup " name="btn-signup">SIGN UP</button>

                </div>


            </form>
        </div>
    </div>

    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>