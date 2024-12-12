<?php
$message = "";
$loi = "";
include '../connect/connect.php';

if (isset($_POST['btn_submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $fullname = $_POST['fullname'];
    $date = $_POST['date'];
    $email = $_POST['email'];
    $sdt = $_POST['number'];
    $address = $_POST['address'];

    // Kiểm tra mật khẩu nhập lại
    if ($password !== $confirm_password) {
        $message = "<p style='color:red;'>Mật khẩu và mật khẩu nhập lại không khớp.</p>";
    } else {
        $conn = connect_db();

        if ($conn->connect_error) {
            die("Kết nối thất bại: " . $conn->connect_error);
        }

        // Kiểm tra các trường nhập liệu
        if (empty($username)) {
            $loi .= "Vui lòng nhập tên đăng nhập<br>";
        } elseif (strlen($username) < 1) {
            $loi .= "Tên đăng nhập phải trên 1 kí tự<br>";
        }

        if (empty($password)) {
            $loi .= "Vui lòng nhập mật khẩu<br>";
        } elseif (strlen($password) < 8) {
            $loi .= "Mật khẩu phải trên 7 kí tự<br>";
        }

        if (empty($confirm_password)) {
            $loi .= "Vui lòng nhập mật khẩu xác minh<br>";
        } elseif (strlen($confirm_password) < 8) {
            $loi .= "Mật khẩu xác minh phải trên 7 kí tự<br>";
        }

        if (empty($fullname)) {
            $loi .= "Vui lòng nhập tên Họ Tên<br>";
        }

        if(empty($date)){
            $loi .= "Vui lòng nhập ngày sinh<br>";
        }

        if (empty($email)) {
            $loi .= "Vui lòng nhập email<br>";
        } elseif (strlen($email) < 12) {
            $loi .= "Email phải trên 12 kí tự<br>";
        }

        if(empty($sdt)){
            $loi .= "Vui lòng nhập số điện thoại<br>";
        } elseif (strlen($sdt) < 9) {
            $loi .= "Vui lòng nhập số điện thoại trên 10 kí tự<br>";
        }

        if (empty($address)) {
            $loi .= "Vui lòng nhập địa chỉ<br>";
        }

        // Kiểm tra username đã tồn tại
        if (empty($loi)) {
            $check_sql = "SELECT username FROM user WHERE username = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("s", $username);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                $loi .= "Tên đăng nhập đã có người dùng </br> Vui lòng chọn tên khác<br>";
            }

            $check_stmt->close();
        }

        // Thực hiện chèn dữ liệu nếu không có lỗi
        if (empty($loi)) {
            $sql = "INSERT INTO user (username, password, fullname, birthday, email, sdt, address) VALUES (?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("sssssss", $username, $password, $fullname, $date, $email, $sdt, $address);

                if ($stmt->execute()) {
                    echo "<script>alert('Đăng ký thành công! Vui lòng chờ 3 giây để chuyển hướng.');</script>";
                    echo "<script>setTimeout(function() { window.location.href = './login.php?message=success'; }, 2500);</script>";
                    exit();
                } else {
                    $message = '<p>Lỗi: ' . $stmt->error . '</p>';
                }
                $stmt->close();
            } else {
                echo "Lỗi: " . $conn->error;
            }
        } else {
            $message = '<p style="color:red;">' . $loi . '</p>';
        }

        $conn->close();
    }
}

// Kiểm tra xem có thông báo từ query string không
if (isset($_GET['message']) && $_GET['message'] == 'success') {
    $message = '<p style="color:green;">Đăng ký thành công!</p>';
}
?>



<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Đăng ký</title>
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

        #logo{
            position: relative;
            text-decoration: none;
            color: black;
            font-weight: bold;
            font-size: 30px;
        }
        /*-----------------------------------------------*/
        * {
            box-sizing: border-box;
        }
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@100;900&display=swap');
        body {
            font-family: "Montserrat", sans-serif;
        }
        form {
            border: 1px solid black;
            border-radius: 5px;
            padding: 30px;
        }
        h3 {
            text-align: center;
            font-size: 25px;
            font-weight: 500;
        }
        input {
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
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        #wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }
        label {
            font-size: 18px;
            position: absolute;
            padding: 0px 5px;
            left: 5px;
            top: 50%;
            pointer-events: none;
            transform: translateY(-50%);
            background: #fff;
            transition: all 0.3s ease-in-out;
        }
        .form-group input:focus {
            border: 2px solid #1a73e8;
        }
        .form-group input:focus + label, .form-group input:valid + label {
            top: 0px;
            font-size: 15px;
            font-weight: 500;
            color: #1a73e8;
        }
        input#btn_submit {
            background: #1a73e8;
            color: #fff;
        }
        input#btn_submit:hover {
            opacity: 0.8;
        }
        #btn-back > a{
            text-decoration: none;
            color: #202124;
            font-weight: bold;
        }
        #btn-back{
            margin-top: 10px;
            padding: 0;
            width: 100px;
            height: 30px;
            border-radius: 5px;
            margin-left: 100px;
        }
        #btn-back:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
        }
    </style>
</head>
<body>
    <div class="header">
        <p id="logo">CSS - Cellphone Seller System</p>
    </div>

    <div id="wrapper">
        <form action="../B1/dangky.php" method="post">
            <h3 style="margin-top: 0;">Resign account</h3>
            <div class="form-group">
                <input value="<?= isset($username)? $username:"" ?>" type="text" name="username" required>
                <label for="">Tài Khoản</label>
            </div>

            <div class="form-group">
                <input type="password" name="password" required>
                <label for="">Mật Khẩu</label>
            </div>

            <div class="form-group">
                <input type="password" name="confirm_password" required>
                <label for="">Xác nhận mật Khẩu</label>
            </div>

            <div class="form-group">
                <input value="<?= isset($fullname)? $fullname:"" ?>" type="text" name="fullname" required>
                <label for="">Họ Tên</label>
            </div>

            <div class="form-group">
                <input type="date" name="date" required>
                <label for="">Ngày sinh</label>
            </div>

            <div class="form-group">
                <input type="email" name="email" required>
                <label for="">Email</label>
            </div>

            <div class="form-group">
                <input type="text" name="number" required>
                <label for="">Số điện thoại</label>
            </div>

            <div class="form-group">
                <input type="text" name="address" required>
                <label for="">Địa chỉ</label>
            </div>

            <input type="submit" name="btn_submit" value="Đăng ký" id="btn_submit" class="btn_submit">
            </br>

            <button id="btn-back"><a href="./login.php">Quay lại</a></button>

            <div id="thong-bao">
                <?php echo $message; ?>
            </div>
        </form>
    </div>





    <script>
    </script>
</body>
</html>