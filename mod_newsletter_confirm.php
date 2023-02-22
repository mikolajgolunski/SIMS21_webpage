<?php
require "./extras/always_require.php";

require("./extras/PHPMailer/PHPMailerAutoload.php");
require('./extras/mail_connect.php');

function send_mail_own($mail, $data, $msg) {
  $mail->addAddress("user@user.user", "SIMS21");
  $mail->Subject = "[Newsletter] ".$data["subject"];
  $mail->Body = $data["body"]."<br>\n<hr><br>\nMail sent to following addresses:<br>\n".implode("<br>\n", $data["mails_all"]);
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

function send_mail_log($mail, $data) {
  $mail->addAddress("mikolaj.golunski@gmail.com");
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

$mails = array();
require('./database/db_connect.php');
$sql = "SELECT email_send, selector, full_name FROM mail_list WHERE sent IS FALSE LIMIT 250";
$stmt = $conn->prepare($sql);
$stmt->execute();
$mails_q = false;
while($mail_address = $stmt->fetch(PDO::FETCH_ASSOC)){
  $mails[] = array("mail" => $mail_address["email_send"], "selector" => $mail_address["selector"], "full_name" => $mail_address["full_name"]);
  $mails_q = true;
}

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
  
  $sql = "UPDATE mail_list SET sent=TRUE WHERE email_send=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($mail_address["mail"]));
}
$conn = null;

$data = array(
  "subject" => $_SESSION["newsletter"]["subject"],
  "body" => $_SESSION["newsletter"]["body"],
  "mails_all" => $send_mails
);
$out = send_mail_own($mail, $data, $msg);
$mail = $out[0];
$msg = $out[1];
$send_mails[] = "user@user.user";

$data = implode("\n", $send_mails);
$mail = send_mail_log($mail, $data);

$mail = null;
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <link type="text/css" rel="stylesheet" href="./css/db_check.css">
    
      <script src="./extras/ckeditor/ckeditor.js"></script>

      <title>SIMS21, Poland 2017</title>
  </head>

  <body>
    <div id="main">
      <?php
      require("./includes/menu.php");
      ?>

        <div id="content">
          <h1>Moderator view - send newsletter</h1>
            
          <?php
          if($mails_q) {
            echo "<p>Newsletter has been sent.</p>";
            echo "<a href=\"mod_newsletter.php\" class=\"button\">Send next batch</a>";
          } else {
            echo "<p class=\"important\">There are no more emails in the mailing list</p>";
          }
          
          echo "<p><strong>SUBJECT:</strong><br>".$_SESSION["newsletter"]["subject"]."</p>";
          echo "<p><strong>BODY:</strong><br>".$_SESSION["newsletter"]["body"]."</p>";
          
          //echo "<p>".implode("", $msg)."</p>";
          ?>
        </div>
    </div>

  </body>

  </html>