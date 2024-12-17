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
        .mess-box { width: 80%; max-width: 800px; background-color: white; padding: 20px; border-radius: 5px; }
        .message { background-color:rgb(255, 255, 255); color: white; padding: 10px; margin-bottom: 10px; border-radius: 5px; color: black; border: 1px solid black;}
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


        <div class="mess-box">
        <?php
            // Kiểm tra nếu người dùng chưa đăng nhập
            if (!isset($_SESSION['login_username'])) {
                header('Location: ../test.php');
                exit();
            }

            // Kết nối đến cơ sở dữ liệu
            include '../connect/connect.php';
            $conn = connect_db();

            // Truy vấn dữ liệu từ bảng history
            $sql = "SELECT * FROM history ORDER BY created_at DESC";
            $result = $conn->query($sql);

            // Kiểm tra nếu có dữ liệu
            if ($result->num_rows > 0) {
                // Duyệt qua các dòng dữ liệu và hiển thị
                while($row = $result->fetch_assoc()) {
                    echo '<div class="message">';
                    echo '<strong>Tên người dùng: </strong>' . htmlspecialchars($row['username']) . '<br>';
                    echo '<strong>Hành động: </strong>' . htmlspecialchars($row['action']) . '<br>';
                    echo '<strong>Chi tiết: </strong>' . htmlspecialchars($row['details']) . '<br>';
                    echo '<strong>Thời gian: </strong>' . htmlspecialchars($row['created_at']) . '<br>';
                    echo '</div>';
                }
            } else {
                echo 'Không có lịch sử hoạt động.';
            }

            // Đóng kết nối
            $conn->close();
            ?>

        </div>
    </div>
</body>
</html>
