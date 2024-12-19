<?php
session_start();
include '../connect/connect.php';
$message = "";
$conn = connect_db();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['login_username'])) {
    header("Location: ../test.php");
    exit();
}

// Lấy thông tin người dùng từ database
$user_id = $_SESSION['login_username']; // username là chuỗi
$query = "SELECT * FROM user WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $user_id); // "s" là string
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Xử lý khi nút "Lưu" được bấm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['save-btn'])) {
    // Lấy dữ liệu từ form
    $fullname = $_POST['fullname'];
    $birthday = $_POST['birthday'];
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    // Cập nhật thông tin trong database
    $update_query = "UPDATE user SET fullname = ?, birthday = ?, email = ?, sdt = ?, address = ?, password = ? WHERE username = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssssss", $fullname, $birthday, $email, $sdt, $address, $password, $user_id); // username cũng là string

    if ($update_stmt->execute()) {
        echo "<script>
                alert('Update information successfully!');
            </script>";
        // Tải lại trang để hiển thị thông tin mới
        header("Location: " . $_SERVER['PHP_SELF']);
        exit(); // Dừng thực thi mã sau khi chuyển hướng
    } else {
        echo "<script>
                alert('Có lỗi xảy ra, vui lòng thử lại.');
            </script>";
    }
}

$conn->close();
?>
