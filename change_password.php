<?php
require "./extras/always_require.php";

if (!isset($_SESSION["login"])) {
  $_SESSION["last_site"] = "change_password";
  header("Location:login.php");
  exit;
}

//no need to check if comes from proper page

$err = "";
$old_password = "";
$new_password = "";
$re_new_password = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["old_password"]) || empty($_POST["new_password"]) || empty($_POST["re_new_password"])) {
    $err = "At least one of the required fields is empty. Please fill in all of the required fields.";
  }
  else {
    $old_password = test_input($_POST["old_password"]);
    $new_password = $_POST["new_password"];
    $re_new_password = $_POST["re_new_password"];
    if ($new_password != $re_new_password) {
      $err = "Both new passwords are different. Please check for typing errors.";
    }
    else {
      require('./database/db_connect.php');
      $sql = "SELECT password FROM `users` WHERE id=? LIMIT 1";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($_SESSION["user_id"]));
      $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
      $user_password = $user_data["password"];

      if (hash_equals($user_password, crypt($old_password, $user_password))) {
        $hash = create_hash($new_password);
        $sql = "UPDATE `users` SET password=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($hash, $_SESSION["user_id"]));
        
        $txt = $_SESSION["full_name"]." (user_id: ".$_SESSION["user_id"].", person_id: ".$_SESSION["person_id"].") changed his/her password.";
        log_save($conn, "change_password", $txt);
        
      } else {
        $err = "Wrong old password.";
      }

      $conn = null;
    }
  }
}

$_SESSION["last_site"] = "change_password";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
require('./includes/head.html');
?>

      <title>SIMS21, Poland 2017 - Change password</title>
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
              <h1>Change password</h1>

              <form id="account" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."#openModal " ?>" method="post">
                <fieldset>
                  <div class="form_entry form_password">
                    <label for="old_password">Old password</label>
                    <input id="old_password" name="old_password" required tabindex="1" type="password">
                  </div>

                  <div class="form_entry form_password">
                    <label for="new_password">New password</label>
                    <input id="new_password" name="new_password" required tabindex="3" type="password">
                  </div>

                  <div class="form_entry form_password">
                    <label for="re_new_password">Retype new password</label>
                    <input id="re_new_password" name="re_new_password" required tabindex="4" type="password">
                  </div>
                </fieldset>

                <input class="button important" name="change_pass" id="change_pass_button" tabindex="5" value="Change password" type="submit">
              </form>

              <div id="openModal" class="modalDialog">
                <div>
                  <a href="#close" title="Close" class="close">X</a>
                  <?php
                  if ($err == ""){
                    echo "<p>Your password has been changed.</p>";
                  } else {
                    echo "<p>".$err."</p>";
                  }
                  ?>
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
