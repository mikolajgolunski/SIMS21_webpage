<?php
require "./extras/always_require.php";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <link type="text/css" rel="stylesheet" href="./css/db_check.css">

      <title>SIMS21, Poland 2017</title>
  </head>

  <body>
    <div id="main">
      <?php
      require("./includes/menu.php");
      ?>

        <div id="content">
          <h1>Moderator view - download database backup</h1>
          <p>Click the button below to download the .sql file with database backup created using mysqldump.</p>
          <a href="<?php echo htmlspecialchars("download_backup.php"); ?>" class="button">Download</a>
        </div>
    </div>

  </body>

  </html>