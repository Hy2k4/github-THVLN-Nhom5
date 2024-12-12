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
    $price = $_POST['price'];
    $description = $_POST['description'];
    $phone_type = $_POST['phone-type'];
    $phone_company = $_POST['phone-companies'];

    // Lấy user_username từ session
    $user_username = isset($_SESSION['login_username']) ? $_SESSION['login_username'] : null;

    // Kiểm tra nếu không có user_username (người dùng chưa đăng nhập)
    if ($user_username === null) {
        echo "Lỗi: Bạn cần đăng nhập để đăng sản phẩm!";
        exit();
    }

    // Xử lý ảnh
    $image_paths = []; // Mảng chứa các đường dẫn ảnh

    // Kiểm tra nếu có ảnh tải lên
    if (isset($_FILES['phone-photos']) && $_FILES['phone-photos']['error'][0] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/'; // Thư mục lưu ảnh

        // Tạo thư mục nếu chưa có
        if (!is_dir('../' . $upload_dir)) {
            mkdir('../' . $upload_dir, 0777, true);
        }

        // Duyệt qua các ảnh đã chọn và di chuyển vào thư mục
        foreach ($_FILES['phone-photos']['name'] as $index => $image_name) {
            $image_tmp_name = $_FILES['phone-photos']['tmp_name'][$index];
            $image_path = $upload_dir . basename($image_name);
            
            // Di chuyển file vào thư mục uploads
            if (move_uploaded_file($image_tmp_name, '../' . $image_path)) {
                $image_paths[] = $image_path; // Thêm đường dẫn ảnh vào mảng
            }
        }
    }

    // Chuyển mảng các đường dẫn ảnh thành chuỗi, phân tách bằng dấu phẩy
    $image_paths_string = implode(',', $image_paths);

    // Lưu thông tin sản phẩm vào cơ sở dữ liệu, bao gồm user_username
    $stmt = $conn->prepare("INSERT INTO products (product_name, headline, price, description, phone_type, phone_company, image_path, user_username) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $product_name, $headline, $price, $description, $phone_type, $phone_company, $image_paths_string, $user_username);

    if ($stmt->execute()) {
        echo "Bài đăng đã được lưu!";
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    // Đóng kết nối
    $stmt->close();
    $conn->close();
}
?>
