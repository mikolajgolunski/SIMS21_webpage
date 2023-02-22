<?php
require "./extras/always_require.php";

if(!empty($_POST["decode"])) {
  $decoded = decrypt($_POST["data"], $pass);
  $data = explode("_", $decoded);
  $data = array("id"=>$data[0], "number"=>$data[1], "owner"=>$data[2], "month"=>$data[3], "year"=>$data[4]);
}
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
          <h1>Moderator view - decode credit card data</h1>

          <form id="decoding" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <label for="data">Input data to decode</label>
            <input type="text" name="data" id="data" required>
            <input type="submit" name="decode" id="decode" value="Decode!">
          </form>

          <h3>Decoded data</h3>
          <p>
            <?php
            echo $data["number"]."<br>";
            echo $data["owner"]."<br>";
            echo $data["month"]."/".$data["year"];
            ?>
          </p>
        </div>
    </div>

  </body>

  </html>