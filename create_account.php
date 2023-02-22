<?php
require "./extras/always_require.php";

if (isset($_SESSION["login"])) {
  $_SESSION["last_site"] = "error";
  header("Location:index.php");
  exit;
}

//no need to check if comes from proper page

$_SESSION["last_site"] = "create_account";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
require('./includes/head.html');
?>

      <title>SIMS21, Poland 2017 - Create new account</title>
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
              <h1>Create new account</h1>

              <p>Creation of new accounts has been discontinued.</p>
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
