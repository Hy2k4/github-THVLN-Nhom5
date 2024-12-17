<?php
session_start();
ob_start();
include '../connect/connect.php';

if (!isset($_SESSION['login_username'])) {
    header('Location: ../test.php');
    exit();
}

$username = $_SESSION['login_username'];
$action = isset($_POST['action']) ? $_POST['action'] : '';
$detail = isset($_POST['detail']) ? $_POST['detail'] : '';

// Cấu hình múi giờ đúng (ví dụ: múi giờ Việt Nam)
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Cập nhật múi giờ nếu cần

$created_at = date('Y-m-d H:i:s');

if ($action && $detail) {
    // Insert into history table
    $conn = connect_db();
    $stmt = $conn->prepare("INSERT INTO history (username, action, details, created_at) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $action, $detail, $created_at);

    if ($stmt->execute()) {
        echo "History logged successfully.";
    } else {
        echo "Error logging history: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Missing action or detail.";
}
?>
