<?php
// Tải các tệp PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\OAuth;
//use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
//require 'PHPMailer/src/OAuth.php';
require 'PHPMailer/src/OAuthTokenProvider.php';
require 'PHPMailer/src/SMTP.php';

function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        // Cấu hình máy chủ SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Máy chủ SMTP của Gmail
        $mail->SMTPAuth = true; // Kích hoạt xác thực SMTP
        $mail->Username = 'csscellphonesellersystem@gmail.com'; // Địa chỉ email gửi
        $mail->Password = 'jzwn rool nbta lhzv'; // Mật khẩu ứng dụng Gmail (App Password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Mã hóa SSL
        $mail->Port = 465; // Cổng SMTP với mã hóa SSL

        // Cấu hình người gửi và người nhận
        $mail->setFrom('csscellphonesellersystem@gmail.com', 'CSS Admin'); // Địa chỉ email người gửi
        $mail->addAddress($email, 'Customer'); // Địa chỉ email người nhận

        // Nội dung email
        $mail->isHTML(true); // Sử dụng định dạng HTML
        $mail->Subject = "Mã OTP xác minh tài khoản"; // Chủ đề email
        $mail->Body = "Mã OTP của bạn là: <b>{$otp}</b>"; // Nội dung chính
        $mail->AltBody = "Mã OTP của bạn là: {$otp}"; // Nội dung thay thế (dành cho email không hỗ trợ HTML)
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
        // Gửi email
        $mail->send();
        return true; // Gửi thành công
    } catch (Exception $e) {
        // Trả về lỗi nếu có
        return "Lỗi khi gửi email: " . $mail->ErrorInfo;
    }
}
?>
