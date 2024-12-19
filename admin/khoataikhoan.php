<?php
include '../connect/connect.php';
session_start();
ob_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['login_username'])) {
    header('Location: ../B1/login.php');
    exit();
}

$conn = connect_db();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý khóa/mở khóa tài khoản hoặc sản phẩm
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        // Khóa/mở khóa tài khoản
        $user_id = $_POST['user_id'];
        $current_status = $_POST['current_status'];
        $new_status = $current_status ? 0 : 1;

        $sql = "UPDATE user SET status = ? WHERE ID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $new_status, $user_id);
        $stmt->execute();
        $stmt->close();
    }

    if (isset($_POST['product_id'])) {
        // Khóa/mở khóa sản phẩm
        $product_id = $_POST['product_id'];
        $current_status = $_POST['current_status'];
        $new_status = $current_status ? 0 : 1;

        $sql = "UPDATE products SET status_products = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $new_status, $product_id);
        $stmt->execute();
        $stmt->close();
    }

    // Chuyển hướng để tránh gửi lại form khi tải lại trang
    header("Location: khoataikhoan.php");
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
        /* Thêm CSS để giao diện đẹp hơn */
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
        .container {
            margin: 20px;
        }
        .user-list table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
                <input type="text" name="search" placeholder="Enter here...">
                <button type="submit">Find</button>
            </form>
        </div>
        <div class="icons">
            <a href="khoataikhoan.php"><i class="fas fa-sync-alt icon"></i></a>
            <a href="../test.php"><i class="fas fa-home"></i></a>
            <a href="unset.php"><i class="fa-solid fa-door-open"></i></a>
        </div>
    </div>

    <div class="container">
        <div class="user-list">
            <table>
                <thead>
                    <tr>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
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
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['username']}</td>
                                    <td>{$row['email']}</td>
                                    <td>" . ($row['status'] ? 'Unlock' : 'Lock') . "</td>
                                    <td>
                                        <form method='POST' action='khoataikhoan.php'>
                                            <input type='hidden' name='user_id' value='{$row['ID']}'>
                                            <input type='hidden' name='current_status' value='{$row['status']}'>
                                            <button type='submit' class='lock-btn'>" . ($row['status'] ? 'Lock' : 'Unlock') . "</button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No account.</td></tr>";
                        }
                    } elseif ($search_type === "product") {
                        $sql = "SELECT p.id, p.product_name, p.price, p.phone_company, p.status_products, u.username 
                                FROM products p 
                                LEFT JOIN user u ON p.user_username = u.username 
                                WHERE (p.id LIKE ? OR p.product_name LIKE ? OR p.phone_company LIKE ? OR u.username LIKE ?);";
                        $stmt = $conn->prepare($sql);
                        $search_param = "%" . $search_value . "%";
                        $stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$row['product_name']}</td>
                                    <td>{$row['price']}</td>
                                    <td>{$row['phone_company']}</td>
                                    <td>{$row['username']}</td>
                                    <td>" . ($row['status_products'] ? 'Unlock' : 'Lock') . "</td>
                                    <td>
                                        <form method='POST' action='khoataikhoan.php'>
                                            <input type='hidden' name='product_id' value='{$row['id']}'>
                                            <input type='hidden' name='current_status' value='{$row['status_products']}'>
                                            <button type='submit' class='lock-btn'>" . ($row['status_products'] ? 'Lock' : 'Unlock') . "</button>
                                        </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>No post</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
