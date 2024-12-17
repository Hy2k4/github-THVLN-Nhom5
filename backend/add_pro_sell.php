<?php
include '../connect/connect.php';

if (isset($_POST['name']) && isset($_POST['price']) && isset($_POST['company'])) {
    $productName = $_POST['name'];
    $productPrice = $_POST['price'];
    $productCompany = $_POST['company'];

    // Kết nối cơ sở dữ liệu
    $conn = connect_db();

    // Thực hiện thêm sản phẩm mới vào cơ sở dữ liệu
    $stmt = $conn->prepare("INSERT INTO products (product_name, price, phone_company) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $productName, $productPrice, $productCompany);

    if ($stmt->execute()) {
        $productId = $stmt->insert_id; // Lấy ID của sản phẩm mới tạo
        echo json_encode(['success' => true, 'product_id' => $productId]); // Trả về ID của sản phẩm mới
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi thêm sản phẩm.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Thiếu dữ liệu cần thiết.']);
}
?>
