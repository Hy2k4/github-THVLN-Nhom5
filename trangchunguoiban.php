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
            margin-left: 10%;
        }
        .header .search-bar {
            display: flex;
            align-items: center;
            flex-grow: 1;
            margin: 0 20px;
            justify-content: center;
        }
        .header .search-bar input {
            min-width: 250px;
            width: auto;
            padding: 5px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
        }
        .header .icons {
            display: flex;
            align-items: center;
            gap: 30px; /* Khoảng cách giữa các biểu tượng */
            margin-right: 10%;
        }
        .header .icons .icon {
            font-size: 20px;
            cursor: pointer;
        }
        .content {
            padding: 20px;
        }
        .filters form {
            display: flex;
            justify-content: center;
            gap: 30px;
        }
        .filters button {
            padding: 10px 20px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .filters button:hover {
            background-color: #e0e0e0;
        }
        .search-bar {
            position: relative;
        }
        .search-bar input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
        }
        .search-bar button {
            position: relative;
            padding: 5px 10px;
            cursor: pointer;
            margin-left: 5px;
            border: 1px solid black;
            border-radius: 5px;
            font-weight: bold;
        }
        .search-bar button:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
            opacity: 0.8;
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
        .actions > a{
            text-decoration: none;
        }
        .actions .add:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
            opacity: 0.8;
        }
        .actions .edit:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
            opacity: 0.8;
        }
        .actions .delete:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
            opacity: 0.8;
        }
        .actions .chat:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
            opacity: 0.8;
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
            <a href="trangchunguoiban.php" style="
                                            text-decoration: none;
                                            color: white;
                                            ">
                <span>CSS for Seller</span>
            </a>
        </div>
        <div class="search-bar" style="max-width: 1000px;">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search here...">
                <button type="submit" id="search-btn">Find</button>
            </form>
        </div>
        <div class="icons">
            <i class="fas fa-history icon" onclick="redirectToTBLS()"></i>
            <i class="fas fa-sync-alt icon" onclick="redirectToTest()"></i>
        </div>
    </div>

    <script>
        function redirectToTBLS() {
            window.location.href = './B3/TBLS.php';
        }

        function redirectToTest() {
            window.location.href = 'test.php';
        }
    </script>

    <div class="content">
        <!-- Form chứa các nút để gửi tham số sắp xếp -->
        <div class="filters">
            <form method="GET" action="">
                <button type="submit" name="sort" value="az">A → Z</button>
                <button type="submit" name="sort" value="za">Z → A</button>
                <button type="submit" name="sort" value="low">Low to High</button>
                <button type="submit" name="sort" value="high">High to Low</button>
            </form>
        </div>

        <form method="POST" action="">
            <div class="container">
                <?php
                // Kết nối tới cơ sở dữ liệu
                include './connect/connect.php';
                $conn = connect_db();

                // Xử lý tìm kiếm
                $search = isset($_GET['search']) ? trim($_GET['search']) : '';
                $searchQuery = $search !== '' ? "WHERE product_name LIKE '%" . $conn->real_escape_string($search) . "%'" : '';

                // Xử lý tham số sắp xếp
                $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
                $orderBy = match ($sort) {
                    'az' => "ORDER BY product_name ASC",
                    'za' => "ORDER BY product_name DESC",
                    'low' => "ORDER BY price ASC",
                    'high' => "ORDER BY price DESC",
                    default => "",
                };

                $sql = "SELECT id, product_name, price, image_path FROM products $searchQuery $orderBy";
                $result = $conn->query($sql);

                // Xử lý xóa sản phẩm khi nhấn nút Delete
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_products'])) {
                    $selectedIds = $_POST['selected_products'];
                    $idList = implode(',', array_map('intval', $selectedIds)); // Chuyển đổi các ID sang kiểu số nguyên
                    
                    // Xóa các sản phẩm đã chọn
                    $deleteSql = "DELETE FROM products WHERE id IN ($idList)";
                    if ($conn->query($deleteSql) === TRUE) {
                        //echo 'Đã xóa các sản phẩm được chọn thành công.';
                        echo '<script>
                                alert("Please select at least one product to order!");
                            </script>';
                    } else {
                        echo 'Errors when deleting products: ' . $conn->error;
                    }
                }

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="item">';
                        echo '<input type="checkbox" class="product-checkbox" name="selected_products[]" value="' . $row['id'] . '">';

                        // Ensure $row['image_path'] is a string before using explode
                        if (is_string($row['image_path']) && strpos($row['image_path'], ',') !== false) {
                            $imagePaths = explode(',', $row['image_path']); // Split by comma if it's a valid string
                        } else {
                            // If not a string, treat $row['image_path'] as an array with one element
                            $imagePaths = (array) $row['image_path'];
                        }

                        // Get the first image
                        $firstImage = $imagePaths[0];

                        // Check if the image path already includes 'uploads/'
                        $imagePath = (strpos($firstImage, 'uploads/') !== false)
                            ? htmlspecialchars($firstImage)
                            : './uploads/' . htmlspecialchars($firstImage);

                        // Create the full path to the image file
                        $fullPath = __DIR__ . '/' . htmlspecialchars($imagePath);

                        // Check if the file exists
                        if (file_exists($fullPath)) {
                            echo '<img src="' . $imagePath . '" alt="Ảnh sản phẩm" style="max-width: 100%; height: auto;">';
                        } else {
                            echo '<img src="./uploads/default.jpg" alt="Ảnh mặc định" style="max-width: 100%; height: auto;">';
                        }

                        echo '<div class="details">';
                        echo '<h3>' . htmlspecialchars($row['product_name']) . '</h3>';
                        echo '<p class="price">' . number_format($row['price'], 0, ".", ".") . ' VNĐ</p>';
                        echo '<a href="./B2/view_product.php?id=' . $row['id'] . '">View details</a>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No products were found.</p>';
                }

                $conn->close();
                ?>
            </div>    
            <!-- Form chứa chức năng -->
            <div class="actions">
                <a href="./B2/baidangmoi.php"><button type="button" class="add"><i class="fa-solid fa-plus"></i></button></a>
                <button type="submit" class="delete"><i class="fas fa-trash"></i></button>
                <button type="button" class="edit"><i class="fas fa-edit"></i></button>
                <a href="./chat.php"><button type="button" class="chat"><i class="fas fa-comment-alt"></i></button></a>
            </div>
        </form>


    <script>
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
        //----------------------------------------------------------
        document.querySelector('.edit').addEventListener('click', function () {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked'); // Lấy checkbox được chọn
            if (checkboxes.length === 0) {
                alert("Please select a post to edit.");
            } else if (checkboxes.length > 1) {
                alert("Only one post can be edited at a time.");
            } else {
                const selectedId = checkboxes[0].value; // Lấy ID của bài đăng
                window.location.href = `./edit_post.php?id=${selectedId}`; // Chuyển hướng tới trang chỉnh sửa
            }
        });
        //----------------------------------------------------------
        document.querySelector('.edit').addEventListener('click', function () {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            
            if (checkboxes.length === 0) {
                alert("Please select a post to edit.");
            } else if (checkboxes.length > 1) {
                alert("Only one post can be edited at a time.");
            } else {
                const selectedId = checkboxes[0].value;

                // Call history.php to log the action
                fetch('./B3/history.php', { // URL của file history.php
                    method: 'POST',
                    body: new URLSearchParams({
                        action: 'Edit a post',
                        detail: 'successful'
                    })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Log history entry result
                })
                .catch(error => {
                    console.error("Error logging history:", error);
                });

                window.location.href = `edit_post.php?id=${selectedId}`; // Đúng cú pháp
            }
        });

        //------------------------------------------------------------------------------------
        document.querySelector('.add').addEventListener('click', function () {
            // Log action for creating a new product
            fetch(' ./B3/history.php', {
                method: 'POST',
                body: new URLSearchParams({
                    action: 'Create a post',
                    detail: 'successful'
                })
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // Log history entry result
            })
            .catch(error => {
                console.error("Error logging history:", error);
            });
        });
        //------------------------------------------------------------------------------------
        document.querySelector('.delete').addEventListener('click', function () {
            const checkboxes = document.querySelectorAll('.product-checkbox:checked');
            
            if (checkboxes.length === 0) {
                alert("Please select a post to delete.");
            } else {
                const selectedIds = [];
                checkboxes.forEach(checkbox => selectedIds.push(checkbox.value));

                // Gửi thông tin ghi lại hành động xóa vào history.php
                fetch('./B3/history.php', {
                    method: 'POST',
                    body: new URLSearchParams({
                        action: 'Delete a post',
                        detail: 'successful'
                    })
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data); // Ghi lại kết quả lịch sử
                })
                .catch(error => {
                    console.error("Error recording history:", error);
                });

                // Tiến hành xóa sản phẩm
                const idList = selectedIds.join(',');

                // Tạo form ẩn để gửi POST request với danh sách sản phẩm được chọn
                const deleteForm = document.createElement('form');
                deleteForm.method = 'POST';
                deleteForm.action = 'xoa_san_pham.php'; // Chỉ rõ trang xử lý xóa sản phẩm

                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'selected_products'; // Đảm bảo rằng server sẽ nhận tên này
                input.value = idList;

                deleteForm.appendChild(input);
                document.body.appendChild(deleteForm);

                // Gửi form
                deleteForm.submit();
            }
        });

    </script>
</body>
</html>
