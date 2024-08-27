<?php
require_once "db_components/db_connect.php";
ob_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/about.css">



</head>

<body>
    <?php include 'components/navbar.php'; ?>


    <div class="hero-about">

    </div>
    <div class="content-about container">
        <h1>TO KNOW LIST</h1>
        <hr>
        <ul>
            <h2>
                <li> About Us</li>
                <h3>We're passionate about bringing high-quality, delicious food directly to your doorstep. As a small, family-run business, we believe in the power of good food to bring people together and create lasting memories.</h3>
            </h2>
            <h2>
                <li class="mt-5"> Our Story</li>

                <div class="bg">

                </div>

            </h2>
            <h2>
                <li class="mt-5 mb-2"> Our Mission</li>
                <div class="images">
                    <div class="img1">

                    </div>
                    <div class="img2">

                    </div>
                    <div class="img3">

                    </div>
                </div>
            </h2>
            <h2>
                <li class="mt-5 mb-2"> Why Choose Us?</li>
                <h3>Quality You Can Trust: We only offer products that meet our high standards. If we wouldn’t serve it at our own table, we won’t sell it.
                    Personalized Service: As a small business, we pride ourselves on our personal touch. We treat every customer like family.
                    Fast & Reliable Delivery: We know how important your time is. That’s why we offer quick, reliable delivery so you can enjoy your food fresh and fast.
                    Sustainability: We are committed to reducing our environmental impact by offering eco-friendly packaging and supporting sustainable farming practices.
                </h3>
            </h2>
            <h2>
                <hr>
                <li> Get in Touch</li>
                <ul class="get">
                    <a href="contact.php">Contact Us</a>
                    <a href="chat/chat.php">Chat with us</a>
                    <a href="#show">Visit us</a>
                    <h5 style="font-weight: 100;" id="show"> Kettenbrückengasse 23 / 2 / 12, <br>
                        1050 Wien</h5>
                </ul>
        </ul>
        </h2>

        </ul>

    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>