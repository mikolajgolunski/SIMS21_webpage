<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$email = null;
if(!empty($_GET["id"])){

  require('./database/db_connect.php');

  $sql = "SELECT id, email_send FROM mail_list WHERE selector=? LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($_GET["id"]));
  $mail = $stmt->fetch(PDO::FETCH_ASSOC);

  if(!empty($mail["id"])) {
    $email = $mail["email_send"];
    $sql = "DELETE FROM mail_list WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($mail["id"]));
    
    $txt = "Email: ".$email."has been removed from the mailing list.";
    log_save($conn, "unsubscribe", $txt);
  }

  $conn = null;
}

$_SESSION["last_site"] = "unsubscribe";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
    require('./includes/head.html');
    ?>

    <style type="text/css">
    </style>
      <title>SIMS21, Poland 2017</title>
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
              <h1>Unsubscribe</h1>

              <?php if(!empty($email)):?>
                <p>Email <strong><?php echo $email;?></strong> has been removed from the SIMS21 newsletter.</p>
              <?php else:?>
                <p>Could not unsubscribe from the SIMS21 newsletter. Wrong email identification. Please try again or contact website administrator: <a href="mailto:golunski@sims21.org">golunski@sims21.org</a></p>
              <?php endif;?>
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