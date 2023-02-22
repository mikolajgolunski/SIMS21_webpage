<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

function send_mails($user_name, $user_mail) {
  require("./extras/PHPMailer/PHPMailerAutoload.php");
  require('./extras/mail_connect.php');
  $mail->addAddress("user@user.user", "SIMS21");
  $mail->Subject = "New mail registered for newsletter: ".$user_mail. "(".$user_name.")";
  $mail->Body = "New mail registered for newsletter: ".$user_mail." by ".$user_name;
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
  }
  $mail = null;

  require('./extras/mail_connect.php');
  $mail->addAddress($user_mail);
  $mail->Subject = "Mail registered for newsletter";
  $mail->Body = "Dear ".$user_name.",\nYour email has been successfully added to the SIMS mail list.\nThanks\n\n";
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
    $mail = strtolower(test_input($_POST["email"]));
    $name = test_input($_POST["full_name"]);
    require('./database/db_connect.php');
    $sql = "SELECT COUNT(*) FROM `mail_list` WHERE email_send = '".$mail."' LIMIT 1";
    $mail_count = $conn->query($sql);
    if($mail_count->fetchColumn() > 0) {
      $err = "Email already present in the database.";
    } else {
      $selector = generateSelector();
      $sql = "INSERT INTO `mail_list` SET email_send=?, full_name=?, selector=?, create_time=NULL";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($mail, $name, $selector));
      send_mails($name, $mail);
    }
    $conn = null;
  }
}
$_SESSION["last_site"] = "newsletter";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require('./includes/head.html');
  ?>
  
  <style type="text/css">
    .social-media {
      text-align: center;
    }
    
    .social-media a {
      text-decoration: none;
      color: inherit;
    }
  </style>
  
  <title>SIMS Community Maillist</title>
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
            <h1>SIMS Mailing List</h1>
            
            <p>If you would like to get the news useful for the SIMS community members, please leave your email.</p>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."#openModal"; ?>" method="post">
            <label for="full_name">Full name</label>
            <input id="full_name" name="full_name" placeholder="Full name" type="text" required>
            <label for="email">Email</label>
            <input id="email" name="email" placeholder="Email" type="email" required>
            <input class="button" name="submit" value="Submit" type="submit">
            </form>
            
            <div id="openModal" class="modalDialog">
              <div>
                <a href="#close" title="Close" class="close">X</a>
                <?php
                if ($err == ""){
                  echo "<p>Your email has been registred in our database.</p>";
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
