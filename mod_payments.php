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
      <h1>Moderator view - payments section</h1>

      <p>
        What would you like to do?
        <ul>
          <li><a href="./mod_add_transaction.php">Register transaction</a></li>
          <li><a href="./mod_edit_cost.php">Edit costs for individual users</a></li>
        </ul>
      </p>
    </div>
  </div>

</body>

</html>