<!DOCTYPE html>
<html lang="vi">
<head>
 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xiaomi Mi 11</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
  body  {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background-color: #f0f0f0;
  color: #333;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #ff6f6f;
  padding: 10px 20px;
  color: white;
}

.menu-icon {
  font-size: 20px;
  cursor: pointer;
}

.logo {
  font-size: 24px;
  font-weight: bold;
}

.header-icons {
  display: flex;
  gap: 15px;
}

.icon {
  font-size: 20px;
  cursor: pointer;
}

.product-container {
  padding: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.product-card {
  background-color: white;
  border-radius: 10px;
  padding: 20px;
  width: 100%;
  max-width: 500px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.product-image img {
  max-width: 100%;
  border-radius: 10px;
}

.product-info h1 {
  font-size: 24px;
  margin-bottom: 10px;
}

.product-info p {
  font-size: 18px;
  margin-bottom: 15px;
}

.price {
  font-size: 22px;
  font-weight: bold;
  color: #ff4d4d;
}

.buttons {
  display: flex;
  justify-content: space-around;
  margin-top: 20px;
}

button {
  padding: 10px 15px;
  font-size: 16px;
  border-radius: 5px;
  border: none;
  cursor: pointer;
}

.buy-now {
  background-color: #ff4d4d;
  color: white;
}

.add-to-cart {
  background-color: white;
  color: #ff4d4d;
  border: 1px solid #ff4d4d;
}

.detail-section {
  display: flex;
  justify-content: space-around;
  margin-top: 20px;
  width: 100%;
  max-width: 500px;
}

.detail-box {
  background-color: white;
  border-radius: 10px;
  width: 48%;
  padding: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  text-align: center;
}

textarea {
  width: 100%;
  height: 80px;
  border: 1px solid #ddd;
  border-radius: 5px;
  resize: none;
}

.expand-icon {
  font-size: 24px;
  cursor: pointer;
}
</style> 
</head>
<body>
  <div class="header">
    <div class="logo">CSS</div>
    <div class="header-icons">
        <i class="fas fa-bars menu-icon"></i>
        <i class="fas fa-arrow-left icon"></i>
        <i class="fas fa-home icon"></i>
        <i class="fas fa-bell icon"></i>
        <i class="fas fa-user icon"></i>
    </div>
  </div>
  <main class="product-container">
    <div class="product-card">
      <div class="product-image">
        <img src="https://via.placeholder.com/200x300" alt="Xiaomi Mi 11">
      </div>
      <div class="product-info">
        <h1>Xiaomi Mi 11</h1>
        <p>Cần bán lại Xiaomi Mi 11</p>
        <p class="price">8.990.000₫</p>
        <div class="buttons">
          <button class="buy-now">Mua ngay</button>
          <button class="add-to-cart">Thêm vào giỏ hàng</button>
        </div>
      </div>
    </div>
    <div class="detail-section">
      <div class="detail-box">
        <p>Thông tin chi tiết:</p>
        <textarea readonly></textarea>
      </div>
      <div class="detail-box">
        <p>Thông tin chi tiết:</p>
        <div class="expand-icon">⤢</div>
      </div>
    </div>
  </main>
</body>
</html>
