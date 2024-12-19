<?php
    session_start();
    include './connect/connect.php'; // Kết nối với cơ sở dữ liệu
    $conn = connect_db();
    $totalPrice = 0; // Khởi tạo tổng giá trị là 0
    $selectedProducts = []; // Khởi tạo danh sách sản phẩm rỗng

    if (!isset($_SESSION['login_username'])) {
        header("Location: ./test.php");
        exit;
    }

    // Lấy tên người dùng từ session
    $username = $_SESSION['login_username'];

    // Lấy thông tin người dùng từ cơ sở dữ liệu
    $query_user = "SELECT fullname, address, sdt FROM user WHERE username = ?";
    $stmt_user = $conn->prepare($query_user);
    $stmt_user->bind_param("s", $username);
    $stmt_user->execute();
    $user_result = $stmt_user->get_result(); // Lấy kết quả từ câu truy vấn

    // Kiểm tra nếu có dữ liệu
    $user_info = $user_result->fetch_assoc(); // Dùng fetch_assoc() trên đối tượng mysqli_result


    // Kiểm tra nếu có dữ liệu giỏ hàng từ POST
    if (!empty($_POST['cart_data'])) {
        $selectedProducts = json_decode($_POST['cart_data'], true); // Giải mã JSON
    } else {
        echo "<script>
                alert('No products were selected.');
            </script>";
    }

    // Lấy thông tin sản phẩm từ giỏ hàng
    $products = [];
    foreach ($selectedProducts as $item) {
        $product_id = $item['product_id'];
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            $imagePaths = !empty($row['image_path']) ? explode(',', $row['image_path']) : [];
            $imagePath = !empty($imagePaths) ? './' . htmlspecialchars($imagePaths[0]) : 'uploads/default.jpg';

            $products[] = array_merge($row, [
                'quantity' => $item['quantity'],
                'image_path' => $imagePath
            ]);
            $totalPrice += $row['price'] * $item['quantity'];
        }
    }

    // Kiểm tra nếu người dùng đã bấm nút "Lưu đơn hàng"
    if (isset($_POST['save_order'])) {
        $cartData = json_decode($_POST['cart_data'], true);

        if (!empty($cartData)) {
            $conn->begin_transaction(); // Bắt đầu giao dịch

            try {
                // Thêm vào bảng 'giohang'
                $query_cart = "INSERT INTO giohang (username, TrangThai) VALUES (?, 'Chưa thanh toán')";
                $stmt_cart = $conn->prepare($query_cart);
                $stmt_cart->bind_param("s", $username);

                if (!$stmt_cart->execute()) {
                    throw new Exception("Error adding to a table 'giohang': " . $stmt_cart->error);
                }

                // Lấy ID giỏ hàng vừa thêm
                $cart_id = $conn->insert_id;  // Sử dụng cart_id để tham chiếu các sản phẩm trong bảng 'chitietdathang'

                // 2. Thêm chi tiết đơn hàng vào bảng 'chitietdathang'
                $query_order = "INSERT INTO chitietdathang (cart_id, username, product_id, quantity, total_price) VALUES (?, ?, ?, ?, ?)";
                $stmt_order = $conn->prepare($query_order);

                foreach ($cartData as $item) {
                    $product_id = $item['product_id'];
                    $quantity = $item['quantity'];
                    $total_price = $item['quantity'] * $item['price'];

                    // Gửi giá trị vào câu lệnh SQL bao gồm cả cart_id
                    $stmt_order->bind_param("isiii", $cart_id, $username, $product_id, $quantity, $total_price);
                    if (!$stmt_order->execute()) {
                        throw new Exception("Error adding to a table 'chitietdathang': " . $stmt_order->error);
                    }
                }


                // Nếu mọi thứ đều ổn, commit transaction
                $conn->commit();

                // Hiển thị thông báo thành công
                echo "<script>
                        alert('Purchase order successfully!');
                    </script>";

            } catch (Exception $e) {
                // Nếu có lỗi, rollback
                $conn->rollback();
                echo "Error: " . $e->getMessage();
            }
        } else {
            echo "There are no products in the cart.";
        }
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin chi tiết đặt hàng</title>
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
            justify-content: space-around;
            align-items: center;
            color: white;
        }
        .header .logo {
            font-size: 30px;
            font-weight: bold;
        }
        .header .icons button {
            border: none;
            background: transparent;
            color: black;
            cursor: pointer;
            background-color: white;
            height: 30px;
            width: 100px;
            border: 1px solid black;
            border-radius: 5px;
            font-weight: bold;
        }
        .header .icons button:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
            opacity: 0.8;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        .product {
            display: flex;
            align-items: center;
            padding: 20px;
            background-color: white;
            border-bottom: 1px solid #ddd;
            width: 100%;
            max-width: 800px;
            margin-bottom: 10px;
            border: 1px solid black;
            border-radius: 5px;
        }
        .product img {
            width: 100px;
            height: 100px;
            margin-right: 20px;
            margin-left: 10%;
            object-fit: cover;
        }
        .product .details {
            flex-grow: 1;
            width: 400px;
        }
        .product .details p {
            display: inline-block;
        }
        .product .details h4 {
            width: auto;
        }
        .product .details h4 {
            margin: 0;
            font-size: 18px;
        }
        .product .price {
            font-size: 20px;
            color: red;
            margin-right: 10%;
            font-weight: bold;
        }
        .order-info {
            width: 100%;
            max-width: 800px;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .payment{
            display: flex;
        }
        .payment button{
            margin: 10px 20px;
            padding: 0;
            border: 3px solid black;
            border-radius: 5px;
            cursor: pointer;
        }
        .payment button:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
            opacity: 0.8;
        }
        .payment input[type="image" i]{
            object-fit: cover;
        }
        #btn-submit{
            width: 500px;
            height: 50px;
            border: 3px solid black;
            border-radius: 5px;
            cursor: pointer;
            background-color: #6FE242;
            font-weight: bold;
            font-size: 28px;
        }
        #btn-submit:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
            opacity: 0.8;
        }

    </style>
