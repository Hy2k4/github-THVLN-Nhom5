<?php
session_start(); // Khởi động session
ob_start();
include '../connect/connect.php';

$message = "";

// Kiểm tra nếu session không tồn tại, chuyển hướng về trang đăng nhập
if (!isset($_SESSION['otp_email'])) {
    header("location: ../B1/login.php");
    exit();
}

$email = $_SESSION['otp_email']; // Lấy email từ session

// Kết nối cơ sở dữ liệu
$mysqli = connect_db();

if ($mysqli->connect_error) {
    die("error connect: " . $mysqli->connect_error);
}

// Lấy thông tin tài khoản (username) từ database dựa trên email
$stmt = $mysqli->prepare("SELECT username FROM user WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $username = $row['username'];
} else {
    $message = "<p id='messred'>Can't find information about username and email.</p>";
    $username = ""; // Giá trị mặc định nếu không tìm thấy
}

$stmt->close();

// Xử lý yêu cầu đổi mật khẩu
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_confirm'])) {
    $password_new = $_POST['password_new'];
    $password_new_confirm = $_POST['password_new_confirm'];

    if ($password_new !== $password_new_confirm) {
        $message = "<p id='messred'>New Password and new password verify is not match, plz try again.</p>";
    } else {
        // Cập nhật mật khẩu trong database (không băm)
        $stmt = $mysqli->prepare("UPDATE user SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $password_new, $email);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Change password success!');
                    window.location.href = './login.php';
                </script>";
            unset($_SESSION['otp_email']);
            unset($_SESSION['otp']);
            exit();
        } else {
            $message = "<p id='messred'>Error about change password: " . $stmt->error . "</p>";
        }

        $stmt->close();
    }

    if (isset($_POST['btn-back'])) {
        unset($_SESSION['otp']);
        unset($_SESSION['otp_email']);
    }
}

$mysqli->close();
?>
