<?php
require_once "../db_components/db_connect.php";
require_once "../db_components/file_upload.php";

// session_start(); 

$error = false;
$uname = $fname = $lname = $email = $pass = $pictures = '';
$unameError = $fnameError = $lnameError = $emailError = $passError = $ImgError = '';
$successMessage = '';
$errorMessage = '';

if (isset($_POST['btn-signup'])) {

    $uname = cleanInput($_POST["username"]);
    $email = cleanInput($_POST["email"]);
    $password = cleanInput($_POST["password"]);
    $fname = cleanInput($_POST["first_name"]);
    $lname = cleanInput($_POST["last_name"]);
    $pictures = fileUpload($_FILES['image']); // 'picture'


    if (empty($uname)) {
        $error = true;
        $unameError = "User name can't be empty!";
    } elseif (strlen($uname) < 3) {
        $error = true;
        $unameError = "User name can't be less than 3 chars";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $uname)) {
        $error = true;
        $unameError = "User name must contain only letters and spaces!";
    } else {
        $searchIfUsernameExists = "SELECT username FROM users WHERE username = '$uname'";
        $result = mysqli_query($connect, $searchIfUsernameExists);
        if (!$result) {
            $error = true;
            $errorMessage = "Error checking username: " . mysqli_error($connect);
        } elseif (mysqli_num_rows($result) != 0) {
            $error = true;
            $unameError = "Username already exists!";
        }
    }

    if (empty($fname)) {
        $error = true;
        $fnameError = "First name can't be empty!";
    } elseif (strlen($fname) < 3) {
        $error = true;
        $fnameError = "First name can't be less than 3 chars";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $fname)) {
        $error = true;
        $fnameError = "First name must contain only letters and spaces!";
    }

    if (empty($lname)) {
        $error = true;
        $lnameError = "Last name can't be empty!";
    } elseif (strlen($lname) < 3) {
        $error = true;
        $lnameError = "Last name can't be less than 3 chars";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $lname)) {
        $error = true;
        $lnameError = "Last name must contain only letters and spaces!";
    }

    if (empty($email)) {
        $error = true;
        $emailError = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please type a valid email!";
    } else {
        $searchIfEmailExists = "SELECT email FROM users WHERE email = '$email'";
        $result = mysqli_query($connect, $searchIfEmailExists);
        if (!$result) {
            $error = true;
            $errorMessage = "Error checking email: " . mysqli_error($connect);
        } elseif (mysqli_num_rows($result) != 0) {
            $error = true;
            $emailError = "Email already exists!";
        }
    }

    if (empty($password)) {
        $error = true;
        $passError = "Password can't be empty!";
    } elseif (strlen($password) < 6) {
        $error = true;
        $passError = "Password can't be less than 6 chars";
    }

    if (!$error) {
        $password = hash('sha256', $password);
        $sql = "INSERT INTO users (username, first_name, last_name, email, password, image) VALUES ('$uname', '$fname', '$lname', '$email', '$password', '{$pictures[0]}')";

        $result = mysqli_query($connect, $sql);

        if ($result) {
            $successMessage = "Registered successfully! You will be redirected to the login page shortly.";

            header("Refresh:3; url=/session/login.php");
        } else {
            $errorMessage = "Something went wrong, please try again later!";
        }
    } else {

        if ($errorMessage) {
            $errorMessage = "<div class='alert alert-danger' role='alert'>
                                <h4 class='alert-heading'>Error!</h4>
                                <p>$errorMessage</p>
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
    <link rel="stylesheet" href="../styles/style.css">
    <link rel="stylesheet" href="../styles/footer.css">
</head>

<body>


    <div class="reglog">
        <div class="reglog_content">

            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Success!</h4>
                    <p><?= htmlspecialchars($successMessage) ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($errorMessage)): ?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Error!</h4>
                    <p><?= htmlspecialchars($errorMessage) ?></p>
                </div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" method="POST" class="mx-auto">
                <h1 class="mb-3">Hello</h1>
                <div class="mb-3 input-box button-container">
                    <button type="submit" class="btn-custom" name="btn-signup">SIGN UP</button>
                    <button type="button" class="btn-custom">
                        <a href="login.php">LOG IN</a>
                    </button>
                </div>
                <div class="mb-3 input-box">
                    <input type="text" placeholder="Username" class="form-control" id="username" name="username" value="<?= htmlspecialchars($uname) ?>">
                    <p class="text-danger"><?= htmlspecialchars($unameError) ?></p>
                </div>

                <div class="mb-3 input-box">
                    <input type="text" placeholder="First Name" class="form-control" id="name" name="first_name" value="<?= htmlspecialchars($fname) ?>">
                    <p class="text-danger"><?= htmlspecialchars($fnameError) ?></p>
                </div>

                <div class="mb-3 input-box">
                    <input type="text" placeholder="Last Name" class="form-control" id="lastName" name="last_name" value="<?= htmlspecialchars($lname) ?>">
                    <p class="text-danger"><?= htmlspecialchars($lnameError) ?></p>
                </div>

                <div class="mb-3 input-box">
                    <input type="file" class="form-control" id="image" name="image">
                </div>

                <div class="mb-3 input-box">
                    <input type="email" placeholder="Email address" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
                    <p class="text-danger"><?= htmlspecialchars($emailError) ?></p>
                </div>

                <div class="mb-3 input-box">
                    <input type="password" placeholder="Password" class="form-control" id="password" name="password">
                    <p class="text-danger"><?= htmlspecialchars($passError) ?></p>
                </div>

                <div class="mb-3 input-box">
                    <input type="checkbox" onclick="myFunction()"> Show Password
                </div>

                <div class="mb-3 input-box">
                    <button type="submit" class="btn btn-signup-a" name="btn-signup">SIGN UP</button>
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
    <?php include '../components/footer.php'; ?>
</body>

</html>