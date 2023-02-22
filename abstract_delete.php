<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$abstract_id = $_SESSION["tmp"]["id"];
unset($_SESSION["tmp"]);

function send_mails($data) {
  require("./extras/PHPMailer/PHPMailerAutoload.php");
  require('./extras/mail_connect.php');
  $mail->addAddress("user@user.user", "SIMS21");
  $mail->Subject = "[Abstract deleted] ".$data["full_name"];
  $body = $data["full_name"]." deleted abstract titled: ".$data["title"];
  $mail->Body = $body;
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
    exit;
  }

  $mail = null;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["delete"])) {
    require('./database/db_connect.php');
    
    $sql = "SELECT title FROM abstracts WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($_POST["id"]));
    $title = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $sql = "SELECT GROUP_CONCAT(DISTINCT(id)) AS ids FROM `abstracts_to_people` WHERE abstract_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($_POST["id"]));
    $ids = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "DELETE FROM `abstracts_to_people` WHERE id IN (".$ids["ids"].")";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $sql = "DELETE FROM `abstracts` WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($_POST["id"]));
    
    $data = array(
      "full_name" => $_SESSION["full_name"],
      "title" => $title["title"]
    );
    
    send_mails($data);
    
    $txt = $_SESSION["full_name"]." (user_id: ".$_SESSION["user_id"].", person_id: ".$_SESSION["person_id"].") deleted his/her abstract (abstract_id: ".$_POST["id"].") titled: ".$title["title"];
    log_save($conn, "abstract_delete", $txt);
    
    $conn = null;
    
    header("Location:user_summary.php");
    exit;
  }
  
  if(isset($_POST["back"])) {
    header("Location:user_summary.php");
    exit;
  }
}

$_SESSION["last_site"] = "abstract_delete";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
    require('./includes/head.html');
    ?>

      <title>SIMS21, Poland 2017 - Delete abstract</title>
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
              <h1>Delete abstract</h1>
              
              <p>Are you sure you want to delete the abstract?</p>
              
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="hidden" name="id" value="<?php echo $abstract_id;?>">
                <input type="submit" value="Back" name="back">
                <input type="submit" value="Delete" name="delete">
              </form>
          
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
