<?php
session_start();
ob_start(); // Hạn chế lỗi chuyển trang
include '../connect/connect.php';

if (isset($_POST['btn_dangnhap'])) {
    $usernameoremail = $_POST['username_or_email'];
    $password = $_POST['password'];

    // Kết nối đến cơ sở dữ liệu
    $conn = connect_db();

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    if (($usernameoremail == "admin" || $usernameoremail == "admin@gmail.com") && $password == "admin") {
        // Thiết lập session cho admin
        $_SESSION['login_Id'] = "admin_id";
        $_SESSION['login_username'] = "admin";
        $_SESSION['login_fullname'] = "Administrator";

        // Kiểm tra URL trước đó để chuyển hướng (nếu có)
        if (isset($_SESSION['redirect_after_login'])) {
            $redirect_url = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirect_url");
        } else {
            header("Location: ../admin/admin.php");
        }
        exit();
    } else {
        // Truy vấn cơ sở dữ liệu để kiểm tra người dùng
        $sql = "SELECT * FROM user WHERE (username = ? OR email = ?) AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $usernameoremail, $usernameoremail, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['login_Id'] = $user['ID'];
            $_SESSION['login_username'] = $user['username'];
            $_SESSION['login_fullname'] = $user['fullname'];

            // Kiểm tra URL trước đó để chuyển hướng (nếu có)
            if (isset($_SESSION['redirect_after_login'])) {
                $redirect_url = $_SESSION['redirect_after_login'];
                unset($_SESSION['redirect_after_login']);
                header("Location: $redirect_url");
            } else {
                header("Location: ../test.php");
            }
            exit();
        } else {
            echo "<script>alert('Tên đăng nhập/email hoặc mật khẩu sai hoặc tài khoản không tồn tại')</script>";
        }
    }

    if (!$stmt) {
        die("Lỗi chuẩn bị truy vấn: " . $conn->error);
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đăng nhập</title>
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
        }

        #btnback{
            background-color: #FB6F6F;
            padding: 10px;
            text-decoration: none;
            color: black;
            font-weight: bold;
            margin-left: 10%;
            cursor: pointer;
            border-radius: 5px;
        }
        #btnback:hover{
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.25);

        }
        #logo{
            position: absolute;
            text-decoration: none;
            color: black;
            font-weight: bold;
            font-size: 30px;
            left: 35%;
        }
        /*-----------------------------------------------*/
        *{
            box-sizing: border-box;
        }

        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');
        /*
        lấy font montserrat website
        https://fonts.google.com/
        */

        body{
            /*su dung font web*/
            font-family: "Montserrat", sans-serif;
        }

        form{
            border: 1px solid black;
            border-radius: 5px;
            padding: 30px;
        }

        h3{
            text-align: center;
            font-size: 25px;
            font-weight: 500;
            margin: 10px 0;
        }

        input{
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

        .form-group{
            margin-bottom: 15px;
            position: relative;
        }

        #wrapper{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            /*background-image: url(/images/n1.jpg);
            background-size: cover;*/

        }

        label{
            font-size: 18px;
            position: absolute;
            padding: 0px 5px;
            left: 5px;
            top: 50%;
            /*pointer-events: none này dùng để khi t chọn ô text của tk và mk ko chọn dính tên đã đặt*/
            pointer-events: none;
            transform: translateY(-50%);
            background: #fff;
            transition: all 0.3s ease-in-out;
            font-weight: unset;
        }

        .form-group input:focus{
            border: 2px solid #1a73e8;
        }

        /*event khi có dữ liệu nhập vào ô thì sẽ giữ nguyên label đặt cho*/
        .form-group input:focus + label, .form-group input:valid + label{
            top: 0px;
            font-size: 15px;
            font-weight: 500;
            color: #1a73e8;
        }

        input#btn_login{
            background: #1a73e8;
            color: #fff;
        }

        /*khi di chuột vào button sẽ mờ đi*/
        input#btn_login:hover{
            opacity: 0.8;
        }

        .login-links{
            list-style: none;
            padding: 0;
            margin: 0;
            margin-left: 24px;
        }

        .login-links li {
            display: inline-block;
            padding: 20px;

        }

        a{
            text-decoration: none;
        }

    </style>
</head>
<body>
    <div class="header">
        <button id="btnback"><i class="fa-solid fa-left-long" style="margin-right: 3px;"></i><a href="../test.php" style="text-decoration: none; color: black;">Quay lại</a></button>
        <p id="logo">CSS - Cellphone Seller System</p>

    </div>

    <div id="wrapper">
        <form action="../B1/login.php" method="post">
            <h3 style="margin-top: 0; margin-bottom: 10px;">Login</h3>
            <div class="form-group">
                <input value="<?= isset($usernameoremail)? $usernameoremail:"" ?>" type="text" name="username_or_email" required>
                <label for="">Tài Khoản hoặc Email</label>
            </div>

            <div class="form-group">
                <input type="password" name="password" required>
                <label for="">Mật Khẩu</label>
            </div>

            <input type="submit" value="Login"
            name="btn_dangnhap" id="btn_login">

            <ul class="login-links">
                <li><a href="./dangky.php" class="btn btn-link">Đăng ký</a></li>
                <li><a href="./Verify.php" class="btn btn-link">Quên mật khẩu</a></li></br>
            </ul>
        </form>
    </div>
</body>
</html>
