<?php
$mail = new PHPMailer;

$mail->isSMTP();
$mail->SMTPDebug = 0;
$mail->Debugoutput = "html";
$mail->Host = "host";
$mail->Port = 000;
$mail->SMTPSecure = "tls";
$mail->SMTPAuth = true;
$mail->Username = "user";
$mail->Password = "password";
$mail->setFrom("user@user.user", "SIMS21");

$mail->CharSet = "UTF-8";
$mail->Encoding = "base64";
?>