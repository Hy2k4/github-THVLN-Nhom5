<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CSS - Quản lý tài khoản</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color:  #ff6f6f;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }
        .header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .header .search-bar {
            flex-grow: 1;
            margin: 0 20px;
        }
        .header .search-bar input {
            width: 100%;
            padding: 5px;
            border: none;
            border-radius: 5px;
        }
        .header .icons i {
            margin-left: 15px;
            cursor: pointer;
        }
        .container {
            text-align: center;
            margin-top: 50px;
        }
        .message {
            font-size: 24px;
            color: #333;
        }
        .action-buttons {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            flex-direction: column;
        }
        .action-buttons button {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            margin: 10px 0;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .action-buttons .yellow {
            background-color: #FFC107;
        }
        .action-buttons .blue {
            background-color: #2196F3;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="header">
        <i class="fas fa-bars" onclick="alert('Menu clicked!')"></i>
        <div class="logo">CSS</div>
        <div class="search-bar">
            <input type="text" placeholder="Tìm kiếm...">
        </div>
        <div class="icons">
            <i class="fas fa-search"></i>
            <i class="fas fa-arrow-left"></i>
            <i class="fas fa-home"></i>
            <i class="fas fa-bell"></i>
            <i class="fas fa-user"></i>
        </div>
    </div>
    <div class="container">
        <div class="message">Chưa có tài khoản nào bị cấm.</div>
    </div>
    <div class="action-buttons">
        <button><i class="fas fa-user-plus"></i></button>
        <button class="yellow"><i class="fas fa-exclamation"></i></button>
        <button class="blue"><i class="fas fa-comments"></i></button>
    </div>
    
</body>
</html>
