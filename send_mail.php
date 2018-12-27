<?php
    require_once("inc/config.php");
    require_once("inc/functions.php");

    $mailto = $_POST['mail_to'];
    $mailSub = "From matching 22222222222";
    $mailMsg = "Hello world";
    require 'PHPMailer-master/PHPMailerAutoload.php';
    $mail = new PHPMailer(true);
    $mail ->IsSmtp();
    $mail ->SMTPDebug = 0;
    $mail ->SMTPAuth = true;
    $mail ->SMTPSecure = 'ssl';
    $mail ->Host = "smtp.gmail.com";
    $mail ->Port = 465; // or 587
    $mail ->IsHTML(true);
    $mail ->Username = "****";//ใส่เมลตัวเอง
    $mail ->Password = "xxxx";//ใส่ password ของตัวเอง
    $mail ->SetFrom("****");//ใส่เมลตัวเอง
    $mail ->Subject = $mailSub;
    $mail ->Body = $mailMsg;
    foreach($mailto as $address) {
        $mail ->AddAddress($address);
    }

    if(!$mail->Send())
    {
        // Failed
        echo "<script>
                alert('Unable to send email.');
                window.location.href='admin.php';
            </script>";
    }
    else
    {
        // Success
        echo "<script>
                alert('Your mail has been sent successfully!');
                window.location.href='admin.php';
            </script>";
    }
