<?php
session_start();
include '../sendmail.php';
include '../connect/connect.php';

// Kết nối cơ sở dữ liệu
$mysqli = connect_db();

if ($mysqli->connect_error) {
    die("connect fail: " . $mysqli->connect_error);
}

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['send_otp'])) {
        $email = $_POST['email'];

        // Kiểm tra email có tồn tại trong cơ sở dữ liệu không
        $stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Tạo mã OTP
            $otp = rand(100000, 999999);

            // Lưu OTP vào session để kiểm tra sau
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_email'] = $email;

            // Gửi OTP qua email
            $response = sendOTP($email, $otp);

            if ($response === true) {
                $message = "<p id='messgreen'>sent OTP code to:</br> $email </p
                >";
            } else {
                error_log("PHPMailer Error: " . $response);
                $message = "<p id='messred'>Send OTP fail, pls try again</p>";
            }
        } else {
            $message = "<p id='messred'>Email does not exist.</p>";
        }

        $stmt->close();
    }

    if (isset($_POST['verify_otp'])) {
        $email = $_POST['email'];
        $entered_otp = $_POST['otp'];

        // Kiểm tra OTP
        if ($email === $_SESSION['otp_email'] && $entered_otp == $_SESSION['otp']) {
            header("location: doimk.php");
            exit();
        } else {
            $message = "<p id='messred'>OTP is wrong.</p>";
        }
    }

    if (isset($_POST['bt_return'])) {
        unset($_SESSION['otp']);
        unset($_SESSION['otp_email']);
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đổi mật khẩu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .header {
            position: relative;
            background-color: #FB6F6F;
            padding: 10px;
            display: flex;
            align-items: center;
            height: 50px;
            justify-content: center;
        }

        #logo{
            position: relative;
            text-decoration: none;
            color: black;
            font-weight: bold;
            font-size: 30px;
        }

        #bt_return > a{
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        #bt_return{
            margin-top: 10px;
            width: 210px;
            height: 30px;
            padding: 0;
            border-radius: 5px;
            margin-left: 45px;
            cursor: pointer;
        }

        #bt_return:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
        }
        /*-----------------------------------------------*/
        
        * {
            box-sizing: border-box;
        }

        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        body {
            font-family: "Montserrat", sans-serif;
        }

        form {
            border: 1px solid black;
            border-radius: 5px;
            padding: 30px;
        }

        h3 {
            text-align: center;
            font-size: 25px;
            font-weight: 500;
        }

        input.ip {
            height: 50px;
            width: 300px;
            outline: none;
            border: 1px solid #dadce0;
            padding: 10px;
            border-radius: 5px;
            font-size: inherit;
            color: #202124;
            transition: all 0.3s ease-in-out;
        }

        .form-group {
            margin-bottom: 15px;
            position: relative;
        }

        #wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        label {
            font-size: 18px;
            position: absolute;
            padding: 0px 5px;
            left: 5px;
            top: 50%;
            pointer-events: none;
            transform: translateY(-50%);
            background: #fff;
            transition: all 0.3s ease-in-out;
        }

        .form-group input:focus {
            border: 2px solid #1a73e8;
        }

        .form-group input:focus + label, .form-group input:valid + label {
            top: 0px;
            font-size: 15px;
            font-weight: 500;
            color: #1a73e8;
        }

        input#btn, button.btn_send {
            background: #1a73e8;
            color: #fff;
        }

        input#btn:hover, button.btn_send:hover {
            opacity: 0.8;
        }

        .login-links {
            list-style: none;
            padding: 0;
            margin: 0;
            margin-left: 20px;
        }

        .login-links li {
            display: inline-block;
            padding: 20px;
        }

        a {
            text-decoration: none;
        }

        input#ip_txOTP {
            font-size: 18px;
            height: 50px;
            width: 150px;
            outline: none;
            border: 1px solid #dadce0;
            padding: 10px;
            border-radius: 5px;
            font-size: inherit;
            color: #202124;
            transition: all 0.3s ease-in-out;
        }

        button#btn_send {
            font-size: 16px;
            margin-left: 10px;
            height: 50px;
            width: 130px;
            border-radius: 5px;
            border: 1px solid #dadce0;
            background: #1a73e8;
            color: #fff;
        }

        button#btn_send:hover{
            opacity: 0.8;
        }

        p {
            position: fixed;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
            top: 0;
            margin-left: 30px;
        }

        #messgreen {
            left: 40%;
            background: #80ff80;
            top: 10%;
        }

        #messred {
            left: 40%;
            background: #ff4d4d;
            top: 10%;
        }

        

    </style>
</head>
<body>
    <div class="header">
        <p id="logo">CSS - Cellphone Seller System</p>
    </div>

    <div id="wrapper">
        <form action="" method="post">
            <h3 style="margin-top: 0;">Verify account</h3>
            <div class="form-group">
                <input type="email" name="email" class="ip" required>
                <label for="">Email</label>
            </div>

            <div class="form-group">
                <input type="text" name="otp" id="ip_txOTP" placeholder="Enter OTP">
                <button type="submit" name="send_otp" id="btn_send">Send OTP</button>
            </div>

            <input type="submit" name="verify_otp" class="ip" value="Verify Email" id="btn">
            </br>
            <button name="bt_return" id="bt_return"><a href="./login.php">Login by another account</a></button>

            <?php if (!empty($message)): ?>
                <div id="message-container">
                    <?= $message; ?>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var messageElement = document.querySelector('#messgreen, #messred'); // Tìm phần tử thông báo
            if (messageElement) {
                setTimeout(function () {
                    messageElement.style.display = 'none'; // Ẩn thông báo sau 5 giây
                }, 5000);
            }
        });
    </script>
</body>
</html>


