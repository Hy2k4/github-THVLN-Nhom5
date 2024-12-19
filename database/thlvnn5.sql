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

-- Dumping structure for table thlvnn5.chitietdathang
CREATE TABLE IF NOT EXISTS `chitietdathang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cart_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `total_price` decimal(10,2) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `username` (`username`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `chitietdathang_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE,
  CONSTRAINT `chitietdathang_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thlvnn5.chitietdathang: ~0 rows (approximately)

-- Dumping structure for table thlvnn5.giohang
CREATE TABLE IF NOT EXISTS `giohang` (
  `GioHangID` int NOT NULL AUTO_INCREMENT,
  `NgayTao` datetime DEFAULT CURRENT_TIMESTAMP,
  `TrangThai` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'Chưa thanh toán',
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `quantity` int DEFAULT '1',
  PRIMARY KEY (`GioHangID`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thlvnn5.giohang: ~11 rows (approximately)
INSERT INTO `giohang` (`GioHangID`, `NgayTao`, `TrangThai`, `username`, `product_id`, `quantity`) VALUES
	(2, '2024-12-18 10:27:21', 'Chưa thanh toán', 'test', 38, 1),
	(4, '2024-12-18 11:19:18', 'Chưa thanh toán', 'test', 25, 1),
	(52, '2024-12-19 01:01:32', 'Chưa thanh toán', 'test', 5, 1),
	(60, '2024-12-19 02:12:37', 'Chưa thanh toán', 'test', NULL, 1),
	(61, '2024-12-19 02:13:13', 'Chưa thanh toán', 'test', NULL, 1),
	(67, '2024-12-19 02:28:49', 'Chưa thanh toán', 'test', NULL, 1),
	(71, '2024-12-19 02:38:59', 'Chưa thanh toán', 'test', NULL, 1),
	(72, '2024-12-19 02:41:17', 'Chưa thanh toán', 'test', NULL, 1),
	(73, '2024-12-19 08:15:06', 'Chưa thanh toán', 'admin', 38, 1),
	(74, '2024-12-19 08:15:17', 'Chưa thanh toán', 'admin', NULL, 1),
	(75, '2024-12-19 08:22:38', 'Chưa thanh toán', 'test', 25, 1);

-- Dumping structure for table thlvnn5.history
CREATE TABLE IF NOT EXISTS `history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thlvnn5.history: ~19 rows (approximately)
INSERT INTO `history` (`id`, `username`, `action`, `details`, `created_at`) VALUES
	(30, 'test', 'xóa bài đăng', 'thành công', '2024-12-18 01:09:05'),
	(31, 'test', 'chỉnh sửa bài đăng', 'thành công', '2024-12-18 01:10:47'),
	(32, 'test', 'tạo bài đăng', 'thành công', '2024-12-18 01:11:05'),
	(33, 'admin', 'chỉnh sửa bài đăng', 'thành công', '2024-12-19 08:17:05'),
	(34, 'admin', 'xóa bài đăng', 'thành công', '2024-12-19 08:17:34'),
	(35, 'admin', 'tạo bài đăng', 'thành công', '2024-12-19 08:17:46'),
	(36, 'admin', 'xóa bài đăng', 'thành công', '2024-12-19 08:18:12'),
	(37, 'admin', 'xóa bài đăng', 'thành công', '2024-12-19 08:18:16'),
	(38, 'test', 'tạo bài đăng', 'thành công', '2024-12-19 08:45:28'),
	(39, 'test', 'tạo bài đăng', 'thành công', '2024-12-19 12:02:35'),
	(40, 'test', 'tạo bài đăng', 'thành công', '2024-12-19 12:08:18'),
	(41, 'test', 'tạo bài đăng', 'thành công', '2024-12-19 12:11:11'),
	(42, 'test', 'tạo bài đăng', 'thành công', '2024-12-19 12:14:17'),
	(43, 'test', 'tạo bài đăng', 'thành công', '2024-12-19 12:18:21'),
	(44, 'test', 'tạo bài đăng', 'thành công', '2024-12-19 12:21:39'),
	(45, 'test', 'tạo bài đăng', 'thành công', '2024-12-19 12:31:37'),
	(46, 'test', 'tạo bài đăng', 'thành công', '2024-12-19 12:34:22'),
	(47, 'test', 'tạo bài đăng', 'thành công', '2024-12-19 12:34:28'),
	(48, 'test', 'tạo bài đăng', 'thành công', '2024-12-19 12:36:11');

