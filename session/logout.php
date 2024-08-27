<?php
ob_start();

session_start();

if (isset($_GET["logout"])) {
    unset($_SESSION["username"]);
    unset($_SESSION["admin"]);

    session_unset();
    session_destroy();
    header("Location: ../session/login.php");
}
