<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Chỉ gọi session_start() nếu session chưa được bắt đầu
}
// Kiểm tra người dùng đã đăng nhập chưa
if (!isset($_SESSION['login_username'])) {
    header('Location: ../test.php'); // Chuyển hướng về trang login nếu chưa đăng nhập
    exit();
}

include '../backend/process_product.php';

// Lấy thông tin từ session
$user_id = $_SESSION['login_Id'];
$username = $_SESSION['login_username'];
$fullname = $_SESSION['login_fullname'];
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Sản Phẩm</title>
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
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .header .icons i {
            margin-left: 15px;
            cursor: pointer;
            margin-right: 5px;
        }
        .icons > button > a{
            text-decoration: none;
            color: black;
            font-weight: bold;
            width: 100px;
            height: 30px;
        }
        .icons > button{
            height: 30px;
            width: 100px;
            padding: 0;
            border: 1px solid black;
            border-radius: 5px;
        }
        .icons{
            width: auto;
            height: auto;
        }
        .icons button:hover{
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
            opacity: 0.5;
        }
        .container {
            padding: 20px;
            max-width: 800px;
            margin: 40px auto;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .upload-btn {
            display: flex;
            align-items: center;
            margin-top: 5px;
        }
        .upload-btn input {
            display: none;
        }
        .upload-btn label {
            background-color: #ff6f6f;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }
        /* Container chứa các ảnh tải lên */
        .upload-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Định dạng ảnh */
        #phone-photos-preview img, #specifications-preview img {
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            object-fit: cover;
        }

        /* Ảnh đầu tiên full size */
        #phone-photos-preview img:first-child, #specifications-preview img:first-child {
            width: auto;
            max-width: 100%;
            max-height: 300px;
        }

        /* Ảnh thứ 2 trở đi sẽ có kích thước nhỏ */
        #phone-photos-preview img:not(:first-child), #specifications-preview img:not(:first-child) {
            width: 30px;
            height: 30px;
        }

        /* Định dạng hiển thị ảnh */
        .upload-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        .upload-container img {
            max-width: 300px;
            max-height: 300px;
            width: auto;
            height: auto;
            border-radius: 5px;
            object-fit: cover;
        }
        .post-btn {
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
        .logo{
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">CSS - New post from seller</div>
        <div class="icons">
            <button><a href="../trangchunguoiban.php"><i class="fas fa-arrow-left"></i>Quay lại</a></button>
        </div>
    </div>
<form action="../backend/process_product.php" method="POST" enctype="multipart/form-data">
    <div class="container">
        <div class="form-group">
            <label for="product-name">Tên sản phẩm:</label>
            <input type="text" id="product-name" name="product-name">
        </div>
        <div class="form-group">
            <label for="headline">Tiêu đề:</label>
            <input type="text" id="headline" name="headline">
        </div>
        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="text" id="price" name="price">
        </div>
        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" rows="4"></textarea>
        </div>
        <div class="form-group">
            <label for="phone-type">Loại điện thoại:</label>
            <input type="text" id="phone-type" name="phone-type">
        </div>
        <div class="form-group">
            <label for="phone-companies">Hãng điện thoại:</label>
            <input type="text" id="phone-companies" name="phone-companies">
        </div>
        <div class="form-group">
            <label for="phone-photos">Hình ảnh điện thoại:</label>
            <div class="upload-btn">
                <label for="phone-photos-upload">
                    <i class="fas fa-upload"></i> Tải lên hình ảnh
                </label>
                <input type="file" id="phone-photos-upload" name="phone-photos[]" multiple>
            </div>
            <div id="phone-photos-preview"></div> <!-- Hiển thị ảnh đã chọn -->
        </div>

        <button class="post-btn">Đăng</button>
    </div>
</form>



<script>
    // Hiển thị ảnh cho phần hình ảnh điện thoại
    document.getElementById('phone-photos-upload').onchange = function (event) {
        const container = document.getElementById('phone-photos-preview');
        container.innerHTML = ''; // Xóa ảnh cũ trước khi thêm ảnh mới
        const files = event.target.files;

        Array.from(files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function () {
                    const img = document.createElement('img');
                    img.src = reader.result;
                    // Nếu là ảnh đầu tiên, giữ kích thước lớn, nếu không thu nhỏ lại
                    if (index === 0) {
                        img.style.maxWidth = '100%';
                        img.style.maxHeight = '300px';
                    } else {
                        img.style.width = '30px';
                        img.style.height = '30px';
                    }
                    container.appendChild(img); // Thêm ảnh vào container
                };
                reader.readAsDataURL(file);
            }
        });
    };

    // Hiển thị ảnh cho phần thông số kỹ thuật
    document.getElementById('specifications-upload').onchange = function (event) {
        const container = document.getElementById('specifications-preview');
        container.innerHTML = ''; // Xóa ảnh cũ trước khi thêm ảnh mới
        const files = event.target.files;

        Array.from(files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function () {
                    const img = document.createElement('img');
                    img.src = reader.result;
                    // Nếu là ảnh đầu tiên, giữ kích thước lớn, nếu không thu nhỏ lại
                    if (index === 0) {
                        img.style.maxWidth = '100%';
                        img.style.maxHeight = '300px';
                    } else {
                        img.style.width = '30px';
                        img.style.height = '30px';
                    }
                    container.appendChild(img); // Thêm ảnh vào container
                };
                reader.readAsDataURL(file);
            }
        });
    };
</script>

</body>
</html>
