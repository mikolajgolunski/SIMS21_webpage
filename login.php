<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$err = "";
$login = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
  if(empty($_POST["login"]) || empty($_POST["login_password"])) {
    $err = "At least one of the required fields is empty. Please fill in all of the required fields.";
  } else {
    $login = test_input($_POST["login"]);
    require('./database/db_connect.php');
    $sql = "SELECT COUNT(*) FROM `users` WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($login));
    
    if($stmt->fetchColumn() > 0) {
      $sql = "SELECT id, password, access_type, person_id, accomp_persons FROM `users` WHERE username = ? LIMIT 1";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($login));
      $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

      if (hash_equals($user_data["password"], crypt(trim($_POST["login_password"]), $user_data["password"]))) {
        $_SESSION["login"] = $login;
        $_SESSION["access_type"] = $user_data["access_type"];
        $_SESSION["user_id"] = $user_data["id"];
        $_SESSION["person_id"] = $user_data["person_id"];

        $sql = "SELECT registered, full_name FROM `people` WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($_SESSION["person_id"]));
        $person_data = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION["registered"] = $person_data["registered"];
        $_SESSION["full_name"] = $person_data["full_name"];
        $_SESSION["accomp_nr"] = $user_data["accomp_persons"];
        if($user_data["accomp_persons"] > 0) {
          $sql = "SELECT type, amount FROM payments WHERE user_id=:id AND success=TRUE";
          $stmt = $conn->prepare($sql);
          $stmt->execute(array("id" => $_SESSION["user_id"]));
          $paid = array("personal" => 0.0, "accomp" => 0.0);
          while($answer = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $paid[$answer["type"]] += $answer["amount"];
          }
          $_SESSION["paid"] = $paid;
        }
        
        $sql = "SELECT affiliation_id FROM `affiliations_to_people` WHERE person_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($_SESSION["person_id"]));
        $affiliations_ids = array();
        while($affiliations_ids_data = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $affiliations_ids[] = $affiliations_ids_data["affiliation_id"];
        }
        $_SESSION["affiliation_id"] = $affiliations_ids[0];

        $conn = null;
        if($_SESSION["last_site"] == "registration") {
          $_SESSION["last_site"] = "login";
          header("Location: register_participant1.php");
          //header("Refresh: 2; URL=register_participant1.php");
          exit;
        } else if(empty($_SESSION["last_site"]) or $_SESSION["last_site"] == "error") {
          $_SESSION["last_site"] = "login";
          header("Location: index.php");
          //header("Refresh: 2; URL=index.php");
          exit;
        } elseif($_SESSION["last_site"] == "newsletter") {
          $_SESSION["last_site"] = "login";
          header("Location: index.php");
          exit;
        } else {
          header("Location: ".$_SESSION["last_site"].".php");
          $_SESSION["last_site"] = "login";
          //header("Refresh: 2; URL=".$_SESSION["last_site"].".php");
          exit;
        }

      } else {
        $err = "Wrong login or password.";
      }
    } else {
      $err = "Wrong login or password.";
    }

    $conn = null;
  }
}
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
require('./includes/head.html');
?>

      <title>SIMS21, Poland 2017 - Login</title>
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
              <h1>Login</h1>

              <form id="account" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <fieldset>
                  <div class="form_entry form_login">
                    <label for="login">Username</label>
                    <input id="login" name="login" required placeholder="Username" tabindex="1" type="text">
                  </div>

                  <div class="form_entry form_login">
                    <label for="login_password">Password</label>
                    <input id="login_password" name="login_password" required tabindex="3" type="password">
                  </div>
                </fieldset>

                <input class="button important" name="login_button" id="login_button" tabindex="5" value="Login" type="submit">
              </form>

              <p><a class="required_info" href="./forgot_password.php">Forgot password</a></p>

              <p>No account? <a class="required_info" href="./create_account.php">Create new account.</a></p>


              <div id="openModal" class="modalDialog">
                <div>
                  <!--<a href="#close" title="Close" class="close">X</a>-->
                  <?php
                  if ($err == ""){
                    if($_SESSION["last_site"] == "registration") {
                      echo "<p>You have been successfully logged in. Redirecting to the registration page. If not redirected please follow this <a href=\"register_participant.php\">link</a>.</p>";
                    } else {
                      echo "<p>You have been successfully logged in. Redirecting to the main page. If not redirected please follow this <a href=\"index.php\">link</a>.</p>";
                    }
                  } else {
                    echo "<a href=\"#close\" title=\"Close\" class=\"close\">X</a>";
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
