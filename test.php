<?php
session_start();
ob_start();
$ss = isset($_SESSION['login_username']) ? $_SESSION['login_username'] : null;
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ Hệ Thống Mua Bán Điện Thoại </title>
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
            margin: 0 20px; /* Điều chỉnh khoảng cách giữa các biểu tượng và thanh tìm kiếm */
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
            padding-right: 20px;
        }
        .header .menu a .fa {
            margin-right: 5px;
        }
        .main-banner {
            background-color: #fff;
            padding: 20px;
            text-align: center;
        }
        .main-banner img {
            width: 100%;
            max-width: 600px;
        }
        .main-banner h1 {
            color: red;
            font-size: 24px;
        }
        .main-banner p {
            font-size: 18px;
        }
        .main-banner button {
            background-color: #ffcc00;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .categories {
            display: flex;
            justify-content: space-around;
            background-color: #fff;
            padding: 20px;
        }
        .categories div {
            text-align: center;
        }
        .container {
            padding: 0 30px;
            display: flex;
            flex-wrap: wrap;
        }
        .item {
            background-color: #fff;
            padding: 10px;
            margin: 10px 10px 10px 0;
            border-radius: 5px;
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: center;
            height: 200px;
            width: 23%; /* Điều chỉnh chiều rộng của mỗi bài đăng, đảm bảo mỗi hàng có 4 bài */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px; /* Khoảng cách dưới mỗi bài đăng */
        }
        @media (max-width: 1200px) {
            .item {
                width: 30%; /* Nếu màn hình nhỏ, mỗi hàng có thể chứa 3 bài */
            }
        }

        @media (max-width: 768px) {
            .item {
                width: 45%; /* Nếu màn hình rất nhỏ, mỗi hàng có thể chứa 2 bài */
            }
        }

        @media (max-width: 480px) {
            .item {
                width: 100%; /* Màn hình nhỏ, mỗi hàng chỉ có 1 bài */
            }
        }
        .item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-right: 10px;
        }
        .item .details {
            flex-grow: 1;
        }
        .item .details h3 {
            margin: 0;
            font-size: 16px;
        }
        .item .details p {
            margin: 5px 0;
            color: #888;
        }
        .item .details .price {
            color: red;
            font-weight: bold;
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

        .fa-cart-shopping:before, .fa-shopping-cart:before {
            content: "\f07a";
            margin-right: 10px;
        }
        .fa-user:before {
            content: "\f007";
            margin-right: 10px;
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
        /*menu*/
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
        .button-menu{
            background-color: #FB6F6F;
            width: 180px; 
            height: 30px; 
            margin-left: 10px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .button-menu:hover{
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.25);
        }
        #button-logout{
            display: none;
        }
        .menu-item{
            background-color: #FB6F6F;
            width: 180px; 
            height: 30px; 
            font-weight: bold;
            border: none;
            margin-left: 10px;
            margin-top: 5px;
            cursor: pointer;
        }
        .menu-item:hover{
            border-bottom: 3px solid black;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.25);
        }

        .button-menu > a,
        .menu-item > a {
            display: block;
            padding: 4px;
        }

        .item {
            background-color: #fff; /* Màu nền của mỗi bài đăng */
            padding: 10px; /* Khoảng cách bên trong */
            margin: 5px; /* Khoảng cách giữa các bài đăng */
            border-radius: 10px; /* Bo tròn góc */
            display: flex; /* Kích hoạt Flexbox */
            flex-direction: column; /* Sắp xếp nội dung trong item theo chiều dọc */
            align-items: center; /* Căn giữa nội dung theo chiều ngang */
            justify-content: center; /* Căn giữa nội dung theo chiều dọc */
            height: 200px; /* Chiều cao của bài đăng */
            width: 150px; /* Chiều rộng của bài đăng */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Hiệu ứng đổ bóng */
        }

        .item .details h3 {
            margin: 0;
            font-size: 16px;
            text-align: center;
        }

        .item img {
            width: 100%; /* Chiều rộng ảnh chiếm toàn bộ chiều rộng bài đăng */
            max-height: 140px; /* Chiều cao cố định cho ảnh */
            object-fit: cover; /* Đảm bảo ảnh vừa khung và không bị méo */
            border-radius: 8px; /* Bo tròn góc ảnh */
            margin-bottom: 10px; /* Khoảng cách giữa ảnh và nội dung khác */
        }

        .item p {
            margin: 0; /* Loại bỏ khoảng cách mặc định của thẻ <p> */
            font-size: 14px; /* Kích thước chữ */
            text-align: center; /* Căn giữa chữ */
            color: #333; /* Màu chữ */
        }

        .item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .categories-items{
            display: flex;
            height: 50px;
            width: 100px;
            font-size: 20px;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            background-color: #FB6F6F;
            border: 1px solid #fff;
            border-radius: 5px;
            cursor: pointer;
            padding: 0;
        }

        .categories-items > a{
            text-decoration: none;
            color: #333;
        }

        .categories-items:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="./test.php" id="logo"><p>CSS</p></a>
        <div class="search-container">
            <i class="fa fa-bars" id="sidebar" style="font-size: 30px; cursor: pointer;"></i>
            <input type="text" id="searchbar" placeholder="Tìm kiếm sản phẩm trên hệ thống">
            <i class="fa fa-bell" style="font-size: 30px;"></i>
        </div>
        <div class="menu">
            <a href="#"><i class="fa-solid fa-cart-shopping" style="font-size: 20px;"></i> Giỏ hàng</a>
            <a href="#"><i class="fa-solid fa-pen-to-square" style="font-size: 20px;"></i>Bán hàng</a>
        </div>
    </div>
    
    <div id="menu-sidebar">
        <div id="profile">
            <button class="button-menu" id="button-login" ><a href="./B1/login.php" style="text-decoration: none; color: black;">Login</a></button>
            <?php
                if(isset($_SESSION['login_username'])){
                    echo "<p style='
                            text-align: center;
                          '>Người dùng:</p>";
                    echo "<a href='./null.php' style='
                            border-left: 3px solid black;
                            border-right: 3px solid black;
                            text-decoration: none;
                            color: black;
                            display: flex;
                            justify-content: center;
                    '>". htmlspecialchars($_SESSION['login_username']) ."</a>";
                }
            ?>
            
        </div>
            <button class="menu-item"><a href="./B2/thongtinuser.php" style="text-decoration: none; color: black;">Thông tin người dùng</a></button>
            <button class="menu-item"><a href="#" style="text-decoration: none; color: black;">đăng sản phẩm</a></button>
            <button class="menu-item"><a href="#" style="text-decoration: none; color: black;">Iphone</a></button>
            <button class="menu-item"><a href="#" style="text-decoration: none; color: black;">Laptop</a></button>
            <button class="menu-item"><a href="#" style="text-decoration: none; color: black;">Android</a></button>
            <button class="menu-item"><a href="#" style="text-decoration: none; color: black;">Ipad</a></button>
            <button class="menu-item"><a href="#" style="text-decoration: none; color: black;">Macbook</a></button>
            <button class="button-menu" id="button-logout"><a href="./B1/del_session.php" style="text-decoration: none; color: black;">Logout</a></button>
    </div>

    <div class="main-banner">
        <img src="./Icon/wellcome.png" alt="Logo wellcome" id="logowellcome">
        <h1>Cellphone Seller System xin chào quý khách</h1>
        <p>Cùng tìm hiểu các chức năng có trong hệ thống chúng tôi!</p>
        <button style="font-weight: bold;">Tìm hiểu ngay!</button>
    </div>

    <div class="categories">
        <div>
            <p class="categories-items"><a href="">Apple</a></p>
        </div>
        <div>
            <p class="categories-items"><a href="#">Samsung</a></p>
        </div>
        <div>           
            <p class="categories-items"><a href="#">Oppo</a></p>
        </div>
        <div>           
            <p class="categories-items"><a href="#">Vivo</a></p>
        </div>
        <div>
            <p class="categories-items"><a href="#">Xiaomi</a></p>
        </div>
        <div>
            <p class="categories-items"><a href="#">Realme</a></p>
        </div>
        <div>
            <p class="categories-items"><a href="#">Other</a></p>
        </div>
    </div>

    <div class="container">
        <?php
        // Kết nối tới cơ sở dữ liệu
        include './connect/connect.php';
        $conn = connect_db();

        // Truy vấn dữ liệu từ bảng products
        $sql = "SELECT id, product_name, price, image_path FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Hiển thị từng sản phẩm
            while ($row = $result->fetch_assoc()) {
                echo '<div class="item">';
                    echo '<a href="./B2/view_product.php?id=' . $row['id'] . '" 
                        style="text-decoration: none; color: black;"
                        class="product_items">';

                    // Kiểm tra nếu image_path có chứa nhiều ảnh (tách bằng dấu phẩy)
                    $imagePaths = explode(',', $row['image_path']); // Tách chuỗi ảnh

                    // Lấy ảnh đầu tiên
                    $firstImage = $imagePaths[0];

                    // Nếu image_path đã bao gồm đường dẫn, giữ nguyên. Nếu không, thêm ./uploads/
                    $imagePath = (strpos($firstImage, 'uploads/') !== false)
                    ? htmlspecialchars($firstImage) // Đường dẫn đầy đủ, giữ nguyên
                    : './uploads/' . htmlspecialchars($firstImage); // Chỉ có tên tệp, thêm 'uploads/'

                    // Tạo đường dẫn đầy đủ để kiểm tra file tồn tại
                    $fullPath = (strpos($firstImage, 'uploads/') !== false)
                    ? __DIR__ . '/' . htmlspecialchars($firstImage) // Đường dẫn đầy đủ
                    : __DIR__ . '/uploads/' . htmlspecialchars($firstImage); // Thêm 'uploads/'

                    // Kiểm tra file tồn tại
                    if (file_exists($fullPath)) {
                        echo '<img src="' . $imagePath . '" 
                            alt="Ảnh sản phẩm" 
                            style="max-width: 100%; height: auto;">';
                    } else {
                        echo '<img src="./uploads/default.jpg" 
                            alt="Ảnh mặc định" 
                            style="max-width: 100%; height: auto;">';
                    }

                    echo '<div class="details">';
                    echo '<h3>' . htmlspecialchars($row['product_name']) . '</h3>';
                    echo '<p class="price">' . number_format($row['price'], 0, ".", ".") . ' VNĐ</p>';
                    echo '</div>';
                    echo '</a>';
                echo '</div>';
            }
        } else {
            echo '<p>Không có sản phẩm nào được tìm thấy.</p>';
        }

        $conn->close();
    ?>
    </div>

    <div class="footer">
        <img src="./Image/CSS.png" alt="logoNhom5.png" id="logoN5">
        <p>Chào mừng bạn đến với hệ thống mua bán điện thoại cũ của nhóm chúng tôi</p>
        <p>Bán hàng tốt, Mua hàng ngon, Trao trọn giá trị!</p>
        <p>Cần hỗ trợ về vấn đề khác thì hãy bấm nút phía dưới</p>
        <button><i class="fa-solid fa-handshake"></i> Hỗ trợ ngay</button>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const menusidebar = document.getElementById('menu-sidebar');

        const on = <?php echo json_encode($ss); ?>;
        window.onload = function() {
            if (on) {
                document.getElementById('button-login').style.display = 'none';
                document.getElementById('button-logout').style.display = 'inline-block';
            } else {
                document.getElementById('button-login').style.display = 'inline-block';
                document.getElementById('button-logout').style.display = 'none';
            }
        };

        sidebar.addEventListener('click', () => {
            menusidebar.classList.toggle('active');
        });   
    </script>


</body>
</html>