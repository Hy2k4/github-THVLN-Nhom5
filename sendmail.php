<?php
//require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendOTP($email, $otp) {
    $mail = new PHPMailer(true);

    try {
        // Cài đặt máy chủ
        $mail->SMTPDebug = 0; 
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'csscellphonesellersystem@gmail.com';
        $mail->Password = 'mojp dvmb dkdr fqlr';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Mã hóa TLS
        $mail->Port = 465; // Cổng TLS

        // Người gửi và người nhận
        $mail->setFrom('nguyenhy2k4@gmail.com', 'Admin');
        $mail->addAddress($email,'Customer');

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = 'Verify ID OTP';
        $mail->Body = 'Mã OTP của bạn là: <b>' . $otp . '</b>';
        $mail->AltBody = 'Mã OTP của bạn là: ' . $otp;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Lỗi khi gửi email: {$mail->ErrorInfo}";
    }
}
?>
