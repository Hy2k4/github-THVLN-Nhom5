<?php
session_start();
ob_start(); // Hạn chế lỗi chuyển trang

if (!isset($_SESSION['login_username'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: ../B1/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat với người dùng</title>
    <style>
       #chat-box {
            width: 300px;
            height: 400px;
            overflow-y: scroll;
            border: 1px solid #ccc;
            background-color: #CECECE;
            padding: 5px 10px 5px 40px;
        }
        #message-input {
            width: 270px;
            padding: 5px;

        }
        #send-button {
            padding: 5px 10px;
        }    
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #d9534f;
            color: white;
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }
        #midder{
            background-color: #F4D885;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .logo {
            font-size: 30px; font-weight: bold;
        }
        .icons button {
            border: 1px solid black;
            border-radius: 5px;
            padding: 5px 10px; 
        }
        .icons a {
            text-decoration: none;
            color: black; 
            font-weight: bold; 
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">CSS for Seller</div>
        <div class="icons">
            <button onclick="window.history.back()"><i class="fas fa-arrow-left"></i> Quay lại</button>
        </div>
    </div>
    <div id="midder">
        <div id="box-mess">   
            <div id="chat-box"></div>
            <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
            <button id="send-button">Gửi</button>
        </div>
    </div> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function loadMessages() {
            $.ajax({
                url: "get_messages.php",
                method: "GET",
                success: function(data) {
                    $("#chat-box").html(data);
                    $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
                }
            });
        }

        $(document).ready(function() {
            loadMessages();
            setInterval(loadMessages, 1000); // Cập nhật tin nhắn mới mỗi giây

            $("#send-button").click(function() {
                var message = $("#message-input").val();
                if (message.trim() != "") {
                    $.ajax({
                        url: "send_message.php",
                        method: "POST",
                        data: { message: message },
                        success: function() {
                            $("#message-input").val('');
                            loadMessages();
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
