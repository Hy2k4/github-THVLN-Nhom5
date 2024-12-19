<?php
include '../connect/connect.php';

// Bắt đầu session để truy cập các giá trị từ session
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Chỉ gọi session_start() nếu session chưa được bắt đầu
}
// Kết nối đến cơ sở dữ liệu
$conn = connect_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy các giá trị từ form
    $product_name = $_POST['product-name'];
    $headline = $_POST['headline'];
    // Xử lý và làm sạch giá trị price
    $price = str_replace(['.', ','], '', $_POST['price']); // Remove dots and commas
    $description = $_POST['description'];
    $phone_type = $_POST['phone-type'];
    $phone_company = $_POST['phone-companies'];

    // Lấy user_username từ session
    $user_username = isset($_SESSION['login_username']) ? $_SESSION['login_username'] : null;

    // Kiểm tra nếu không có user_username (người dùng chưa đăng nhập)
    if ($user_username === null) {
        echo "Error: You need to sign in to post your product!";
        exit();
    }

    // Xử lý ảnh
    $image_paths = []; // Mảng chứa các đường dẫn ảnh

    // Kiểm tra nếu có ảnh tải lên
    if (isset($_FILES['phone-photos']) && !empty($_FILES['phone-photos']['name'][0])) {
        $upload_dir = 'uploads/'; // Thư mục lưu ảnh

        // Tạo thư mục nếu chưa có
        if (!is_dir('../' . $upload_dir)) {
            mkdir('../' . $upload_dir, 0777, true);
        }

        // Duyệt qua các ảnh đã chọn và xử lý
        foreach ($_FILES['phone-photos']['name'] as $index => $image_name) {
            $image_tmp_name = $_FILES['phone-photos']['tmp_name'][$index];
            $image_path = $upload_dir . basename($image_name);
            $full_image_path = '../' . $image_path; // Đường dẫn đầy đủ đến file ảnh

            // Kiểm tra nếu ảnh đã tồn tại
            if (file_exists($full_image_path)) {
                // Nếu ảnh đã tồn tại, sử dụng ảnh hiện có
                $image_paths[] = $image_path; // Thêm đường dẫn ảnh vào mảng
            } else {
                // Nếu ảnh chưa tồn tại, di chuyển file vào thư mục uploads
                if (move_uploaded_file($image_tmp_name, $full_image_path)) {
                    $image_paths[] = $image_path; // Thêm đường dẫn ảnh vào mảng
                }
            }
        }
    }

    // Chuyển mảng các đường dẫn ảnh thành chuỗi, phân tách bằng dấu phẩy
    $image_paths_string = implode(',', $image_paths);

    // Lưu thông tin sản phẩm vào cơ sở dữ liệu, bao gồm user_username
    $stmt = $conn->prepare("INSERT INTO products (product_name, headline, price, description, phone_type, phone_company, image_path, user_username) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $product_name, $headline, $price, $description, $phone_type, $phone_company, $image_paths_string, $user_username);

    if ($stmt->execute()) {
        header("Location: ../trangchunguoiban.php"); // Quay lại trang chính
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
}
?>
