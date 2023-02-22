<?php

header("Location:oral_table.php");
exit;

/*

require "./extras/always_require.php";

function send_mails($user_mail) {
  require("./extras/PHPMailer/PHPMailerAutoload.php");
  require('./extras/mail_connect.php');
  $mail->addAddress("user@user.user", "SIMS21");
  $mail->Subject = "New mail registered for newsletter: ".$user_mail;
  $mail->Body = "New mail registered for newsletter: ".$user_mail;
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
  }
  $mail = null;

  require('./extras/mail_connect.php');
  $mail->addAddress($user_mail);
  $mail->Subject = "Mail registered for newsletter";
  $mail->Body = "Your email has been successfully registered for SIMS21 newsletter.\n\nBest regards,\nSIMS21 Organizing Comitee";
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
  }

  $mail = null;
}

$err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty($_POST["email"]) || $_POST["email"] == ""){
    $err = "You did not enter valid email address.";
  }
  elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $err = "You did not enter valid email address.";
  }
  else {
    $mail = test_input($_POST["email"]);
    require('./database/db_connect.php');
    $sql = "SELECT COUNT(*) FROM `mail_list` WHERE email_send = '".$mail."' LIMIT 1";
    $mail_count = $conn->query($sql);
    if($mail_count->fetchColumn() > 0) {
      $err = "Email already present in the database.";
    } else {
      $sql = "INSERT INTO `mail_list` SET email_send = '".$mail."', create_time = NULL";
      $conn->query($sql);
      send_mails($mail);
    }
    $conn = null;
  }
}

$_SESSION["last_site"] = "schedule";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        table {
          margin: 0 auto;
        }
        
        thead {
          font-weight: bold;
        }
        
        td {
          width: 100px;
          height: 30px;
          border-bottom-style: solid;
          border-bottom-width: 1px;
        }
        
        .table_head {
          width: 200px;
        }
        
        .auto-style6 {
          text-align: center;
          height: 26px;
        }
      </style>

      <title>SIMS21, Poland 2017 - Scientific Program</title>
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
              <h1>Scientific Program</h1>
              <p class="important">More details about scientific program will be provided on June 1, 2017.</p>

              <p>If you would like to get all of the news regarding SIMS21 conference please leave your email for our newsletter.</p>

              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."#openModal "; ?>" method="post">
                <label for="email">Email</label>
                <input id="email" name="email" placeholder="Email" type="email" required>
                <input class="button" name="submit" value="Submit" type="submit">
              </form>

              <div id="openModal" class="modalDialog">
                <div>
                  <a href="#close" title="Close" class="close">X</a>
                  <?php
                  if ($err == ""){
                    echo "<p>Your email has been registered in our database. We will send you mail if there are any news regarding SIMS21 conference.</p>";
                  } else {
                    echo "<p>".$err."</p>";
                  }
                  ?>
                </div>
              </div>
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
  */
  ?>