<?php
session_start();
require "./extras/always_require.php";

//no need to check if logged in
//TODO Add logged in check

//no need to check if comes from proper page
//TODO Add transaction site origin

require("./database/db_connect.php");

if($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(!empty($_POST["payment"])) {
    $hash = generateSelector();
    
    $sql = "
    INSERT INTO payments (user_id, method, type, amount, cc_number_hash, create_time) VALUES (:user_id, 'other', 'other', :amount, :hash, NULL)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array("user_id" => $dummy_user_id, "amount" => $_POST["amount"], "hash" => $hash));
    $order_id = $conn->lastInsertId();
  }
}

$sql = "SELECT full_name, email, title FROM people WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($dummy_person_id));
$dummy_person = $stmt->fetch(PDO::FETCH_ASSOC);

$conn = null;


$_SESSION["last_site"] = "mod_additional_payment";
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
              <h1>Moderator view - register additional payment</h1>
              
              <p>Payment created here will be registered at the account of <?php echo $dummy_person["title"]." ".$dummy_person["full_name"];?> with mail <?php echo $dummy_person["email"];?> (person_id <?php echo $dummy_person_id;?>, user_id <?php echo $dummy_user_id;?>)</p>
              
              <?php if(!empty($_POST["payment"])):?>
              
              <p>Payment has been created.</p>
              <p>Amount: <?php echo $_POST["amount"];?> PLN</p>
              <p>Order id: <?php echo $order_id;?></p>
              <p>Link to the individual webpage: <a href="payment.php?id=<?php echo $hash;?>">http://<?php echo $_SERVER['HTTP_HOST'];?>/payment.php?id=<?php echo $hash;?></a></p>
              
              <?php else:?>
              
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="number" step="0.01" id="amount" name="amount" required>
                <label for="amount">Amount to pay (in PLN)</label>
                <input type="submit" name="payment" value="Create payment">
              </form>
              
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
