<?php
//TODO Przycisk przekierowujacy do ponownej zaplaty
session_start();
require "./extras/always_require.php";

//no need to check if logged in
//TODO Add logged in check

//no need to check if comes from proper page
//TODO Add transaction site origin

function send_mails($full_name, $error) {
  require("./extras/PHPMailer/PHPMailerAutoload.php");
  require('./extras/mail_connect.php');
  $mail->addAddress("user@user.user", "SIMS21");
  $mail->Subject = "Card payment rejected: ".$full_name;
  $body = $full_name."s payment has been rejected.";
  if(!empty($error)) {
    $body = $body."\n\nError: ".$error["code"]."\n".$error["message"];
  }
  $mail->Body = $body;
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
  }
  $mail = null;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {

  require('./database/db_connect.php');
  
  $order_id = array_pop(explode(" ", $_POST["order_id"]));

  $sql = "SELECT user_id, cc_number_hash, type, method FROM payments WHERE id=? LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($order_id));
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  $user_id = $user["user_id"];

  $sql = "SELECT person_id FROM users WHERE id=? LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($user_id));
  $person = $stmt->fetch(PDO::FETCH_ASSOC);
  $person_id = $person["person_id"];

  $sql = "SELECT full_name FROM people WHERE id=? LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($person_id));
  $person = $stmt->fetch(PDO::FETCH_ASSOC);
  $full_name = $person["full_name"];
  
  $conn = null;
  
  if(!empty($_POST["err_code"])) {
    $error = array(
      "code" => $_POST["err_code"],
      "message" => $_POST["message"]
    );
  } else {
    $error = null;
  }

  //send_mails($full_name, $error);
}

$_SESSION["last_site"] = "rejected";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
    require('./includes/head.html');
    ?>

    <style type="text/css">
    </style>
      <title>SIMS21, Poland 2017 - Payment rejected</title>
  </head>

  <body>
    <div id="wrapper">
      <?php
    require('./includes/header.html');
    ?>

        <div id="main">
          <?php
        require("./includes/menu.php");
        ?>

            <div id="content">
              <h1>Payment rejected</h1>
              
              <p>Your credit card payment has been rejected. Please check if information provided was correct.</p>
            </div>

            <?php
          require("./includes/side.html");
          ?>

        </div>
    </div>
    <?php
  require("./includes/footer.html");
  ?>

  </body>

  </html>