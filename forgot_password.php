<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

function send_mails($user_info) {
  require("./extras/PHPMailer/PHPMailerAutoload.php");
  require('./extras/mail_connect.php');
  $mail->addAddress($user_info["email"]);
  $mail->Subject = "Password successfully reset";
  $mail->Body = "Dear ".$user_info["login"].",\n\nYour password has been successfully reset.\n\nYour temporary password is: ".$user_info["temp_password"]."\n\nPlease change your temporary password as soon as possible.\n\nBest regards,\nSIMS21 Organizing Committee";
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
  }

  $mail = null;
}

$err = "";
$login = "";
$email = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["login"]) || empty($_POST["email"]))  {
    $err = "At least one of the required fields is empty. Please fill in all of the required fields.";
  }
  else {
    $login = test_input($_POST["login"]);
    $email = test_input($_POST["email"]);
    require('./database/db_connect.php');
    $sql = "SELECT COUNT(*) FROM `users` WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($login));
    if($stmt->fetchColumn() > 0) {
      $sql = "SELECT COUNT(*) FROM `people` WHERE email= ? AND id=(SELECT person_id FROM `users` WHERE username = ? LIMIT 1) LIMIT 1";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($email, $login));
      if($stmt->fetchColumn() > 0) {
        $temp_password = random_str(16);
        $hash = create_hash($temp_password);
        $sql = "UPDATE `users` SET password = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($hash, $login));

        $user_info = array("email" => $email, "login" => $login, "temp_password" => $temp_password);
        send_mails($user_info);
        
        $txt = "User ".$login." reset his/her password.";
        log_save($conn, "forgot_password", $txt);
        $conn = null;
        
        header("Refresh: 2; URL=login.php");
      } else {
        $err = "No such username and email combination in our database.";
      }
    } else {
      $err = "No such username and email combination in our database.";
    }

    $conn = null;
  }
}

$_SESSION["last_site"] = "index";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
require('./includes/head.html');
?>

      <title>SIMS21, Poland 2017 - Forgot password</title>
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
              <h1>Forgot password</h1>

              <form id="account" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."#openModal " ?>" method="post">
                <p>If you forgot your password please provide us with your username and email your account has been registered with.</p>
                <p>We will generate new, temporary password and send it to you. Please change the provided password as soon as possible. Keeping the password on your email account is not safe.</p>
                <fieldset>
                  <div class="form_entry form_forgot">
                    <label for="login">Username</label>
                    <input id="login" name="login" required placeholder="Username" tabindex="1" type="text">
                  </div>

                  <div class="form_entry form_forgot">
                    <label for="email">Email</label>
                    <input id="email" name="email" required placeholder="Email" tabindex="2" type="text">
                  </div>
                </fieldset>

                <input class="button important" name="forgot_button" id="forgot_button" tabindex="3" value="Submit" type="submit">
              </form>

              <div id="openModal" class="modalDialog">
                <div>
                  <a href="#close" title="Close" class="close">X</a>
                  <?php
                  if ($err == ""){
                    echo "<p>Temporary password has been sent. Please check your email.</p>";
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
