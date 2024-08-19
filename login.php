<?php
ob_start();
session_start();

// if (isset($_SESSION["user"])) {
//     header("Location: user.php");
//     exit();
// }


// if (isset($_SESSION["admin"])) {
//     header("Location: dashboard.php");
//     exit();
// }


require_once "db_components/db_connect.php";

$error = false;
$email = $password = $emailError = $passError = "";

if (isset($_POST["login-btn"])) {
    $email = cleanInput($_POST["email"]);
    $password = cleanInput(($_POST["password"]));

    if (empty($email)) {
        $error = true;
        $emailError = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Not a valid email!";
    }


    if (empty($password)) {
        $error = true;
        $passError = "Password is required!";
    }


    if (!$error) {
        $password = hash("sha256", $password);
        $sql = "SELECT * FROM `users` WHERE email = '$email' AND Password = '$password'";
        $result = mysqli_query($connect, $sql);


        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row["status"] == "admin") {

                $_SESSION["admin"] = $row["user_id"];
                header("Location: dashboard.php");
            } else {

                $_SESSION["user"] = $row["user_id"];
                header("Location: user.php");
            }
        } else {
            echo "Incorrect credintials!";
        }
    }
}











?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <div class="reglog">
        <div class="reglog_content">

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" autocomplete="off" enctype="multipart/form-data" method="POST" class="mx-auto">
                <h1 class="mb-3">Hello</h1>

                <div class="mb-3 input-box d-flex">

                    <a class="btn btn-trans" href="login.php">Log in</a>


                    <a class="btn btn-trans" href="registration.php">Sign up</a>
                </div>

                <div class="mb-3 input-box">
                    <!-- <label for="Email">Email</label> -->
                    <input type="email" class="form-control" name="email" placeholder="example@example.com" value="<?= $email ?>">
                    <p class="text-danger"><?= $emailError ?></p>
                </div>

                <div class="mb-3 input-box">
                    <!-- <label for="myInput">Password</label> -->
                    <input type="password" class="form-control" id="myInput" name="password" placeholder="Password">
                    <p class="text-danger"><?= $passError ?></p>
                </div>

                <div class="mb-3 input-box">
                    <input type="checkbox" onclick="myFunction()"> Show Password
                </div>

                <div class="mb-3 input-box">
                    <input type="submit" class="btn btn-signup" value=" Login" name="login-btn"></input>
                </div>
            </form>
        </div>
    </div>

    <script>
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>

</body>

</html>