<?php
session_start();
include '../connect/connect.php';

if (!isset($_SESSION['login_username'])) {
    header('Location: ../test.php');
    exit();
}

if (isset($_POST['selected_products'])) {
    $productIds = $_POST['selected_products'];
    $conn = connect_db();

    foreach ($productIds as $productId) {
        $productId = intval($productId);

        // Delete the product from the database
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
    }

    $stmt->close();
    $conn->close();

    header('Location: ../trangchunguoiban.php');
    exit();
} else {
    echo "No products selected for deletion.";
}
?>
