<?php
require "./extras/always_require.php";

//check if logged in, if not send to login page and terminate the script

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

if(!empty($_POST["back"])) {
  $_SESSION["last_site"] = "payment";
  header("Location:user_summary.php");
  exit;
}

if($_SESSION["fee_type"] == "personal") {
  $fee_type = "personal_fee";
} elseif($_SESSION["fee_type"] == "accomp") {
  $fee_type = "accomp_fee";
}

require('./database/db_connect.php');
if(!empty($_GET["id"])) {
  $tmp_name = $_SESSION["full_name"];
  $_SESSION["full_name"] = "Your name here";
  
  $sql = "SELECT id, amount FROM payments WHERE user_id=:id AND cc_number_hash=:hash AND success IS NOT FALSE LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("id" => $dummy_user_id, "hash" => $_GET["id"]));
  $payment = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $sql = "SELECT email, first_name, last_name FROM `people` WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($dummy_person_id));
  $person_data = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
  $sql = "SELECT id, amount FROM payments WHERE user_id=:id AND type=:type AND success IS NOT FALSE LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("id" => $_SESSION["user_id"], "type" => $_SESSION["fee_type"]));
  $payment = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $sql = "SELECT email, first_name, last_name FROM `people` WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($_SESSION["person_id"]));
  $person_data = $stmt->fetch(PDO::FETCH_ASSOC);
}
  
$conn = null;

$order_id = "SIMS21 order nr ".$payment["id"];
$cost = $payment["amount"];
$cost_system = $cost*100;
$client_ip = $_SERVER["REMOTE_ADDR"];
$session_id = session_id();
$country = "PL";

if(!empty($_GET["id"])) {
  $params = "pos_id=".$pos_id."&payment_method=CARD&order_id=".$order_id."&session_id=".$session_id."&amount=".$cost_system."&currency=PLN&test=N&language=en&client_ip=".$client_ip."&country=".$country."&email=".$person_data["email"];
} else {
  $params = "pos_id=".$pos_id."&payment_method=CARD&order_id=".$order_id."&session_id=".$session_id."&amount=".$cost_system."&currency=PLN&test=N&language=en&client_ip=".$client_ip."&country=".$country."&email=".$person_data["email"]."&ba_firstname=".$person_data["first_name"]."&ba_lastname=".$person_data["last_name"];
}

$control_data = calculateControlData($pos_key, $params);

$_SESSION["last_site"] = "payment";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>
    <style type="text/css">
      #payeeze-logo {
        display: block;
        width: 150px;
        margin: 0 auto;
      }
      
      #pay-buttons {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
      }
    </style>

      <title>SIMS21, Poland 2017 - Payment</title>
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
              <h1>Payment<?php if($payment && $_SESSION["fee_type"] == "personal") {echo " - personal fee";} else if($payment && $_SESSION["fee_type"] == "accomp") {echo " - accompanying person(s) fee";}?></h1>
              <?php if($payment):?>
              <p class="important">Payment of <?php echo $cost;?>&nbsp;PLN</p>
              <h2>Credit card</h2>
              <p>To complete payment using credit card please go to the following site:</p>
              
              <img src="./img/payeezy.png" alt="Payeezy logo" id="payeeze-logo">
              
              <div id="pay-buttons">
                <form action="https://vpos.polcard.com.pl/vpos/ecom/channelService.htm" method="post">
                  <input type='hidden' name='pos_id' value="<?php echo $pos_id;?>">
                  <input type="hidden" name="payment_method" value="CARD">
                  <input type='hidden' name='order_id' value="<?php echo $order_id;?>">
                  <input type='hidden' name='session_id' value="<?php echo $session_id;?>">
                  <input type='hidden' name='amount' value="<?php echo $cost_system;?>">
                  <input type='hidden' name='currency' value="PLN">
                  <input type='hidden' name='test' value="N">
                  <input type='hidden' name='language' value="en">
                  <input type='hidden' name='client_ip' value="<?php echo $client_ip;?>">
                  <input type='hidden' name='country' value="<?php echo $country;?>">
                  <input type='hidden' name='email' value="<?php echo $person_data["email"];?>">
                  <?php if(empty($_GET["id"])):?>
                  <input type='hidden' name='ba_firstname' value="<?php echo $person_data["first_name"];?>">
                  <input type='hidden' name='ba_lastname' value="<?php echo $person_data["last_name"];?>">
                  <?php endif;?>
                  <input type='hidden' name='controlData' value="<?php echo $control_data;?>">

                  <input type="submit" name="pay" id="pay" value="Pay using credit card with Payeezy">
                </form>
              </div>
              
              <h2>Bank transfer</h2>
              <p>Please wire-transfer <span class="important"><?php echo $cost;?>&nbsp;PLN</span> to the account given below.</p>
              
              <p><?php echo get_bank_transfer_html($_SESSION["full_name"]);?></p>
              
              <p><a href="print_transfer.php<?php echo !empty($_GET["id"]) ? "?id=".test_input($_GET["id"]) : "";?>" target="_blank" class="button">Print bank account details</a></p>
              <?php else:?>
              <p>There is no such transaction in our database. Please try again or contact SIMS21 organizers.</p>
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

<?php
if(!empty($_GET["id"])) {
  $_SESSION["full_name"] = $tmp_name;
}
?>