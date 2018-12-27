<?php

error_reporting(0);
//require_once('phpmailer/class.phpmailer.php');
require_once('phpmailer/PHPMailerAutoload.php');

$mail = new PHPMailer();


//$mail->SMTPDebug = 3;                               // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'tls://smtp.gmail.com:587';             // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'example@mail.com';      		  // SMTP username
$mail->Password = 'Password';                      	  // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$message = "";
$status = "false";

$okMessage = 'RSVP form successfully submitted. Thank you, I will get back to you soon!';
$errorMessage = 'There was an error while submitting the form. Please try again later';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if( $_POST['form_name'] != '' AND $_POST['form_email'] != '' AND $_POST['form_option'] != '' AND $_POST['form_option2'] != '' AND $_POST['form_name2'] != '' AND $_POST['form_name3'] != '') {

        $name = $_POST['form_name'];
        $name3 = $_POST['form_name3'];
        $email = $_POST['form_email'];
        $option = $_POST['form_option'];
        $option2 = $_POST['form_option2'];
		$name2 = $_POST['form_name2'];		
        $option4 = $_POST['form_option4'];

        $subject = isset($subject) ? $subject : 'New Message | RSVP Form';

        $botcheck = $_POST['form_botcheck'];

        $toemail = 'example@mail.com';                // Your Email Address
        $toname = 'Unlock Design';                     // Your Name

        if( $botcheck == '' ) {

            $mail->SetFrom( $email , $name );
            $mail->AddReplyTo( $email , $name );
            $mail->AddAddress( $toemail , $toname );
            $mail->Subject = $subject;

            $name = isset($name) ? "Name: $name<br><br>" : '';  
            $name3 = isset($name3) ? "Name: $name<br><br>" : '';      
            $email = isset($email) ? "Email: $email<br><br>" : '';     
            $option = isset($option) ? "Option: $option<br><br>" : '';
            $option2 = isset($option2) ? "Option 2: $option2<br><br>" : '';
			$name2 = isset($name2) ? "Guest Name: $name2<br><br>" : '';  

            $referrer = $_SERVER['HTTP_REFERER'] ? '<br><br><br>This Form was submitted from: ' . $_SERVER['HTTP_REFERER'] : '';

            $body = $name.' '.$email.' '.$option.' '.$option2.' '.$name2.' '.$referrer;

            $mail->MsgHTML( $body );
			$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			));
            $sendEmail = $mail->Send();

            if( $sendEmail == true ):
                $responseArray = array('type' => 'success', 'message' => $okMessage);
            else:
                $responseArray = array('type' => 'danger', 'message' => $errorMessage);
            endif;
        } else {
            $responseArray = array('type' => 'danger', 'message' => $errorMessage);
        }
    } else {
        $responseArray = array('type' => 'danger', 'message' => $errorMessage);
    }
} else {
    $responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

//$status_array = array( 'message' => $message, 'status' => $status);
//echo json_encode($status_array);

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    
    header('Content-Type: application/json');
    
    echo $encoded;
}
else {
    echo $responseArray['message'];
}
?>