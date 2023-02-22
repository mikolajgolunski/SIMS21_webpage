<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "abstract";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Abstract submission</title>
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

              <h1>Abstract submission</h1>

              <p>Abstract submission will open on <span class="important">February&nbsp;1, 2017</span> and close on <span class="important">April&nbsp;30, 2017</span>.</p>

              <?php if($testing_q):?>
              <hr>

              <p class="important">Content below created and available only because of tests!</p>
              <?php $_SESSION["next"] = true;?>
              <a href="abstract_upload1.php" class="button">UPLOAD ABSTRACT</a>
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
