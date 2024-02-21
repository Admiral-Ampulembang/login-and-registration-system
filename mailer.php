<?php
    // PHP MAILER
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    // Requires these 3 PHP files
    // download from this Github link: https://github.com/PHPMailer/PHPMailer (find files from the src folder)
    require 'PHPMailer-master/PHPMailer-master/src/Exception.php';
    require 'PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
    require 'PHPMailer-master/PHPMailer-master/src/SMTP.php';

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = TRUE;
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->Username = "jazzydonut123@gmail.com"; // Email sender; change to your email

    // Password -> acquire from Google Account in the Security section
    // 1. Go to your Google account: https://myaccount.google.com/security?hl=en
    // 2. Turn on 2-step verification
    // 3. Once 2-step verification is turned on, search for app passwords
    // 4. Google will ask you to enter a name for the app; just type in any name
    // 5. Once you confirmed, Google will generate a password; use that password and type it below (remove the spaces)
    $mail->Password = "xgmjltebiaonygvr";
    $mail->Host = "smtp.gmail.com";
    $mail->Mailer = "smtp";
    $mail->isHTML(true);

    return $mail;
?>