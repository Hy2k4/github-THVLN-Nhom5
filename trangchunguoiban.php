<?php
session_start();
ob_start();

if(!isset($_SESSION['login_username'])){
    header('Location: ./test.php');
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #d9534f;
            color: white;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header .logo {
            display: flex;
            align-items: center;
            gap: 15px; /* Khoảng cách giữa các biểu tượng */
            font-size: 24px;
            font-weight: bold;
        }
        .header .search-bar {
            display: flex;
            align-items: center;
            flex-grow: 1;
            margin: 0 20px;
        }
        .header .search-bar input {
            width: 100%;
            padding: 5px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
        }
        .header .icons {
            display: flex;
            align-items: center;
            gap: 15px; /* Khoảng cách giữa các biểu tượng */
        }
        .header .icons .icon {
            font-size: 20px;
            cursor: pointer;
        }
        .content {
            padding: 20px;
        }
        .content .filters {
            display: flex;
            justify-content: center;
            gap: 10px; /* Đặt khoảng cách giữa các nút */
            margin-bottom: 20px;
        }
        .content .filters button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
            position: relative;
        }
        .content .filters button i {
            font-size: 12px;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        .content .product-list {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .content .product-list .product {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .content .product-list .product:last-child {
            border-bottom: none;
        }
        .content .product-list .product img {
            width: 50px;
            height: 50px;
            margin-right: 20px;
        }
        .content .product-list .product .details {
            flex-grow: 1;
        }
        .content .product-list .product .details .name {
            font-size: 18px;
            font-weight: bold;
        }
        .content .product-list .product .details .price {
            font-size: 16px;
            color: #d9534f;
        }
        .product-checkbox {
            margin-right: 10px;
            cursor: pointer;
        }
        .actions {
            position: fixed;
            right: 20px;
            bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .actions button {
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .actions .add {
            background-color: #5cb85c;
            color: white;
        }
        .actions .edit {
            background-color: #f0ad4e;
            color: white;
        }
        .actions .delete {
            background-color: #d9534f;
            color: white;
        }
        .actions .chat {
            background-color: #5bc0de;
            color: white;
        }
    /* CSS đã di chuyển từ test.php */
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
        max-width: 150px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin: 10px;
        text-align: center;
    }
    .item:hover {
        transform: scale(1.05);
    }
    .item.selected {
        background-color: #d9edf7; /* Đổi màu nền cho bài đăng được chọn */
        border: 2px solid #5bc0de; /* Đường viền cho bài đăng được chọn */
    }
    .details{
        max-height: 60px;

    }
    @media (max-width: 1200px) {
        .item {
            width: 30%;
        }
    }
    @media (max-width: 768px) {
        .item {
            width: 45%;
        }
    }
    @media (max-width: 480px) {
        .item {
            width: 100%;
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
    .details > h3{
        text-align: center;
    }
    .product-checkbox{
        margin-left: 80%;
        margin-bottom: 20%;
        display: none;
    }
    
    </style>
</head>
<body>
     <div class="header">
        <div class="logo">
            <i class="fas fa-bars icon"></i>
            <span>CSS cho Người Bán</span>
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Tìm kiếm...">
        </div>
        <div class="icons">
            <i class="fas fa-history icon" onclick="redirectToTBLS()"></i>
            <i class="fas fa-bell icon"></i>
            <i class="fas fa-sync-alt icon" onclick="redirectToTest()"></i>
        </div>
    </div>
    <script>
        function redirectToTBLS() {
            window.location.href = 'TBLS.php';
        }

        function redirectToTest() {
            window.location.href = 'test.php';
        }
    </script>
    <div class="content">
        <div class="filters">
            <div class="dropdown">
                <button><i class="fas fa-caret-down"></i> A → Z</button>
                <div class="dropdown-content">
                    <a href="#">A-Z</a>
                    <a href="#">Z-A</a>
                </div>
            </div>
            <div class="dropdown">
                <button><i class="fas fa-caret-down"></i> Condition</button>
                <div class="dropdown-content">
                    <a href="#">New</a>
                    <a href="#">Used</a>
                </div>
            </div>
            <div class="dropdown">
                <button><i class="fas fa-caret-down"></i> Price</button>
                <div class="dropdown-content">
                    <a href="#">Low to High</a>
                    <a href="#">High to Low</a>
                </div>
            </div>
            <div class="dropdown">
                <button><i class="fas fa-caret-down"></i> Filter</button>
                <div class="dropdown-content">
                    <a href="#">All</a>
                    <a href="#">Available</a>
                    <a href="#">Sold</a>
                </div>
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
                        echo '<input type="checkbox" class="product-checkbox" name="selected_products[]" value="' . $row['id'] . '">';
                
                        $imagePaths = explode(',', $row['image_path']);
                        $firstImage = $imagePaths[0];
                        $imagePath = (strpos($firstImage, 'uploads/') !== false)
                            ? htmlspecialchars($firstImage)
                            : './uploads/' . htmlspecialchars($firstImage);
                        $fullPath = (strpos($firstImage, 'uploads/') !== false)
                            ? __DIR__ . '/' . htmlspecialchars($firstImage)
                            : __DIR__ . './uploads/' . htmlspecialchars($firstImage);
                
                        if (file_exists($fullPath)) {
                            echo '<img src="' . $imagePath . '" 
                                alt="Ảnh sản phẩm" 
                                style="max-width: 100%; height: auto;">';
                        } else {
                            echo '<img src="../uploads/default.jpg" 
                                alt="Ảnh mặc định" 
                                style="max-width: 100%; height: auto;">';
                        }
                
                        echo '<div class="details">';
                        echo '<h3>' . htmlspecialchars($row['product_name']) . '</h3>';
                        echo '<p class="price">' . number_format($row['price'], 0, ".", ".") . ' VNĐ</p>';
                        echo '<a href="./B2/view_product.php?id=' . $row['id'] . '">Xem chi tiết</a>';
                        echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>Không có sản phẩm nào được tìm thấy.</p>';
            }

            $conn->close();
        ?>
    </div>



    </div>
    <div class="actions">
       
        <button class="edit"><i class="fas fa-edit"></i></button>
        <button class="delete"><i class="fas fa-trash"></i></button>
        <button class="chat"><i class="fas fa-comment-alt"></i></button>
    </div>

    <script>
        // Lấy tất cả các bài đăng
        const items = document.querySelectorAll('.item');

        items.forEach(item => {
            item.addEventListener('click', () => {
                // Tìm checkbox bên trong bài đăng
                const checkbox = item.querySelector('.product-checkbox');
                
                // Thay đổi trạng thái checkbox
                checkbox.checked = !checkbox.checked;
                
                // Thay đổi giao diện bài đăng
                if (checkbox.checked) {
                    item.classList.add('selected'); // Thêm class nếu được chọn
                } else {
                    item.classList.remove('selected'); // Xóa class nếu bỏ chọn
                }
            });
        });
    </script>
</body>
</html>
