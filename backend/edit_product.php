<?php
include '../connect/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM products WHERE id = $id");
    $product = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $product_name = $_POST['product-name'];
    $headline = $_POST['headline'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $phone_type = $_POST['phone-type'];
    $phone_company = $_POST['phone-companies'];

    $image_path = $_POST['current-image'];
    if (isset($_FILES['phone-photos']) && $_FILES['phone-photos']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $image_path = $upload_dir . basename($_FILES['phone-photos']['name']);
        move_uploaded_file($_FILES['phone-photos']['tmp_name'], $image_path);
    }

    $stmt = $conn->prepare("UPDATE products SET product_name = ?, headline = ?, price = ?, description = ?, phone_type = ?, phone_company = ?, image_path = ? WHERE id = ?");
    $stmt->bind_param("ssdssssi", $product_name, $headline, $price, $description, $phone_type, $phone_company, $image_path, $id);

    if ($stmt->execute()) {
        echo "Update success!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
