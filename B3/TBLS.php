<?php
session_start();
ob_start();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['login_username'])) {
    header('Location: ../test.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao diện Người Bán</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f0f0; }
        .header { background-color: #d9534f; color: white; padding: 10px; display: flex; justify-content: space-between; }
        .icons button { border: 1px solid black; border-radius: 5px; padding: 5px 10px; }
        .icons a { text-decoration: none; color: black; font-weight: bold; }
        .content { display: flex; flex-direction: column; align-items: center; margin: 20px; }
        .history { width: 80%; max-width: 800px; background-color: white; padding: 20px; border-radius: 5px; }
        .message { background-color: #5cb85c; color: white; padding: 10px; margin-bottom: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">CSS for Seller</div>
        <div class="icons">
            <button><a href="../trangchunguoiban.php"><i class="fas fa-arrow-left"></i> Quay lại</a></button>
        </div>
    </div>

    <div class="content">
        <h2>Lịch sử hoạt động</h2>


        <div class="history"></div>
            
    </div>
</body>
</html>
