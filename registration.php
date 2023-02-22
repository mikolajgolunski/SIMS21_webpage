<?php
require "./extras/always_require.php";

header("Location: register_participant1.php");
exit;

$err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["unregister"])) {
    require('./database/db_connect.php');
    
    $user_change = array("accomp_persons" => 0, "personal_cost" => null, "short_course_cost" => null, "accomp_cost" => null, "id" => $_SESSION["user_id"]);
    $person_change = array("registered" => false, "excursion_first" => null, "excursion_second" => null, "dinner" => null, "short_course" => null, "additional_info" => null, "cost" => null, "payment_type" => null, "vat_invoice" => false, "vat_nr" => null, "vat_affiliation" => null, "id" => $_SESSION["person_id"]);
    
    $sql = "UPDATE people SET registered=:registered, excursion_first=:excursion_first, excursion_second=:excursion_second, dinner=:dinner, short_course=:short_course, additional_info=:additional_info, cost=:cost, payment_type=:payment_type, vat_invoice=:vat_invoice, vat_nr=:vat_nr, vat_affiliation=:vat_affiliation WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute($person_change);
    
    $sql = "UPDATE users SET accomp_persons=:accomp_persons, personal_cost=:personal_cost, short_course_cost=:short_course_cost, accomp_cost=:accomp_cost WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute($user_change);
    
    $sql = "DELETE FROM accomp_to_users WHERE user_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array("id" => $_SESSION["user_id"]));
    
    $sql = "DELETE FROM payments WHERE user_id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array("id" => $_SESSION["user_id"]));
    
    $_SESSION["registered"] = false;
    
    log_save($conn, "registration.php", "[Testing] User ".$_SESSION["login"]." (name: ".$_SESSION["full_name"].", user_id: ".$_SESSION["user_id"].") unregistered from the conference.");
    
    $conn = null;
  }
}

$_SESSION["last_site"] = "registration";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        table {
          margin: 0 auto;
        }
        
        thead {
          font-weight: bold;
        }
        
        td {
          width: 100px;
          height: 30px;
          border-bottom-style: solid;
          border-bottom-width: 1px;
        }
        
        .table_head {
          width: 200px;
        }
        
        .auto-style6 {
          text-align: center;
          height: 26px;
        }
      </style>

      <title>SIMS21, Poland 2017 - Registration</title>
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
              <h1>Registration</h1>
              <p><span class="important">Registration will open on April 1, 2017</span></p>

              <?php if($testing_q && $_SESSION["access_type"] == "admin"):?>
              <hr>

              <p class="important">Content below created and available only because of tests!</p>
              <?php $_SESSION["next"] = true;
              if($_SESSION["registered"]): //IF START?>
              <p>You are already registered for the conference.</p>
              <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                <input type="submit" name="unregister" value="Unregister">
              </form>
              <?php else:?>
              <a href="register_participant1.php" class="button">REGISTER PARTICIPANT</a>
              <?php endif; //IF END?>
              <?php endif;?>

              <div id="openModal" class="modalDialog">
                <div>
                  <a href="#close" title="Close" class="close">X</a>
                  <?php
                  if ($err == ""){
                    echo "<p>Your email has been registered in our database. We will send you mail if there are any news regarding SIMS21 conference.</p>";
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
