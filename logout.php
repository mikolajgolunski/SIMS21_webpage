<?php
require "./extras/always_require.php";

$_SESSION["last_site"] = "logout";

header("Refresh: 2; URL=index.php");
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
require('./includes/head.html');
?>

      <title>SIMS21, Poland 2017 - Logout</title>
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
              <h1>Logout</h1>

              <p>Logout page.</p>

              <div id="openModal" class="modalDialog">
                <div>
                  <?php
                    session_unset();
                    session_destroy();
                  ?>
                    <p>Logging out of your session. You should be automatically redirected to the main page after successful logout. If it does not happen please click this <a href="index.php">link</a>.</p>
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
