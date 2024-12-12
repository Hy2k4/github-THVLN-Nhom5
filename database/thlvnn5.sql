-- --------------------------------------------------------
-- Máy chủ:                      127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Phiên bản:           12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for thlvnn5
CREATE DATABASE IF NOT EXISTS `thlvnn5` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `thlvnn5`;

-- Dumping structure for table thlvnn5.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `headline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `phone_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_path` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_username`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thlvnn5.products: ~5 rows (approximately)
INSERT INTO `products` (`id`, `product_name`, `headline`, `price`, `description`, `phone_type`, `phone_company`, `image_path`, `created_at`, `updated_at`, `user_username`) VALUES
	(1, 'iphone X', 'bán iphone X', 5000000.00, 'dùng lâu muốn bán', '', 'Apple', 'uploads/IPX.jpg', '2024-12-06 19:13:37', '2024-12-12 13:38:52', 'test'),
	(2, 'Xiaomi mi 11', 'bán Xiaomi 11 hàng 99%', 6980000.00, 'ib để mô tả chi tiết', 'xiaomi', 'Xiaomi', 'uploads/OIP.jpg', '2024-12-07 09:58:41', '2024-12-12 13:39:00', 'test'),
	(5, 'samsung S20', 'bán SS S20 like new', 4990000.00, 'ib để xem chi tiết', 'SamSung S', 'Samsung', 'uploads/S20.jpg', '2024-12-08 14:32:23', '2024-12-12 13:39:05', 'test'),
	(8, 'test1', 'bán SS S20 like new', 4990000.00, '', 'SamSung S', 'Samsung', 'uploads/IPX - Copy.jpg,uploads/IPX.jpg,uploads/OIP.jpg', '2024-12-08 15:37:06', '2024-12-12 13:39:09', 'test'),
	(9, 'test2', 'bán ip 12', 7000000.00, '', '', 'Apple', 'uploads/ip12.jpg,uploads/ip12p2.jpg,uploads/ip12p3.jpg', '2024-12-08 15:43:21', '2024-12-12 13:39:14', 'test');

-- Dumping structure for table thlvnn5.user
CREATE TABLE IF NOT EXISTS `user` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sdt` int DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='đây là bảng thông tin người dùng';

-- Dumping data for table thlvnn5.user: ~3 rows (approximately)
INSERT INTO `user` (`ID`, `username`, `password`, `fullname`, `birthday`, `email`, `sdt`, `address`) VALUES
	(1, 'admin', 'admin', 'admin', '2000-12-01', 'admin@gmail.com', 123456789, '01 Nguyễn Thái Học'),
	(2, 'test', 'Hy_201004', 'Nguyễn Khang Hy', '2004-10-20', 'khanghynguyen15@gmail.com', 792456036, '07 Vũ Bảo, Ngô Mây, TP.Quy Nhơn'),
	(3, 'hy', '1234', 'Nghy', '2000-10-20', 'nguyenhy2k4@gmail.com', 867901082, '09 vu bao');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
