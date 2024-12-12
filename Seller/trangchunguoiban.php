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
        <div class="product-list">
            <div class="product">
                <input type="checkbox" class="product-checkbox">
                <img src="https://www.example.com/redmi_note_13.png" alt="redmi note 13 5G">
                <div class="details">
                    <div class="name">redmi note 13 5G</div>
                    <div class="price">4,500,000₫</div>
                </div>
            </div>
            <div class="product">
                <input type="checkbox" class="product-checkbox">
                <img src="https://www.example.com/xiaomi_mi_11.png" alt="Xiaomi mi 11">
                <div class="details">
                    <div class="name">Xiaomi mi 11</div>
                    <div class="price">8,990,000₫</div>
                </div>
            </div>
            <div class="product">
                <input type="checkbox" class="product-checkbox">
                <img src="https://www.example.com/iq_z9_5g.png" alt="IQ Z9 5G">
                <div class="details">
                    <div class="name">IQ Z9 5G</div>
                    <div class="price">7,500,000₫</div>
  </div>
            </div>
        </div>
    </div>
    <div class="actions">
       
        <button class="edit"><i class="fas fa-edit"></i></button>
        <button class="delete"><i class="fas fa-trash"></i></button>
        <button class="chat"><i class="fas fa-comment-alt"></i></button>
    </div>
</body>
</html>
