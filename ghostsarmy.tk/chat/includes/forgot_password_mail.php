<?php
defined('FORGET_PASS_MAILER_PROTECTION') || die("No direct access, back off");
require 'includes/PHPMailer/PHPMailerAutoload.php';

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='smtp_host'");
if($row = mysqli_fetch_assoc($sql)) {
$smtp_host = xss($row['option_value']);
}

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='smtp_port'");
if($row = mysqli_fetch_assoc($sql)) {
$smtp_port = xss($row['option_value']);
}

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='smtp_username'");
if($row = mysqli_fetch_assoc($sql)) {
$smtp_username = xss($row['option_value']);
}

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='smtp_password'");
if($row = mysqli_fetch_assoc($sql)) {
$smtp_password = xss($row['option_value']);
}

$sql = $conn->query("SELECT option_value FROM settings WHERE option_name='site_title'");
if($row = mysqli_fetch_assoc($sql)) {
$site_title = xss($row['option_value']);
}

$sql=$conn->query("SELECT userName, userEmail FROM users WHERE userEmail='$email'");
if($row = mysqli_fetch_assoc($sql)) {
$username = $row['userName'];
$useremail = $row['userEmail'];
}




$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = $smtp_host;  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = $smtp_username;                 // SMTP username
$mail->Password = $smtp_password;                           // SMTP password
if($smtp_port==587) {
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted	
} elseif ($smtp_port==465) {
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
}
$mail->Port = $smtp_port;                                    // TCP port to connect to

$mail->setFrom($smtp_username, $site_title);
$mail->addAddress($useremail, $username);     // Add a recipient

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $messages['subject'].$site_title;
$mail->Body    = $messages['htmlbody'].$msg."<br /><br />".$messages['htmlbody2'].$site_title;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    //echo 'Message could not be sent.';
    //echo 'Mailer Error: ' . $mail->ErrorInfo;
	mail($email,"Password reset link",$messages['htmlbody'].$msg."<br /><br />".$messages['htmlbody2'].$site_title,"Content-type:text/html;charset=UTF-8" . "\r\n"."From: noreply@leochat.info");
} else {
    //echo 'Message has been sent';
}