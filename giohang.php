<?php 
session_start();
include './connect/connect.php'; // Kết nối với cơ sở dữ liệu
$conn = connect_db();

if (!isset($_SESSION['login_username'])) {
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header("Location: ./test.php");
    exit;
}

$username = $_SESSION['login_username'];

// Truy vấn các sản phẩm trong giỏ hàng từ bảng giohang và products
$query = "SELECT giohang.GioHangID, products.id AS product_id, products.product_name, products.price, products.image_path, giohang.quantity
          FROM giohang
          INNER JOIN products ON giohang.product_id = products.id
          WHERE giohang.username = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
}

if (empty($cart_items)) {
    echo "<p>Your shopping cart is empty.</p>";
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Các styles không thay đổi */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color:  #ff6f6f;
            padding: 10px;
            display: flex;
            justify-content: space-around;
            align-items: center;
            color: white;
        }
        .header .logo {
            font-size: 30px;
            font-weight: bold;
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
        }
        .product {
            display: flex;
            align-items: center;
            padding: 10px;
            background-color: white;
            border-bottom: 1px solid #ddd;
            width: 1000px;
            height: auto;
        }
        .product img {
            width: 100px;
            height: 100px;
            margin-left: 40px;
        }
        .product .details {
            flex-grow: 1;
        }
        .product .details h4 {
            margin: 0;
            font-size: 18px;
            margin-left: 10%;
        }
        .product .details p {
            margin: 5px 0;
            color: #888;
        }
        .product .price {
            font-size: 18px;
            color: red;
            margin-right: 10%;
        }
        .product.selected {
            background-color: #f0f0f0;
        }
        .product input[type="checkbox"]{
            margin-left: 5%;
        }
        .footer {
            background-color: white;
            padding: 0 10px;
            position: fixed;
            bottom: 0;
            max-width: 1000px;
            width: 100%;
            height: 80px;
            display: flex;
            align-items: center;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
            justify-content: space-between;
        }
        .footer .total {
            margin-left: 50%;
            font-size: 18px;
            font-weight: bold;
        }
        .footer .buy-now {
            background-color: green;
            color: white;
            padding: 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            height: 80px;
            width: 150px;
        }
        .buy-now:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
            opacity: 0.8;
        }
        .footer .select-all {
            display: flex;
            align-items: center;
            margin-left: 5%;
        }
        .footer .select-all input {
            margin-right: 5px;
        }
        .product input[type="checkbox"] {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }
        #midder{
            display: flex;
            width: 100%;
            height: 100%;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">CSS - Cellphone Seller System</div>
        <div class="icons">
            <button><a href="./test.php"><i class="fas fa-arrow-left"></i>Turn back</a></button>
        </div>
    </div>

    <div id="midder">
        <div class="container">
            <?php
            if (empty($cart_items)) {
                echo "<p>Your shopping cart is empty.</p>";
            } else {
                foreach ($cart_items as $item) {
                    // Đảm bảo image_path là một chuỗi trước khi xử lý
                    if (is_string($item['image_path']) && strpos($item['image_path'], ',') !== false) {
                        $imagePaths = explode(',', $item['image_path']); // Tách chuỗi nếu có dấu phẩy
                    } else {
                        // Nếu không phải chuỗi, coi như image_path là mảng chứa 1 phần tử
                        $imagePaths = (array) $item['image_path'];
                    }

                    // Lấy ảnh đầu tiên
                    $firstImage = $imagePaths[0];

                    // Kiểm tra xem đường dẫn ảnh đã có 'uploads/' chưa
                    $imagePath = (strpos($firstImage, 'uploads/') !== false)
                        ? htmlspecialchars($firstImage)
                        : './uploads/' . htmlspecialchars($firstImage);

                    // Tạo đường dẫn đầy đủ tới ảnh
                    $fullPath = __DIR__ . '/' . htmlspecialchars($imagePath);

                    // Kiểm tra file có tồn tại không
                    if (file_exists($fullPath)) {
                        echo '<div class="product">
                        <input type="checkbox" class="product-checkbox" 
                               data-product-id="' . $item['product_id'] . '" 
                               data-price="' . $item['price'] . '" 
                               data-quantity="' . $item['quantity'] . '" 
                               >
                            <img src="' . $imagePath . '" alt="Image post" style="max-width: 100%; height: auto;">
                            <div class="details">
                                <h4>' . $item['product_name'] . '</h4>
                            </div>
                            <div class="price">' . number_format($item['price'], 0, ',', '.') . 'đ</div>
                        </div>';
                    
                    } else {
                        echo '<div class="product">
                                <input type="checkbox" class="product-checkbox" data-price="' . $item['price'] . '" data-quantity="' . $item['quantity'] . '" checked>
                                <img src="./uploads/default.jpg" alt="Ảnh mặc định" style="max-width: 100%; height: auto;">
                                <div class="details">
                                    <h4>' . $item['product_name'] . '</h4>
                                </div>
                                <div class="price">' . number_format($item['price'], 0, ',', '.') . 'đ</div>
                            </div>';    
                    }
                }
            }
            ?>
        </div>

        <div class="footer">
    <div class="select-all">
        <input type="checkbox" id="select-all">
        <label for="select-all">All</label>
    </div>
    <div class="total">Total: 0đ</div>
    <!-- Form để gửi sản phẩm đã chọn -->
    <form id="order-form" action="./thongtindathang.php" method="POST">
        <input type="hidden" name="cart_data" id="cart-data"> <!-- Input ẩn để gửi dữ liệu -->
        <button type="submit" class="buy-now">Place an order</button>
    </form>
