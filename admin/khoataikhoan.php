<?php
include '../connect/connect.php';
session_start();
ob_start();

if (!isset($_SESSION['login_username'])) {
    header('Location: ../B1/login.php'); // Chuyển hướng về trang login nếu chưa đăng nhập
    exit();
}
?>

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
            justify-content: space-between;
            align-items: center;
            color: white;
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
        .header .icons i {
            margin-left: 15px;
            cursor: pointer;
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        .message {
            font-size: 24px;
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }
        .user-list {
            margin-top: 30px;
            text-align: left;
        }
        .user-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .user-list th, .user-list td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .user-list th {
            background-color: #f2f2f2;
        }
        .lock-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }
        .actions .chat:hover{
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.25);
            opacity: 0.8;
        }
        .actions .chat {
            background-color: #5bc0de;
            color: white;
        }
        .actions > a{
            text-decoration: none;
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
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .icons > a{
            text-decoration: none;
            color: black;
            font-weight: bold;
            width: 100px;
            height: 30px;
        }
        .midder{
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">CSS</div>
        <div class="search-bar">
            <form method="GET" action="">
                <select name="search_type">
                    <option value="user">User</option>
                    <option value="product">Product</option>
                </select>
                <input type="text" name="search" placeholder="Nhập từ khóa tìm kiếm...">
                <button type="submit">Tìm kiếm</button>
            </form>
        </div>
        <div class="icons">
            <a href="khoataikhoan.php"><i class="fas fa-sync-alt icon"></i></a>
            <a href="../test.php"><i class="fas fa-home"></i></a>
            <a href="unset.php"><i class="fa-solid fa-door-open"></i></a>
        </div>
    </div>
    <div class="container">
        <div class="message">Quản lý tài khoản</div>
        <div class="user-list">
            <table>
                <thead>
                    <tr>
                        <th>B1</th>
                        <th>B2</th>
                        <th>B3</th>
                        <th>B4</th>
                        <th>b5</th>
                        <th>B6</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $conn = connect_db();

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        $search_query = "";
                        $search_type = isset($_GET['search_type']) ? $_GET['search_type'] : "user";
                        $search_value = isset($_GET['search']) ? $_GET['search'] : "";

                        if ($search_type === "user") {
                            $sql = "SELECT ID, username, email, status FROM user WHERE username LIKE ? AND ID != 1";
                            $stmt = $conn->prepare($sql);
                            $search_param = "%" . $search_value . "%";
                            $stmt->bind_param("s", $search_param);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$row['username']}</td>
                                        <td>{$row['email']}</td>
                                        <td>" . ($row['status'] ? 'Hoạt động' : 'Đã khóa') . "</td>
                                        <td>
                                            <form method='POST' action='khoataikhoan.php'>
                                                <input type='hidden' name='user_username' value='{$row['ID']}'>
                                                <button type='submit' class='lock-btn'>" . ($row['status'] ? 'Khóa' : 'Mở khóa') . "</button>
                                            </form>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Không có tài khoản nào phù hợp.</td></tr>";
                            }
                        } elseif ($search_type === "product") {
                            $sql = "SELECT p.id, p.product_name, p.price, p.phone_company, p.status_products, u.username 
                            FROM products p 
                            LEFT JOIN user u ON p.user_username = u.username 
                            WHERE (p.id LIKE ? OR p.product_name LIKE ? OR p.phone_company LIKE ? OR u.username LIKE ?)";
                    
                            // Chuẩn bị và thực thi câu lệnh SQL
                            $stmt = $conn->prepare($sql);
                            $search_param = "%" . $search_query . "%";
                            $stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            
                            // Hiển thị kết quả
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                        <td>{$row['product_name']}</td>
                                        <td>{$row['price']}</td>
                                        <td>{$row['phone_company']}</td>
                                        <td>{$row['username']}</td>
                                        <td>" . ($row['status_products'] == '1' ? 'Hoạt động' : 'Đã khóa') . "</td>
                                        <td>
                                            <form method='POST' action='khoataikhoan.php'>
                                                <input type='hidden' name='product_id' value='{$row['id']}'>
                                                <button type='submit' class='lock-btn'>" . ($row['status_products'] == '1' ? 'Khóa' : 'Mở khóa') . "</button>
                                            </form>
                                        </td>
                                    </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Không có bài đăng nào phù hợp với tìm kiếm.</td></tr>";
                            }
                        }
                            $stmt->close();
                            ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
