<?php
include '../connect/connect.php';

// Kiểm tra xem 'selected_products' có được gửi lên không
if (isset($_POST['selected_products'])) {
    $selectedIds = $_POST['selected_products'];
    $ids = explode(',', $selectedIds); // Chuyển chuỗi id thành mảng

    // Kiểm tra nếu mảng ids không rỗng
    if (empty($ids)) {
        echo "Không có ID sản phẩm nào được gửi.";
        exit();
    }

    // Kết nối CSDL
    $conn = connect_db();

    // Kiểm tra kết nối cơ sở dữ liệu
    if ($conn->connect_error) {
        echo "Kết nối CSDL thất bại: " . $conn->connect_error;
        exit();
    }

    // Xóa từng sản phẩm dựa trên id
    foreach ($ids as $id) {
        // Kiểm tra xem id có hợp lệ không
        if (!is_numeric($id)) {
            echo "ID sản phẩm không hợp lệ: $id.";
            continue;
        }

        // Thực hiện truy vấn DELETE
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        
        if ($stmt === false) {
            echo "Lỗi chuẩn bị truy vấn: " . $conn->error;
            continue;
        }

        $stmt->bind_param("i", $id);

        // Thực hiện truy vấn
        if ($stmt->execute()) {
            echo "Sản phẩm với id $id đã được xóa.<br>";
        } else {
            echo "Lỗi xóa sản phẩm với id $id: " . $stmt->error . "<br>";
        }

        $stmt->close();
    }

    $conn->close();
} else {
    echo "Không có sản phẩm nào được chọn để xóa.";
}
?>
