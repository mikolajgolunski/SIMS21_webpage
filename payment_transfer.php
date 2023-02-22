<?php
require "./extras/always_require.php";

//check if logged in, if not send to login page and terminate the script
if(empty($_SESSION["login"])) {
  $_SESSION["last_site"] = "payment_transfer";
  header("Location:login.php");
  exit;
}

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

$cost = $_SESSION["last_site"] == "register_participant2" ? $_SESSION["register"]["cost"] : $_SESSION["accomp"]["cost"];

$_SESSION["last_site"] = "payment_transfer";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Payment by bank transfer</title>
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
              <h1>Payment by bank transfer</h1> Please wire-transfer <span class="important"><?php echo $cost;?> PLN</span> to the account given below.
              <p><u>Bank account details:</u>
                <br>NAME OF THE BANK:
                <strong>X</strong>
                <br>ACCOUNT HOLDER:
                <strong>X</strong>
                <br>X
                <br>FISCAL ID:
                <br>ACCOUNT NUMBER (IBAN):
                <strong>X</strong>
                <br>SWIFT Code:
                <strong>X</strong>
                <br>REF:
                <strong><?php echo $_SESSION["full_name"];?> + SIMS21 Registration</strong>
              </p>
              <p>Please note that any extra charges associated with a fee payment must be covered by a sender.</p>
              <p><a href="print_transfer.php" target="_blank" class="button">Print bank account details</a></p>
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
