<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
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
        .header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .header .icons {
            display: flex;
            align-items: center;
        }
        .header .icons i {
            margin-left: 15px;
            cursor: pointer;
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
        }
        .product img {
            width: 100px;
            height: 100px;
            margin-right: 20px;
        }
        .product .details {
            flex-grow: 1;
        }
        .product .details h4 {
            margin: 0;
            font-size: 18px;
        }
        .product .details p {
            margin: 5px 0;
            color: #888;
        }
        .product .price {
            font-size: 18px;
            color: red;
        }
        .footer {
            background-color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
        }
        .footer .total {
            font-size: 18px;
            font-weight: bold;
        }
        .footer .buy-now {
            background-color: green;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .footer .select-all {
            display: flex;
            align-items: center;
        }
        .footer .select-all input {
            margin-right: 5px;
        }
        .product input[type="checkbox"] {
            margin-right: 10px;
        }
        .order-info {
            margin-top: 20px;
            padding: 20px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .order-info h3 {
            margin: 0 0 10px 0;
        }
        .order-info p {
            margin: 5px 0;
        }
        .payment-methods {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .payment-methods button {
            flex: 1;
            margin: 0 10px;
            padding: 10px;
            background-color: #ddd;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .payment-methods img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }
        .discount-code {
            margin-top: 20px;
            display: flex;
            align-items: center;
        }
        .discount-code input {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">CSS</div>
        <div class="icons">
            <i class="fas fa-arrow-left"></i>
            <i class="fas fa-home"></i>
            <i class="fas fa-bell"></i>
            <i class="fas fa-user"></i>
        </div>
    </div>
    <div class="container">
        <div class="product">
            <img src="xiaomi-mi-11.jpg" alt="Xiaomi mi 11">
            <div class="details">
                <h4>Xiaomi mi 11</h4>
                <p class="price">8.990.000đ</p>
            </div>
        </div>
        <div class="order-info">
            <h3>Thông tin đặt hàng</h3>
            <p>To: Hoàng Bel</p>
            <p>Full Name: Hồ Lê Hoàng</p>
            <p>Address: 123 Ngô Mây, P.Ngô mây, Tp.Quy Nhơn, Bình Định</p>
            <p>Detail buy: Xiaomi mi 11</p>
            <p>Price: 8.990.000đ</p>
            <p>Payment Methods: Pay on Pickup</p>
            <p>Free ship: 10.000đ</p>
            <p>Total Price: 9.000.000đ</p>
        </div>
        <div class="payment-methods">
            <button>
                <img src="momo-logo.png" alt="momo-logo">
               Momo
            </button>
            <button>
                <img src="pay-on-pickup-logo.png" alt="Pay on pickup-logo ">
                Pay on pickup 
            </button>
            <button>
                <img src="visa-logo.png" alt="visa-logo">
               Visa
            </button>
        </div>
        <div class="discount-code">
            <input type="text" placeholder="Nhập mã giảm giá">
            <button class="buy-now">Mua Ngay</button>
        </div>
        
    </div>
</body>
</html>
