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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    
    // Kiểm tra xem người dùng đã đăng nhập chưa
    if (isset($_SESSION['login_username'])) {
        $user_name = $_SESSION['login_username']; // Lấy tên người dùng từ session
    } else {
        $user_name = "Guest"; // Nếu chưa đăng nhập, gán là "Guest"
    }

    // Lưu tin nhắn vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO messages (username, message) VALUES (?, ?)");
    $stmt->bind_param("ss", $user_name, $message);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>
