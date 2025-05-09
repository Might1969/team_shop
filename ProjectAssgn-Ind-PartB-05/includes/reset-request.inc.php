<?php
if (isset($_POST['reset-request-submit'])) {
    // 增强输入验证
    $userEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../reset-password.php?error=invalidemail");
        exit();
    }

    // 生成安全令牌
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $validator = bin2hex($token);
    $expires = date("U") + 1800; // 30分钟有效期
    $url = "http://".$_SERVER['HTTP_HOST']."/indi_shop/ProjectAssgn-Ind-PartB-05/create-new-password.php?selector=".$selector."&validator=".$validator;

    // 数据库操作
    require 'dbh.inc.php';

    // 使用事务处理
    mysqli_begin_transaction($conn);
    try {
        // 删除旧令牌
        $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            throw new Exception("SQL delete error");
        }
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);

        // 插入新令牌
        $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if (!$stmt) {
            throw new Exception("SQL insert error");
        }
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);

        mysqli_commit($conn);
    } catch (Exception $e) {
        mysqli_rollback($conn);
        error_log("[".date('Y-m-d H:i:s')."] Database Error: ".$e->getMessage()."\n", 3, __DIR__."/../logs/db_errors.log");
        header("Location: ../reset-password.php?error=sqlerror");
        exit();
    } finally {
        if (isset($stmt)) {
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    }

    // PHPMailer配置
    try {
        require realpath(__DIR__ . '/../vendor/autoload.php');
        
        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.126.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'gsnlkgzh@126.com';
        $mail->Password = 'PUjqB39TskeWZVKV'; 
        $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;


        // 邮件内容
        $mail->setFrom('gsnlkgzh@126.com', 'Password Service');
        $mail->addAddress($userEmail);
        $mail->Subject = 'Password Reset Request';
        
        $htmlContent = "<p>We received a password reset request. Click below to reset:</p>
                       <p><a href='$url'>Reset Password</a></p>
                       <p>Or copy this link: <code>$url</code></p>
                       <p><em>Link expires in 30 minutes</em></p>";
        
        $mail->isHTML(true);
        $mail->Body = $htmlContent;
        $mail->AltBody = "Password reset link: $url";

        // 验证邮件是否可发送
        if (!$mail->smtpConnect()) {
            throw new Exception('SMTP connect failed');
        }
        
        $mail->send();
        
        // 成功重定向
        header("Location: ../reset-password.php?reset=success");
        exit();
    } catch (Exception $e) {
        // 记录详细错误
        $errorMsg = "Mail Error: ".$e->getMessage()."\nPHPMailer Error: ".$mail->ErrorInfo."\n";
        error_log("[".date('Y-m-d H:i:s')."] ".$errorMsg, 3, __DIR__."/../logs/mail_errors.log");
        
        // 重定向带调试信息（生产环境应移除）
        header("Location: ../reset-password.php?error=mailerror&debug=".urlencode($errorMsg));
        exit();
    }
} else {
    header("Location: ../reset-password.php");
    exit();
}