</head>
<body>
    <div class="header">
        <div class="logo">CSS - Cellphone Seller System</div>
        <div class="icons">
        <a href="./giohang.php" style="color: white; text-decoration: none;"><button><i class="fas fa-arrow-left"></i> Turn back</button></a>
        </div>
    </div>

    <div class="container">
        <h2>Selected Product Information</h2>
        <?php
        if (empty($products)) {
            echo "<p>Your shopping cart is empty.</p>";
        } else {
            foreach ($products as $product) {
                $productName = htmlspecialchars($product['product_name'] ?? "Tên sản phẩm không có sẵn");
                $price = number_format($product['price'] * $product['quantity'], 0, ',', '.');
                $imagePath = htmlspecialchars($product['image_path']);
                echo '<div class="product">
                <img src="' . htmlspecialchars($imagePath) . '" alt="Ảnh sản phẩm">
                <div class="details">
                    <h4>' . htmlspecialchars($productName) . '</h4>
                    <p>Số lượng: ' . $product['quantity'] . '</p>
                </div>
                <div class="price">' . $price . 'đ</div>
            </div>';
        
            }
        }
        ?>

    <div class="order-info">
        <h3>Ordering Information</h3>
        <p>Username: <?= htmlspecialchars($username) ?> (information only)</p>
        
        <!-- Kiểm tra nếu có giá trị trong fullname -->
        <p>Full name: <?= !empty($user_info['fullname']) ? htmlspecialchars($user_info['fullname']) : 'Not Updated' ?></p>
        
        <!-- Kiểm tra nếu có giá trị trong address -->
        <p>Address: <?= !empty($user_info['address']) ? htmlspecialchars($user_info['address']) : 'Not Updated' ?></p>
        
        <!-- Kiểm tra nếu có giá trị trong số điện thoại -->
        <p>Phone Number: <?= !empty($user_info['sdt']) ? htmlspecialchars($user_info['sdt']) : 'Not Updated' ?></p>
        
        <p>Total order value: <?= number_format($totalPrice, 0, ',', '.') ?> vnđ</p>

        <p>Payment Methods: <span id="payment-method">Method not selected</span></p>
    </div>

    <div class="payment">
        <!--<button type="button" onclick="selectPaymentMethod('Momo')">
            <input type="image" name="momo" id="momo" src="./Image/Momo.png" alt="Momo">
        </button> -->
        <button type="button" onclick="selectPaymentMethod('Pay on Pickup')">
            <input type="image" name="pickup" id="pickup" src="./Image/payonpickup.png" alt="Pay on Pickup">
        </button>
        <!--<button type="button" onclick="selectPaymentMethod('Visa')">
            <input type="image" name="visa" id="visa" src="./Image/Visa.png" alt="Visa">
        </button>-->
    </div>

    <form method="POST" action="" id="payment-form">
        <input type="hidden" name="payment_method" id="payment-method-input">
        <input type="hidden" name="cart_data" value='<?= htmlspecialchars(json_encode($selectedProducts)) ?>'>
        <button type="submit" name="save_order" <?= empty($products) ? 'disabled' : '' ?> id="btn-submit">Buy Orders</button>
    </form>    

<script>
    // Hàm để thay đổi phương thức thanh toán và cập nhật nội dung trên trang
    function selectPaymentMethod(method) {
        // Cập nhật nội dung hiển thị phương thức thanh toán
        document.getElementById('payment-method').innerText = method;
        
        // Cập nhật giá trị cho input hidden trong form
        document.getElementById('payment-method-input').value = method;
    }
</script>

</body>
</html>