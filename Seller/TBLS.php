<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao diện Người Bán</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .header {
            background-color: #d9534f;
            color: white;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .header .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
        }
        .header .logo i {
            margin-right: 10px; 
        }
        .header .icons {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .header .icons .icon {
            font-size: 20px;
            cursor: pointer;
        }
        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 50px);
            background-color: #f0f0f0;
            font-size: 24px;
            color: #333;
        }
        .chat-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #5bc0de;
            color: white;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <i class="fas fa-bars icon"></i>
            <span>CSS for Seller</span>
        </div>
        <div class="icons">
            <i class="fas fa-arrow-left icon"></i>
            <i class="fas fa-bell icon"></i>
            <i class="fas fa-sync-alt icon"></i>
        </div>
    </div>
    <div class="content">
		Chưa có thông báo nào 
    </div>
    <div class="chat-icon">
        <i class="fas fa-comment-alt"></i>
    </div>
</body>
</html>
