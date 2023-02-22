<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

function send_mails($email) {
  require("./extras/PHPMailer/PHPMailerAutoload.php");
  require('./extras/mail_connect.php');
  $mail->addAddress("user@user.user", "SIMS21");
  $mail->Subject = "New email address ".$email;
  $mail->Body = "There is a new email address added to the mailing list: ".$email."\nDatabase preview can be found at XXX";
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
  }

  $mail = null;

  require('./extras/mail_connect.php');
  $mail->addAddress($email);
  $mail->Subject = "Email successfully added";
  $mail->Body = "Dear ".$email.",\n\nYour email has been successfully added to our database. We will inform you when the registration opens.\n\nThank you,\nSIMS2017 Organizers";
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
  }

  $mail = null;
}

$emailErr = "";
$email = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["email"])) {
    $emailErr = "Email field cannot be empty.";
  }
  else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format.";
    }
    else {
      require('./database/db_connect.php');
      $sql = "SELECT COUNT(*) FROM `mail_list` WHERE email_send = ?";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($email));
      if ($stmt->fetchColumn() > 0) {
        $emailErr = "Email already present in the database.";
      } else {
        $sql = "INSERT INTO `mail_list` SET email_send=?, create_time=NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($email));
      }
      $conn = null;
    }
  }
}

$_SESSION["last_site"] = "mailing_list";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Mailing list</title>
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
              <h1>Mailing list</h1>

              <p>Details of registration will be given at the beginning of 2017.</p>

              <p>Please leave your email address if you wish to receive future messages.</p>

              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."#openModal ";?>" method="post">
                <input type="email" name="email" value="<?php echo $email;?>">
                <br>
                <input type="submit" value="Submit">
              </form>

              <div id="openModal" class="modalDialog">
                <div>
                  <a href="#close" title="Close" class="close">X</a>
                  <?php
                  if ($emailErr == "" and $email != "") {
                    echo "<p>Your email: ".$email." got registered in our database.</p>";
                    send_mails($email);
                  } else {
                    echo "<p>".$emailErr."</p>";
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