<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// 引入 Composer 自動加載器
require __DIR__ . '/vendor/autoload.php';

function generate_verification_code() {
    return substr(str_shuffle('0123456789'), 0, 6);
}

function send_verification_email($receiver_email, $verification_code) {
    $mail = new PHPMailer(true);

    try {
        // 服务器配置
        $mail->CharSet ="UTF-8";                     // 設定邮件编码
        $mail->SMTPDebug = 0;                        // 調適模式輸出
        $mail->isSMTP();                             // 使用SMTP
        $mail->Host = 'smtp.163.com';                // SMTP服务器
        $mail->SMTPAuth = true;                      // 允许 SMTP 认证
        $mail->Username = 'Abisu';                 // SMTP 用户名 即邮箱的用户名
        $mail->Password = 'abisu36268295';     // SMTP 密码 部分邮箱是授权码(例如163邮箱)
        $mail->SMTPSecure = 'ssl';                   // 允许 TLS 或者ssl协议
        $mail->Port = 465;                           // 服务器端口 25 或者465 具体要看邮箱服务器支持

        $mail->setFrom('abisu930118@gmail.com', 'Abisu');  // 發件人
        $mail->addAddress($receiver_email);  // 收件人

        $mail->addReplyTo('abisu930118@gmail.com', 'info'); // 回复的时候回复给哪个邮箱 建议和发件人一致

        // Content
        $mail->isHTML(true);                                  // 是否以HTML文档格式发送 发送后客户端可直接显示对应HTML内容
        $mail->Subject = '您的驗證碼';
        $mail->Body    = '<h1>您的驗證碼是：' . $verification_code . '</h1>';
        $mail->AltBody = '您的驗證碼是：' . $verification_code;

        $mail->send();
        echo '郵件發送成功';
    } catch (Exception $e) {
        echo '郵件發送失敗: ', $mail->ErrorInfo;
    }
}

// 使用范例
$verification_code = generate_verification_code();
send_verification_email('99135ddd@gmail.com', $verification_code);
?>
