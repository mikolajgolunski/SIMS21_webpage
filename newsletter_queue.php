<?php
require "./extras/always_require.php";

require("./extras/PHPMailer/PHPMailerAutoload.php");
require('./extras/mail_connect.php');

function send_mail_own($mail, $data, $msg) {
  $mail->addAddress("user@user.user", "SIMS21");
  $mail->Subject = "[Newsletter] ".$data["subject"];
  $mail->Body = $data["body"]."<br>\n<hr><br>\nAbove mail send to:<br>\n".implode("<br>\n", $data["mails"]);
  $mail->IsHTML(true);
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo . "<br><hr><br>\n";
    echo "<p>".implode("", $msg)."</p>";
    exit;
  } else {
    $msg[] = "Message sent to user@user.user<br>\n";
  }
  $mail->clearAddresses();
  return array($mail, $msg);
}

function send_mail($mail, $data, $msg) {
  $mail->addAddress($data["mail"]);
  $mail->Subject = $data["subject"];
  $mail->Body = $data["body"];
  $mail->IsHTML(true);
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo . "<br><hr><br>\n";
    echo "<p>".implode("", $msg)."</p>";
    exit;
  } else {
    $msg[] = "Message sent to ".$data["mail"]."<br>\n";
  }
  $mail->clearAddresses();
  return array($mail, $msg);
}

function send_mail_log($data) {
  $mail->addAddress("user@user.user");
  $mail->Subject = "[LOG] Newletter";
  $mail->Body = $data;
  $mail->IsHTML(true);
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo . "<br><hr><br>\n";
    exit;
  }
  $mail->clearAddresses();
  return $mail;
}

require('./database/db_connect.php');

$mails = array();

$sql = "SELECT email_send, full_name, selector FROM mail_list WHERE send=FALSE LIMIT 300";
$stmt = $conn->prepare($sql);
$stmt->execute();

$mails_q = false;
while($mail_address = $stmt->fetch(PDO::FETCH_ASSOC)){
  $mails[] = array("mail" => $mail_address["email_send"], "selector" => $mail_address["selector"], "full_name" => $mail_address["full_name"]);
  $mails_q = true;
}

$conn = null;

if($mails_q) {

  $msg = array();
  $send_mails = array();

  foreach($mails as $mail_address){
    $name = (empty($mail_address["full_name"]) ? "Colleague" : $mail_address["full_name"]);
    $body_txt = str_replace("___FULLNAME___", $name, $_SESSION["newsletter"]["body"]);
    $footer_txt = "<p>----------</p><p>If you would like to unsubscribe from the SIMS21 newsletter please click the following link: <a href=\"http://sims.confer.uj.edu.pl/unsubscribe.php?id=".$mail_address["selector"]."\">http://sims.confer.uj.edu.pl/unsubscribe.php?id=".$mail_address["selector"]."</a></p>";
    $mail_txt = $body_txt.$footer_txt;

    $data = array(
      "subject" => $_SESSION["newsletter"]["subject"],
      "body" => $mail_txt,
      "mail" => $mail_address["mail"]
    );

    $out = send_mail($mail, $data, $msg);
    $mail = $out[0];
    $msg = $out[1];
    $send_mails[] = $mail_address["mail"];
  }

  $data = array(
    "subject" => $_SESSION["newsletter"]["subject"],
    "body" => $_SESSION["newsletter"]["body"].
    "mails" => $send_mails;
  );
  $out = send_mail_own($mail, $data, $msg);
  $mail = $out[0];
  $msg = $out[1];
  $send_mails[] = "user@user.user";

  $data = implode("\n", $send_mails);
  $mail = send_mail_log($data);
}

$mail = null;
?>