</div>

<script>
    // Hàm cập nhật tổng khi có sự thay đổi
    function updateTotal() {
        var checkboxes = document.querySelectorAll('.product-checkbox');
        var total = 0;

        // Duyệt qua tất cả các checkbox và tính tổng giá trị
        for (var checkbox of checkboxes) {
            if (checkbox.checked) {
                var price = parseInt(checkbox.getAttribute('data-price'));
                var quantity = parseInt(checkbox.getAttribute('data-quantity'));
                total += price * quantity; // Cộng giá trị của sản phẩm được chọn
            }
        }

        // Hiển thị tổng tiền
        document.querySelector('.total').innerText = 'Total: ' + total.toLocaleString('vi-VN') + 'đ';
    }

    // Lựa chọn tất cả checkbox
    document.getElementById('select-all').onclick = function () {
        var checkboxes = document.querySelectorAll('.product-checkbox');
        var isChecked = this.checked;
        
        for (var checkbox of checkboxes) {
            checkbox.checked = isChecked; // Đặt trạng thái checkbox dựa trên lựa chọn "select-all"
        }

        updateTotal(); // Cập nhật tổng sau khi thay đổi
    };

    // Cập nhật tổng cho các checkbox khi được chọn hoặc bỏ chọn
    var productCheckboxes = document.querySelectorAll('.product-checkbox');
    for (var checkbox of productCheckboxes) {
        checkbox.onclick = updateTotal; // Gọi hàm khi checkbox bị thay đổi
    }

    document.getElementById('order-form').onsubmit = function (e) {
    var selectedItems = [];
    var checkboxes = document.querySelectorAll('.product-checkbox');
    checkboxes.forEach(function (checkbox) {
        if (checkbox.checked) {
            var productData = {
                product_id: checkbox.getAttribute('data-product-id'),
                quantity: checkbox.getAttribute('data-quantity'),
                price: checkbox.getAttribute('data-price')
            };
            selectedItems.push(productData);
        }
    });

    // Debug: In ra console dữ liệu gửi đi
    console.log("Selected Items:", selectedItems);

    if (selectedItems.length === 0) {
        alert("Please select at least one product to order!");
        e.preventDefault();
        return false;
    }

    document.getElementById('cart-data').value = JSON.stringify(selectedItems);
};
</script>


</body>
</html>
