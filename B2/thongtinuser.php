<?php
include '../backend/update_user.php';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Cá Nhân</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #ff6f6f;
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
        }
        .header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .header .icons {
            display: flex;
            align-items: center;
        }
        .header .icons i {
            margin-left: 15px;
            cursor: pointer;
        }
        .container {
            padding: 20px;
            max-width: 600px;
            margin: 40px auto;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group .upload-btn {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        .form-group .upload-btn input {
            display: none;
        }
        .form-group .upload-btn label {
            background-color: #ff6f6f;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group .upload-btn i {
            margin-right: 10px;
        }
        .form-group img {
            max-width: 100%;
            margin-top: 10px;
        }
        .save-btn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #ff6f6f;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .save-btn:hover{
            opacity: 0.8;
        }

        #btn-back > a{
            text-decoration: none;
            color: black;
            font-weight: bold;

        }
        #btn-back{
            width: 600px;
            height: 30px;
            padding: 0;
            cursor: pointer;
            border: 1px solid black;
            border-radius: 5px;
            font-weight: bold;
        }
        #btn-back:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
        }
                /* Kiểu dáng cho thông báo */
        #message {
            position: fixed;
            top: 20%;
            right: 40%;
            left: 40%;
            background-color: #4caf50;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 1);
            z-index: 1000;
            display: none;
            text-align: center;
        }
        #message.error {
            background-color: #f44336;
        }
    </style>
</head>
<body>
    <div id="message" class="<?= !empty($message) ? ($message === "Lưu dữ liệu thành công!" ? "" : "error") : "" ?>">
        <?= htmlspecialchars($message) ?>
    </div>
    <div class="header">
        <div class="logo" style="margin-left: 20px;">CSS - Cellphone Seller System</div>
    </div>
    <div class="container">
        <h2>Personal Information</h2>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username: (can't edit)</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" readonly>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="text" id="password" name="password" value="<?= htmlspecialchars($user['password'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="fullname">Fullname:</label>
                <input type="text" id="fullname" name="fullname" value="<?= htmlspecialchars($user['fullname'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="birthday">Date of birth:</label>
                <input type="date" id="birthday" name="birthday" value="<?= htmlspecialchars($user['birthday'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="sdt">Phone Number:</label>
                <input type="text" id="sdt" name="sdt" value="<?= htmlspecialchars($user['sdt'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?= htmlspecialchars($user['address'] ?? '') ?>">
            </div>
            <button class="save-btn" type="submit" name="save-btn">Save</button>
            </br>
        </form>
        <a href="../test.php"><button id="btn-back">Turn back</button></a>
</body>
</html>