-- Dumping structure for table thlvnn5.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thlvnn5.messages: ~1 rows (approximately)
INSERT INTO `messages` (`id`, `username`, `message`, `timestamp`) VALUES
	(1, 'User', 'hello', '2024-12-18 19:56:45');

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
  `status_products` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_username`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table thlvnn5.products: ~10 rows (approximately)
INSERT INTO `products` (`id`, `product_name`, `headline`, `price`, `description`, `phone_type`, `phone_company`, `image_path`, `created_at`, `updated_at`, `user_username`, `status_products`) VALUES
	(25, 'iphone 12', 'bán ip 12', 7000000.00, '', '', 'apple', 'uploads/ip12.jpg,uploads/ip12p2.jpg,uploads/ip12p3.jpg', '2024-12-17 15:30:37', '2024-12-17 18:10:54', 'test', '1'),
	(40, 'Iphone 13', 'test', 9700000.00, 'bán lại điện thoại iphone 13 like new 99%', '', 'Apple', 'uploads/ip13.jpg,uploads/ip13p2.jpg', '2024-12-19 05:06:33', '2024-12-19 05:06:33', 'test', '1'),
	(41, 'samsung A55', 'bán lại điện thoại Samsung hàng 98%', 9900000.00, '', 'SamSung A', 'Samsung', 'uploads/ssa55.jpg,uploads/ssa55p2.jpg', '2024-12-19 05:09:41', '2024-12-19 05:09:41', 'test', '1'),
	(42, 'Oppo reno 12 pro ', 'Dùng lâu chán bán lại điện thoại ', 10000000.00, 'bán hoặc đổi sang xiaomi mi 13', 'oppo reno', 'Oppo', 'uploads/opporeno12pro.jpg,uploads/opporeno12prop2.jpg', '2024-12-19 05:13:20', '2024-12-19 05:13:20', 'test', '1'),
	(43, 'Xiaomi mi 11', 'cần bán xiaomi hàng 97%', 6900000.00, '', 'xiaomi mi', 'Xiaomi', 'uploads/OIP.jpg', '2024-12-19 05:15:24', '2024-12-19 05:15:24', 'test', '1'),
	(44, 'Vivo IQ Z9 Turbo', 'bán lại điện thoại ', 6400000.00, '', 'Vivo IQ', 'Vivo', 'uploads/VivoIQZ9Turbo.jpg,uploads/VivoIQZ9Turbop2.jpg', '2024-12-19 05:19:30', '2024-12-19 05:19:30', 'test', '1'),
	(45, 'Realme GT neo 5', 'bán lại điện để nâng đời', 4990000.00, '', 'Realme GT neo', 'Realme', 'uploads/GTneo5.jpg,uploads/GTneo5p2.jpg,uploads/GTneo5p3.jpg', '2024-12-19 05:22:50', '2024-12-19 05:22:50', 'test', '1'),
	(46, 'Infinix hot 40 pro', 'bán lại điện thoại do không thich hệ điều hành ', 4990000.00, 'ib để trao đổi chi tiết về sản phẩm\r\n\r\nMàn hình\r\n\r\nKích thước màn hình\r\n\r\n6.78 inches\r\nCông nghệ màn hình\r\n\r\nIPS LCD\r\nĐộ phân giải màn hình\r\n\r\n1080x2460 pixels\r\nTính năng màn hình\r\n\r\nTần số quét 120Hz, 500 nits, Gamut phổ màu 85% NTSC\r\nCamera sau\r\n\r\nCamera sau\r\n\r\nCamera góc rộng: 108 MP, f/1.8, 0.64µm, AF\r\nCamera macro: 2 MP, f/2.4\r\nCamera phụ: 0.08 MP\r\nQuay video\r\n\r\n1440p@30fps\r\nTính năng camera\r\n\r\nĐèn flash LED bốn lớp, HDR, toàn cảnh\r\nCamera trước\r\n\r\nCamera trước\r\n\r\nCamera góc rộng: 32 MP, f/2.2\r\nQuay video trước\r\n\r\n1080p@30fps\r\nVi xử lý & đồ họa\r\n\r\nChipset\r\n\r\nMediatek Helio G99 (6nm)\r\nGPU\r\n\r\nMali-G57 MC2\r\nGiao tiếp & kết nối\r\n\r\nCông nghệ NFC\r\n\r\nCó\r\nThẻ SIM\r\n\r\n2 SIM (Nano-SIM)\r\nJack tai nghe 3.5\r\n\r\nCó\r\nHỗ trợ mạng\r\n\r\n4G\r\nGPS\r\n\r\nGPS, A-GPS\r\nRAM & lưu trữ\r\n\r\nDung lượng RAM\r\n\r\n8 GB\r\nBộ nhớ trong\r\n\r\n256 GB\r\nKhe cắm thẻ nhớ\r\n\r\nmicro SD\r\nPin & công nghệ sạc\r\n\r\nPin\r\n\r\n5000 mAh\r\nCông nghệ sạc\r\n\r\nSạc nhanh 33W, 5V/6.6A\r\nCổng sạc\r\n\r\nUSB Type-C\r\nTính năng khác\r\n\r\nHệ điều hành\r\n\r\nAndroid 13\r\nBộ xử lý & Đồ họa\r\n\r\nLoại CPU\r\n\r\nOcta-core CPU, Lên đến 2.2GHz\r\nKích thước & Trọng lượng\r\n\r\nKích thước\r\n\r\n168.6 x 76.6 x 8.25 mm\r\nTrọng lượng\r\n\r\n199g\r\nTiện ích khác\r\n\r\nCảm biến vân tay\r\n\r\nCảm biến vân tay cạnh bên\r\nCác loại cảm biến\r\n\r\nCảm biến tiệm cận, Cảm biến ánh sáng, La bàn, Con quay hồi chuyển, Cảm biến áp kế, Cảm biến trọng lực\r\nCổng kết nối\r\n\r\nWi-Fi\r\n\r\n802.11 a/b/g/n/ac\r\nThông số khác\r\n\r\nCông nghệ âm thanh\r\n\r\nLoa âm thanh nổi\r\nThông tin chung\r\n\r\nThời điểm ra mắt\r\n\r\n12/2023', 'Infinix hot', 'Infinix', 'uploads/infinixhot40pro.jpg,uploads/infinixhot40prop2.jpg,uploads/infinixhot40prop3.jpg', '2024-12-19 05:34:19', '2024-12-19 05:34:19', 'test', '1'),
	(47, 'Techno pova 6', 'bán hoặc đổi sang iphone ', 5990000.00, 'fan iphone', 'Techno pova', 'Techno', 'uploads/technopova6.jpg,uploads/technopova6p2.jpg', '2024-12-19 05:36:08', '2024-12-19 05:36:08', 'test', '1'),
	(48, 'Nubia neo 2', 'nâng đời nên đổi máy ', 3999999.00, 'giữ gìn kĩ nên không lo', 'Nubia neo', 'Nubia', 'uploads/nubia.jpg', '2024-12-19 05:37:42', '2024-12-19 05:37:42', 'test', '1');

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
  `status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '1',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='đây là bảng thông tin người dùng';

-- Dumping data for table thlvnn5.user: ~4 rows (approximately)
INSERT INTO `user` (`ID`, `username`, `password`, `fullname`, `birthday`, `email`, `sdt`, `address`, `status`) VALUES
	(1, 'admin', 'admin', 'admin', '2000-12-01', 'admin@gmail.com', 123456789, '01 Nguyễn Thái Học', '1'),
	(2, 'test', 'Hy_201004', 'Nguyễn Khang Hy', '2004-10-20', 'khanghynguyen15@gmail.com', 792456036, '07 Vũ Bảo, Ngô Mây, TP.Quy Nhơn', '1'),
	(3, 'hy', '1234', 'Nghy', '2000-10-20', 'nguyenhy2k4@gmail.com', 867901082, '09 vu bao', '1'),
	(4, 'hoangngu', '1234', 'Hồ Lê Hoàng', '2024-12-01', 'holehoang1903@gmail.com', 708731564, '01 NTH', '0');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
