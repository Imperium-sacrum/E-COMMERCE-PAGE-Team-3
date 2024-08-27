<?php
ob_start();
// session_start();
if (isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit();
}

// if (isset($_SESSION["user"])) {
//     header("Location: user.php");
//     exit();
// }


if (isset($_SESSION["admin"])) {
    header("Location: ../admins/dashboard.html");
    exit();
}


require_once "../db_components/db_connect.php";

$error = false;
$uname = $password = $unameError = $passError = "";
$username = "";


if (isset($_POST["login-btn"])) {
    $uname = cleanInput($_POST["username"]);
    $password = cleanInput(($_POST["password"]));

    if (empty($uname)) {
        $error = true;
        $unameError = "Username is required!";
    }


    if (empty($password)) {
        $error = true;
        $passError = "Password is required!";
    }


    if (!$error) {

        $password = hash("sha256", $password);
        $sql = "SELECT * FROM `users` WHERE username = '$uname' AND Password = '$password'";
        $result = mysqli_query($connect, $sql);


        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $username = $row['username'];

            if ($row["role"] == "admin") {

                $_SESSION["admin"] = $row["user_id"];
                header("Location: ../admins/dashboard.html");
            } else {
                // its shows numer insteed name

                $_SESSION["username"] = $row["user_id"];


                header("Location: ../index.php");
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

    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/footer.css">
</head>

<body>
    <?php include '../components/navbar.php';
    ?>
    <div class="reglog">
        <div class="reglog_content">



            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" autocomplete="off" enctype="multipart/form-data" method="POST" class="mx-auto">
                <h1 class="mb-3">Hello</h1>

                <div class="mb-3 input-box button-container d-flex">

                    <a style="text-decoration: none;" class="btn-custom" href="login.php">Log in</a>


                    <a style="text-decoration: none;" class="btn-custom" href="registration.php">Sign up</a>
                </div>

                <div class="mb-3 input-box">
                    <!-- <label for="Email">Email</label> -->
                    <input type="text" class="form-control" name="username" placeholder="username" value="<?= $uname ?>">
                    <p class="text-danger"><?= $unameError ?></p>
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
                    <input type="submit" class=" btn-signup-a" value=" Login" name="login-btn"></input>
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
    <?php include '../components/footer.php';
    ?>

</body>

</html>