<?php
require "./extras/always_require.php";

if($_SERVER["REQUEST_METHOD"] === "POST") {
  if($_POST["method"] == "user_id") {
    $_SESSION["mod"]["method"] = "user_id";
    $_SESSION["mod"]["user"]["id"] = test_input($_POST["user_id"]);
  } elseif($_POST["method"] == "full_name") {
    $_SESSION["mod"]["method"] = "full_name";
    $_SESSION["mod"]["person"]["full_name"] = test_input($_POST["full_name"]);
  } else {
    header("Location:mod_choose_user.php");
    exit;
  }
  
  header("Location:mod_choose_action.php");
  exit;
}

require "./database/db_connect.php";

$sql = "SELECT id, person_id FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute(array());
$users = array();
$person_ids = array();
while($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $users[$user["id"]] = $user;
  $person_ids[] = $user["person_id"];
}
$person_ids = implode(",", $person_ids);

$sql = "SELECT id, full_name FROM people WHERE id IN (".$person_ids.")";
$stmt = $conn->prepare($sql);
$stmt->execute(array());
$people = array();
while($person = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $people[$person["id"]] = $person;
}

$conn = null;
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
          <h1>Moderator view - user interaction</h1>
          <p>Choose user using one of the following methods.</p>
          <form id="choose" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off">
            <label for="method">Search method</label>
            <input type="radio" name="method" value="user_id">User ID
            <input type="radio" name="method" value="full_name" checked>Full name
            
            <hr>
            
            <label for="user_id">User ID</label>
            <input list="ids" name="user_id" id="user_id">
            <datalist id="ids">
              <?php
              foreach($users as $user) {
                echo "<option value=\"".$user["id"]."\">\n";
              }
              ?>
            </datalist>
            
            <label for="full_name">Full name</label>
            <input list="names" name="full_name" id="full_name">
            <datalist id="names">
              <?php
              foreach($users as $user) {
                echo "<option value=\"".$people[$user["person_id"]]["full_name"]."\">\n";
              }
              ?>
            </datalist>
            
            <br><br>
            
            <input type="submit" value="Choose" name="choose" id="choose">
          </form>
        </div>
    </div>

  </body>

  </html>