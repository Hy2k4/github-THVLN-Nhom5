<?php
ob_start();
session_start(); // Khởi động session để truy cập thông tin người dùng
// Kết nối cơ sở dữ liệu
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "thlvnn5";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy tất cả tin nhắn từ cơ sở dữ liệu
$sql = "SELECT * FROM messages ORDER BY timestamp ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Kiểm tra session và hiển thị tin nhắn tương ứng với người dùng
        if (isset($_SESSION['login_username']) && $row['username'] == $_SESSION['login_username']) {
            // Nếu là tin nhắn của người dùng đã đăng nhập
            echo "<p style='color: blue;'><strong>" . $row['username'] . ":</strong> " . $row['message'] . " <span style='font-size: 0.8em; color: gray;'>" . $row['timestamp'] . "</span></p>";
        } else {
            // Nếu là tin nhắn của người khác
            echo "<p><strong>" . $row['username'] . ":</strong> " . $row['message'] . " <span style='font-size: 0.8em; color: gray;'>" . $row['timestamp'] . "</span></p>";
        }
    }
} else {
    echo "Chưa có tin nhắn nào.";
}

$conn->close();
?>
