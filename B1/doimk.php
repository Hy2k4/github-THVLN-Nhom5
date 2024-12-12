<?php
include('../backend/srcdoimk.php'); // Import file xử lý logic
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang đổi mật khẩu</title>
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

        #logo {
            position: relative;
            text-decoration: none;
            color: black;
            font-weight: bold;
            font-size: 30px;
        }

        #wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        form {
            border: 1px solid black;
            border-radius: 5px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h3 {
            text-align: center;
            font-size: 25px;
            font-weight: 500;
            margin: 0 0 20px 0;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group input {
            width: 378px;
            height: 50px;
            padding: 10px;
            border: 1px solid #dadce0;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-group input[readonly] {
            background-color: #f5f5f5;
            color: #888;
            pointer-events: none;
        }

        label {
            font-size: 14px;
            position: absolute;
            top: 12px;
            left: 12px;
            color: #555;
            transition: 0.3s;
            background: white;
            padding: 0 5px;
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            top: -10px;
            font-size: 12px;
            color: #1a73e8;
        }

        button {
            width: 100%;
            height: 50px;
            border: none;
            background: #1a73e8;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #155db2;
        }

        .message {
            text-align: center;
            margin-top: 15px;
            color: red;
        }

        #btn-back{
            background: #f5f5f5;
            margin-top: 20px;
            padding: 0;
            cursor: pointer;
            border: 1px solid black;
        }

        #btn-back:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
        }

        #btn-back > a{
            text-decoration: none;
            color: black;
            font-weight: bold;
        }


    </style>
</head>
<body>
    <div class="header">
        <p id="logo">CSS - Cellphone Seller System</p>
    </div>

    <div id="wrapper">
        <form method="post">
            <h3>Đổi Mật Khẩu</h3>
            <div class="form-group">
                <input type="text" name="username" value="<?= htmlspecialchars($username) ?>" readonly>
                <label for="username">Tài khoản</label>
            </div>
            <div class="form-group">
                <input type="text" name="email" value="<?= htmlspecialchars($email) ?>" readonly>
                <label for="email">Email</label>
            </div>
            <div class="form-group">
                <input type="password" name="password_new" placeholder=" " required>
                <label for="password_new">Mật khẩu mới</label>
            </div>
            <div class="form-group">
                <input type="password" name="password_new_confirm" placeholder=" " required>
                <label for="password_new_confirm">Xác nhận mật khẩu</label>
            </div>
            <button type="submit" name="btn_confirm">Xác nhận</button>
            </br>
            <button id="btn-back" name="btn-back"><a href="./login.php">Quay lại trang đăng nhập</a></button>
        </form>
        <?php if (!empty($message)): ?>
            <div class="message"><?= $message ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
