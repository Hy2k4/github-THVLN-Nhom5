<?php
session_start();
ob_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['login_username'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: ../B1/login.php");
    exit;
}

include '../connect/connect.php';
$conn = connect_db();

// Lấy thông tin sản phẩm
$product = null;
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        $error_message = "Sản phẩm không tồn tại.";
    }
} else {
    $error_message = "Không tìm thấy sản phẩm.";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết bài đăng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }

    .header {
        background-color: #FB6F6F;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header img {
        height: 40px;
    }

    .header .search-container {
        display: flex;
        align-items: center;
        width: 50%;
    }

    .header .search-container input {
        width: 100%;
        padding: 5px;
    }

    .header .search-container .fa {
        margin: 0 20px;
        cursor: pointer;
    }

    .header .menu {
        display: flex;
        align-items: center;
    }

    .header .menu a {
        margin-left: 10px;
        text-decoration: none;
        color: black;
        display: flex;
        align-items: center;
    }

    .header .menu a .fa {
        margin-right: 5px;
    }

    #menu-sidebar {
        display: none;
        position: absolute;
        top: 50px;
        left: 100px;
        z-index: 1000;
        background-color: #FB6F6F;
        border: 1px solid black;
        width: 200px;
        padding: 20px;
        border-radius: 5px;
    }

    #menu-sidebar.active {
        display: block;
    }

    .button-menu,
    .menu-item {
        background-color: #FB6F6F;
        width: 180px;
        height: 30px;
        font-weight: bold;
        margin: 5px 10px;
        cursor: pointer;
        border: none;
        text-align: center;
    }

    .button-menu:hover,
    .menu-item:hover {
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.25);
        border-bottom: 3px solid black;
    }

    .button-menu > a,
    .menu-item > a {
        display: block;
        padding: 4px;
        text-decoration: none;
        color: black;
    }

    .footer {
        background-color: #fff;
        padding: 20px;
        text-align: center;
    }

    .footer button {
        background-color: #ffcc00;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }
    #button-logout{
        display: none;
        border: 1px solid black;
        border-radius: 5px;
    }
    #logo{
        margin-left: 30px;
        text-decoration: none;
        color: black;
        font-size: 30px;
        font-weight: bold;
        cursor: pointer;
    }
    #logo p{
        margin: 0;
    }
    #logoN5{
        width: 200px;
        height: 200px;
    }
    #logowellcome{
        height: 200px;
        width: 200px;
    }
    #button-login{
        border: 1px solid black;
        border-radius: 5px;
    }
    /* midder */
    .midder {
        display: flex;
        margin: 20px;
    }

    .midder .left,
    .midder .right {
        flex: 1;
        margin: 10px;
    }

    .left img {
        max-width: 100%;
        border-radius: 10px;
    }

    .right h2 {
        margin-bottom: 10px;
    }

    .right p {
        margin-bottom: 20px;
    }

    .buttons {
        margin-top: 20px;
    }

    .buttons button {
        padding: 10px 20px;
        margin-right: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .buttons .cart-btn {
        background-color: #ffcc00;
    }

    .buttons .buy-btn {
        background-color: #FB6F6F;
        color: white;
    }

    .description > h3{
        margin: 0;
        border-bottom: 1px solid black;
    }

    .description{
        margin-top: 20px;
        margin-left: 15%;
        display: inline-block;
        width: auto;
        max-width: 400px;
        height: auto;
        border: 1px solid black;
        border-radius: 5px;
        padding: 5px;
    }   

    .specifications {
        display: flex;
        justify-content: flex-end; /* Căn chỉnh nội dung trong .specifications sang bên phải */
        margin-top: 20px;
        margin-left: 30%;
        display: inline-block;
        width: auto;
        max-width: 400px;
        height: auto;
        border: 1px solid black;
        border-radius: 5px;
        padding: 5px;
    }

    .specifications p {
        font-weight: bold;
        font-size: 1.17em;
        border-bottom: 1px solid black;
    }


    .image-slider {
        position: relative;
        width: 400px; /* Giới hạn chiều rộng */
        height: 400px; /* Giới hạn chiều cao */
        overflow: hidden;
        margin: 0 auto; /* Căn giữa */
        border-radius: 10px; /* Bo góc */
        background-color: #f9f9f9; /* Màu nền khung hình */
    }

    .slides {
        display: flex;
        transition: transform 0.5s ease-in-out;
        height: 100%; /* Đảm bảo toàn bộ chiều cao */
    }

    .slides img {
        width: 400px; /* Đảm bảo chiều rộng phù hợp khung */
        height: 400px; /* Đảm bảo chiều cao phù hợp khung */
        object-fit: cover; /* Cắt ảnh để phù hợp với khung */
        border-radius: 10px; /* Bo góc hình ảnh */
    }

    button.prev-btn,
    button.next-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(0, 0, 0, 0.5);
        border: none;
        color: white;
        font-size: 24px;
        padding: 10px;
        cursor: pointer;
        z-index: 1000;
        border-radius: 50%; /* Tạo nút tròn */
    }

    button.prev-btn {
        left: 10px;
    }

    button.next-btn {
        right: 10px;
    }

    button.prev-btn:hover,
    button.next-btn:hover {
        background-color: rgba(0, 0, 0, 0.8);
    }

    #container{
        margin: 0 30px;
        display: block;
        width: auto;
        height: auto;
        background-color:   #F3F3F3;
        margin: 0;
        padding: 0;
        padding: 10px 0;
    }

    p{
        margin: 0;
    }

    h3{
        margin-bottom: 10px;
    }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <a href="../test.php" id="logo"><p>CSS</p></a>
        <div class="search-container">
            <i class="fa fa-bars" id="sidebar" style="font-size: 30px; cursor: pointer;"></i>
            <input type="text" id="searchbar" placeholder="Tìm kiếm sản phẩm trên hệ thống">
            <i class="fa fa-bell" style="font-size: 30px;"></i>
        </div>
        <div class="menu">
            <a href="#"><i class="fa-solid fa-cart-shopping" style="font-size: 20px;"></i> Giỏ hàng</a>
            <a href="./B2/thongtinuser.php"><i class="fa-solid fa-user" style="font-size: 20px;"></i> Thông tin cá nhân</a>
        </div>
    </div>

    <!-- Menu Sidebar -->
    <div id="menu-sidebar">
        <div id="profile">
            <?php if (isset($_SESSION['login_username'])): ?>
                <p style="text-align: center;">Người dùng:</p>
                <a href="./null.php" style="border-left: 3px solid black; border-right: 3px solid black; text-decoration: none; color: black; display: flex; justify-content: center;">
                    <?= htmlspecialchars($_SESSION['login_username']); ?>
                </a>
            <?php endif; ?>
        </div>
        <!-- Các nút menu -->
        <button class="menu-item"><a href="#">Switch to Seller</a></button>
        <!-- Thêm các mục khác -->
        <button class="button-menu" id="button-logout"><a href="./del_sessionp2.php">Logout</a></button>
    </div>

    <div id="container">
        <?php if ($product): ?>
            <!-- Nội dung sản phẩm -->
            <div class="midder">
                <div class="left">
                    <div class="image-slider">
                        <div class="slides">
                            <?php
                            $imagePaths = explode(',', $product['image_path']);
                            foreach ($imagePaths as $path):
                                $imagePath = '../' . trim(htmlspecialchars($path));
                                if (file_exists($imagePath)) { 
                                    echo "<img src='{$imagePath}' alt='Ảnh sản phẩm'>";
                                } else {
                                    echo "<p>Không tìm thấy ảnh: {$imagePath}</p>";
                                }
                            endforeach;
                            ?>
                        </div>
                        <button class="prev-btn">&#10094;</button>
                        <button class="next-btn">&#10095;</button>
                    </div>
                </div>

                <div class="right">
                    <h2><?= htmlspecialchars($product['product_name']); ?></h2>
                    <p><strong>Giá: </strong><?= number_format($product['price'], 0, ".", ".") . " VNĐ"; ?></p>
                    <div class="buttons">
                        <button class="cart-btn">Thêm vào giỏ hàng</button>
                        <button class="buy-btn">Mua ngay</button>
                    </div>
                </div>
            </div>

            <div class="description">
                <h3>Mô tả sản phẩm:</h3>
                <p><?= nl2br(htmlspecialchars($product['description'])); ?></p>
            </div>
            <div class="specifications">
                <p>Thông số kỹ thuật:</p>
            </div>
        <?php else: ?>
            <!-- Thông báo lỗi -->
            <p><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>
    </div>

    <div class="footer">
        <img src="../Image/CSS.png" alt="logoNhom5.png" id="logoN5">
        <p>Chào mừng bạn đến với hệ thống mua bán điện thoại cũ của nhóm chúng tôi</p>
        <p>Bán hàng tốt, Mua hàng ngon, Trao trọn giá trị!</p>
        <p>Cần hỗ trợ về vấn đề khác thì hãy bấm nút phía dưới</p>
        <button><i class="fa-solid fa-handshake"></i> Hỗ trợ ngay</button>
    </div>

    <script>
        document.getElementById('sidebar').addEventListener('click', () => {
            document.getElementById('menu-sidebar').classList.toggle('active');
        });

        const slides = document.querySelector('.slides');
        const images = document.querySelectorAll('.slides img');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');
        
        let currentIndex = 0;

        function updateSliderPosition() {
            slides.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateSliderPosition();
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % images.length;
            updateSliderPosition();
        });
    </script>
</body>
</html>
