<?php
session_start();
require_once "../db_components/db_connect.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

// tere is problem with user name 
// we are getting id 
$username = $_SESSION['user'];
$selectedUser = '';
$sql = "SELECT * FROM users WHERE user_id = $username";
$resultU = mysqli_query($connect, $sql);
$rowU = mysqli_fetch_assoc($resultU);


if (isset($_GET['user'])) {
    $selectedUser = $_GET['user'];
    $selectedUser    = mysqli_real_escape_string($connect, $selectedUser);
    $bringInfo = mysqli_query($connect, "SELECT * FROM users WHERE user_id = $selectedUser");
    $resSelectedUser = mysqli_fetch_assoc($bringInfo);
    $selectedUserName = $resSelectedUser["username"];
    $showChatBox = true; // i am selected user is true
} else {
    $showChatBox = false; // Sset to false
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Chat</title>
    <link href="style.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Live Chat</h1>
            <a href="../logout.php" class="logout">Logout</a>
        </div>
        <div class="account-info">
            <div class="welcome">
                <!-- tere is some problem -->

                <h2>Welcome, <?php echo ($rowU["username"]); ?>!</h2>
            </div>
            <div class="user-list">
                <h2>Select a User to Chat With:</h2>
                <ul>
                    <?php
                    //i am fetching all users
                    $sql = "SELECT * FROM users WHERE user_id != '$username'";
                    $result = $connect->query($sql);

                    if ($result->num_rows > 0) {
                        // loop for user list
                        while ($row = $result->fetch_assoc()) {
                            $userName = $row['username'];
                            $user = $row["user_id"];
                            echo "<li><a href='chat.php?user=$user'>$userName</a></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>

        <?php if ($showChatBox): ?>
            <div class="chat-box" id="chat-box">
                <div class="chat-box-header">
                    <h2><?php echo ucfirst($selectedUserName); ?></h2>
                    <button class="close-btn" onclick="closeChat()">✖</button>
                </div>
                <div class="chat-box-body" id="chat-box-body">
                    <!-- chat message tere-->
                </div>
                <form class="chat-form" id="chat-form">
                    <input type="hidden" id="sender" value="<?php echo $rowU["user_id"]; ?>">
                    <input type="hidden" id="receiver" value="<?php echo $selectedUser; ?>">
                    <input type="text" id="message" placeholder="Type your message..." required>
                    <button type="submit">Send</button>
                </form>
            </div>
    </div>
<?php endif; ?>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    function closeChat() {
        document.getElementById("chat-box").style.display = "none";
    }


    // Function for chat box visibility
    function toggleChatBox() {
        var chatBox = document.getElementById("chat-box");
        if (chatBox.style.display === "none") {
            chatBox.style.display = "block"; // Showing chat
        } else {
            chatBox.style.display = "none"; // Hide 
        }
    }


    function fetchMessages() {
        var sender = $('#sender').val();
        var receiver = $('#receiver').val();

        $.ajax({
            // if no error we showing everythin what we put in form
            url: 'fetch_messages.php',
            type: 'POST',
            data: {
                sender: sender,
                receiver: receiver
            },
            success: function(data) {
                $('#chat-box-body').html(data);

                scrollChatToBottom();
            }
        });
    }


    // Scroll the chat box to the bottom
    function scrollChatToBottom() {
        var chatBox = $('#chat-box-body');
        chatBox.scrollTop(chatBox.prop("scrollHeight"));
    }



    $(document).ready(function() {
        // Fetch messages every 3 seconds

        fetchMessages();
        setInterval(fetchMessages, 3000);
    });


    // Submit the chat message

    $('#chat-form').submit(function(e) {
        e.preventDefault();
        var sender = $('#sender').val();
        var receiver = $('#receiver').val();
        var message = $('#message').val();


        $.ajax({
            url: 'submit_message.php',
            type: 'POST',
            data: {
                sender: sender,
                receiver: receiver,
                message: message
            },
            success: function() {
                $('#message').val('');
                fetchMessages(); // Fetch messages after submitting
            }
        });

    });
</script>

</body>

</html>