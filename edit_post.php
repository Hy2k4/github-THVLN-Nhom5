<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Kiểm tra người dùng đã đăng nhập chưa
    if (!isset($_SESSION['login_username'])) {
        header('Location: ../test.php');
        exit();
    }

    include './connect/connect.php'; // Kết nối CSDL
    $conn = connect_db();

    // Lấy ID bài đăng từ URL
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        echo "ID không hợp lệ.";
        exit();
    }

    $post_id = intval($_GET['id']); // Chuyển sang số nguyên
    $error_message = "";

    // Lấy thông tin bài đăng từ CSDL
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if (!$post) {
        echo "Bài đăng không tồn tại.";
        exit();
    }

    // Khởi tạo mảng lưu trữ ảnh
    $imagePaths = !empty($post['image_path']) ? explode(',', $post['image_path']) : [];

    // Xử lý cập nhật dữ liệu khi nhấn "Lưu"
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $product_name = $_POST['product-name'];
        $headline = $_POST['headline'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $phone_type = $_POST['phone-type'];
        $phone_company = $_POST['phone-company'] ?? 'Chưa xác định';

        // Xóa ảnh cũ nếu người dùng tải ảnh mới
        $new_image_paths = [];
        if (!empty($_FILES['product-images']['tmp_name'][0])) {
            foreach ($imagePaths as $old_image) {
                if (file_exists(__DIR__ . '/' . $old_image)) {
                    unlink(__DIR__ . '/' . $old_image);
                }
            }

            // Tải ảnh mới
            $upload_dir = __DIR__ . '/uploads/';
            foreach ($_FILES['product-images']['tmp_name'] as $index => $tmp_name) {
                if ($_FILES['product-images']['error'][$index] === 0) {
                    $image_name = uniqid('image_', true) . '.' . pathinfo($_FILES['product-images']['name'][$index], PATHINFO_EXTENSION);
                    $image_path = 'uploads/' . $image_name;

                    if (move_uploaded_file($tmp_name, $upload_dir . $image_name)) {
                        $new_image_paths[] = $image_path;
                    } else {
                        $error_message = "Không thể tải lên hình ảnh mới.";
                        break;
                    }
                }
            }
        } else {
            $new_image_paths = $imagePaths; // Giữ lại ảnh cũ nếu không tải mới
        }

        // Cập nhật thông tin vào CSDL
        $new_image_paths_str = implode(',', $new_image_paths);
        $update_sql = "UPDATE products SET product_name=?, headline=?, price=?, description=?, phone_type=?, phone_company=?, image_path=? WHERE id=?";
        $stmt = $conn->prepare($update_sql);
        if ($stmt) {
            $stmt->bind_param("ssdssssi", $product_name, $headline, $price, $description, $phone_type, $phone_company, $new_image_paths_str, $post_id);
            if ($stmt->execute()) {
                echo "<script>alert('Cập nhật thành công!'); window.location.href='./trangchunguoiban.php';</script>";
                exit();
            } else {
                $error_message = "Lỗi khi cập nhật dữ liệu: " . $conn->error;
            }
        } else {
            $error_message = "Không thể chuẩn bị câu lệnh SQL: " . $conn->error;
        }
    }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa bài đăng</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        h2 { text-align: center; color: #333; margin-top: 20px; }
        form { background-color: white; padding: 20px; border-radius: 8px; max-width: 600px; margin: 20px auto; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
        label { font-weight: bold; display: block; margin-bottom: 8px; }
        input, textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 5px; }
        textarea { resize: vertical; height: 150px; }
        button, a { padding: 10px 20px; border: none; color: white; border-radius: 5px; text-decoration: none; cursor: pointer; display: inline-block; }
        button { background-color: #4CAF50; }
        a { background-color: #f44336; }
        button:hover { background-color: #45a049; }
        a:hover { background-color: #e53935; }
        .thumbnail { width: 50px; height: 50px; object-fit: cover; margin-right: 5px; }
    </style>
</head>
<body>
    <h2>Chỉnh sửa bài đăng</h2>
    <?php if ($error_message): ?>
        <p style="color: red; text-align: center;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="product-name">Tên sản phẩm:</label>
        <input type="text" id="product-name" name="product-name" value="<?php echo htmlspecialchars($post['product_name']); ?>" required>

        <label for="headline">Tiêu đề:</label>
        <input type="text" id="headline" name="headline" value="<?php echo htmlspecialchars($post['headline']); ?>" required>

        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($post['price']); ?>" required>

        <label for="description">Mô tả:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($post['description']); ?></textarea>

        <label for="phone-type">Loại điện thoại:</label>
        <input type="text" id="phone-type" name="phone-type" value="<?php echo htmlspecialchars($post['phone_type']); ?>">

        <label for="phone-company">Hãng điện thoại:</label>
        <input type="text" id="phone-company" name="phone-company" value="<?php echo htmlspecialchars($post['phone_company']); ?>">

        <label for="product-images">Hình ảnh sản phẩm:</label>
        <div>
            <?php foreach ($imagePaths as $imagePath): ?>
                <img src="<?php echo htmlspecialchars($imagePath); ?>" class="thumbnail" alt="Hình ảnh">
            <?php endforeach; ?>
        </div>
        <input type="file" id="product-images" name="product-images[]" multiple>

        <button type="submit">Lưu</button>
        <a href="./trangchunguoiban.php">Hủy</a>
    </form>
</body>
</html>
