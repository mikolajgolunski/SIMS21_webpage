<?php
require "./extras/always_require.php";

//check if logged in, if not send to login page and terminate the script
if(empty($_SESSION["login"])) {
  $_SESSION["last_site"] = "payment_card";
  header("Location:login.php");
  exit;
}
/*
//check if comes from proper page, if not send to first page of the module and terminate the script
if(
  ($_SESSION["last_site"] == "register_participant2" or
  $_SESSION["last_site"] == "register_accomp2") and
  $_SESSION["next"]
) {
} else {
  $_SESSION["last_site"] = "error";
  header("Location:register_participant1.php");
  exit;
}
*/
unset($_SESSION["next"]);

require('./database/db_connect.php');

$sql = "SELECT email, first_name, last_name FROM `people` WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["person_id"]));
$person_data = $stmt->fetch(PDO::FETCH_ASSOC);

$client_ip = $_SERVER["REMOTE_ADDR"];
$session_id = session_id();

$sql = "INSERT INTO payments (type, amount, session_id, ip, user_id, create_time) VALUES (:type, :amount, :session_id, :ip, :user_id, NULL)";
$stmt = $conn->prepare($sql);
$stmt->execute(array("type" => "card", "amount" => $cost, "session_id" => $session_id, "ip" => $client_ip, "user_id" => $_SESSION["person_id"]));

$id = $conn->lastInsertId();
$order_id = "SIMS21 order nr: ".$id;

$conn = null;

$params = "pos_id=".$pos_id."&payment_method=CARD&order_id=".$order_id."&session_id=".$session_id."&amount=".$cost."&currency=PLN&test=Y&language=en&client_ip=".$client_ip."&country=PL&email=".$person_data["email"]."&ba_firstname=".$person_data["first_name"]."&ba_lastname=".$person_data["last_name"];
$control_data = calculateControlData($pos_key, $params);

$_SESSION["last_site"] = "payment_card";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Payment by credit card</title>
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
              <h1>Payment by credit card</h1>
              <p>To pay using credit card please use go to the following site:</p>
              
              <form action="https://vpos.polcard.com.pl/vpos/ecom/channelService.htm" method="post">
                <input type='hidden' name='pos_id' value="<?php echo $pos_id;?>">
                <input type="hidden" name="payment_method" value="CARD">
                <input type='hidden' name='order_id' value="">
                <input type='hidden' name='session_id' value="">
                <input type='hidden' name='amount' value="">
                <input type='hidden' name='currency' value="PLN">
                <input type='hidden' name='test' value="Y">
                <input type='hidden' name='language' value="en">
                <input type='hidden' name='client_ip' value="<?php echo $client_ip;?>">
                
                
                
                <input type='hidden' name='country' value="PL">
                <input type='hidden' name='email' value="<?php echo $person_data["email"];?>">
                <input type='hidden' name='ba_firstname' value="<?php echo $person_data["first_name"];?>">
                <input type='hidden' name='ba_lastname' value="<?php echo $person_data["last_name"];?>">
                <input type='hidden' name='controlData' value="<?php echo $control_data;?>">
                
                <img src="./img/payeezy.png" alt="Payeezy logo" style="display: block; margin: 0 auto; width: 150px;">
                <input class="button" type="submit" value="Pay using credit card with Payeezy">
              </form>
            </div>

            <?php
          require("./includes/side.html");
          ?>

        </div>
    </div>
    <?php
    require("./includes/footer.html");
    unset($_SESSION["accomp"]);
    unset($_SESSION["register"]);
    ?>

  </body>

  </html>