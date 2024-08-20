<?php
require_once "db_components/db_connect.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

$messageConfirm = $emailError = "";
$error = false;

if (isset($_POST["submit-btn"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    if (empty($email)) {
        $error = true;
        $emailError = "Email is required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Not a valid email!";
    }

    if (!$error) {
        $to = "ana-gie@outlook.com";
        $subject = "Message";
        $txt = "Name = " . $name . "\r\nEmail = " . $email . "\r\nMessage = " . $message;
        $headers = "From: noreply@demosite.com" . "\r\n" . "CC: somebodyelse@example.com";

        if (mail($to, $subject, $txt, $headers)) {
            $messageConfirm = "Thank you for your message!";
        } else {
            error_log("Mail sending failed: " . error_get_last()['message']);
            $messageConfirm = "There was an error sending your message. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet"
        href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet"
        href="styles/style.css" />
</head>

<body>


    <div class="full">
        <h3>Drop a Message</h3>
        <div class="lt">

            <form action="contact.php" autocomplete="off" enctype="multipart/form-data" class="form-horizontal" method="post"
                action="contact.php">
                <div class="form-group">
                    <div class="col-sm-12">

                        <input type="text" class="form-control" id="name" placeholder="Name" name="name" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <!-- email  -->
                        <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="" />
                        <?php if ($emailError != ""): ?>
                            <p class="text-danger"><?= $emailError ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <textarea class="form-control" rows="10" placeholder="MESSAGE" name="message"><?= isset($message) ? $message : '' ?>
            </textarea>
                <?php if ($messageConfirm != ""): ?>
                    <p class="mt-3 pl-3"><?php echo $messageConfirm; ?></p>
                <?php endif; ?>



                <button name="submit-btn" class="btn btn-signup"
                    id="submit" type="submit" value="SEND">
                    <i style="color: white;" class="fa fa-paper-plane"></i>
                    <span class="send-text">SEND</span>
                </button>
            </form>

        </div>


        <div class="rt">
            <ul class="contact-list">
                <li class="list-item">
                    <i fill="black" class="fa fa-map-marker fa-1x">
                        <span class="contact-text place">
                            Kettenbrückengasse 23 / 2 / 12, 1050 Wien

                        </span>
                    </i>
                </li>

                <li class="list-item">
                    <i class="fa fa-envelope fa-1x">
                        <span class="contact-text gmail">
                            <a href="mailto:example@example.com"
                                title="Send me an email">
                                example@example.com</a>
                        </span>
                    </i>
                </li>

                <li class="list-item">
                    <i class="fa fa-phone fa-1x">
                        <span class="contact-text phone">
                            00 43 0660 88 55 674
                        </span>
                    </i>
                </li>
            </ul>
        </div>
    </div>


</body>

</html>