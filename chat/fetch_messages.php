<?php
session_start();
require_once "../db_components/db_connect.php";


if (!isset($_SESSION['username'])) {
    exit("You are not logged in");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];

    $sql = "SELECT * FROM chat_messages INNER JOIN users ON chat_messages.sender = users.user_id WHERE (sender='$sender' AND receiver='$receiver') OR (sender='$receiver' AND receiver='$sender') ORDER BY created_at";

    $result = $connect->query($sql);


    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="message"><strong>' . ucfirst($row['username']) . ':</strong> ' . $row['message'] . '</div>';
        }
    }
}
