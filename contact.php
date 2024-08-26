<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'db_components/db_connect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = cleanInput($_POST["name"]);
    $email = cleanInput($_POST["email"]);
    $message = cleanInput($_POST["message"]);


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='container mt-5'><div class='alert alert-danger' role='alert'>Invalid email format.</div></div>";
        exit();
    }


    $stmt = $connect->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $connect->error);
    }
    $stmt->bind_param("sss", $name, $email, $message);

    if (!$stmt->execute()) {
        echo "<div class='container mt-5'><div class='alert alert-danger' role='alert'>There was a problem saving your message to the database. Please try again later.</div></div>";
        $stmt->close();
        $connect->close();
        exit();
    }


    $stmt->close();


    $to = "outlook_E22F0AD011D981D0@outlook.com";
    $subject = "Contact Form Submission from $name";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";


    $email_body = "Name: $name\n";
    $email_body .= "Email: $email\n\n";
    $email_body .= "Message:\n$message\n";


    if (mail($to, $subject, $email_body, $headers)) {
        echo "<div class='container mt-5'><div class='alert alert-success' role='alert'>Your message has been sent successfully!</div></div>";
    } else {
        echo "<div class='container mt-5'><div class='alert alert-danger' role='alert'>There was a problem sending your message. Please try again later.</div></div>";
    }


    $connect->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --dark-olive-green: #5F6F52;
            --laurel-green: #A9B388;
            --cornsilk: #FEFAE0;
            --lemon-meringue: #F9EBC7;
            --camel: #B99470;
            --russet: #783D19;
            --highlight-green: var(--dark-olive-green);
        }

        * {
            color: #333;
            font-family: "Raleway", sans-serif;
        }

        body {
            background-color: var(--cornsilk);
            color: var(--dark-olive-green);
        }

        .container {
            background-color: var(--lemon-meringue);
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: var(--dark-olive-green);
        }

        .form-label {
            color: var(--russet);
        }

        .form-control {
            border-color: var(--camel);
            border-radius: 5px;
        }

        .form-control:focus {
            border-color: var(--highlight-green);
            box-shadow: 0 0 0 0.2rem rgba(95, 111, 82, 0.25);
        }

        .btn-primary {
            background-color: var(--dark-olive-green);
            border-color: var(--dark-olive-green);
        }

        .btn-primary:hover {
            background-color: var(--laurel-green);
            border-color: var(--laurel-green);
        }

        .alert-success {
            background-color: var(--laurel-green);
            color: var(--dark-olive-green);
        }

        .alert-danger {
            background-color: var(--russet);
            color: var(--cornsilk);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Contact Us</h1>
        <form action="contact.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>