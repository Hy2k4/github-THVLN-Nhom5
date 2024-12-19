
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSS - Quản lý tài khoản</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
            height: auto;
        }
        .header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .header .search-bar {
            flex-grow: 1;
            margin: 0 20px;
        }
        .header .search-bar input {
            width: 100%;
            padding: 5px;
            border: none;
            border-radius: 5px;
        }
        .header .icons{
            cursor: pointer;
            width: 100px;
            height: auto;
            text-align: center;
        }
        .header .icons a{
            text-decoration: none;
            color: black;
            font-weight: bold;
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        .message {
            font-size: 24px;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">CSS</div>
        <div class="icons">
            <a href="../test.php"><i class="fas fa-home"></i> turn back</a>
        </div>
    </div>
    <div class="container">
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $payment_method = $_POST['payment_method'];
                $cart_data = $_POST['cart_data'];

                // Làm gì đó với phương thức thanh toán và giỏ hàng
                echo "<h2>Payment Methods:" . "</br>" . htmlspecialchars($payment_method) . "</h2>";
                // Xử lý giỏ hàng và tạo mã QR (nếu cần)
                echo "<input type='image' src='../Image/hehe.png' alt='ảnh qr' style='height: 500px; weight: 500px;'>";
            }
        ?>
    </div>
    
</body>
</html>
