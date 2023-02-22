<?php
require "./extras/always_require.php";

//check if logged in, if not send to login page and terminate the script
if(empty($_SESSION["login"])) {
  $_SESSION["last_site"] = "register_accomp1";
  header("Location:login.php");
  exit;
}

//check for prerequisities
if(!$_SESSION["registered"]) {
  $_SESSION["last_site"] = "register_accomp1";
  header("Location:register_first.php");
  exit;
}

if(isset($_POST["register"])) {
  $_SESSION["fee_type"] = "accomp";
  
  $_SESSION["next"] = true;
  $_SESSION["last_site"] = "register_accomp1";
  header("Location: payment.php");
  exit;
}

unset($_SESSION["next"]);

function send_mails($data) {
  require("./extras/PHPMailer/PHPMailerAutoload.php");
  require('./extras/mail_connect.php');
  
  $mail->addAddress("user@user.user", "SIMS21");
  $mail->Subject = "New accompanying person added for ".$data["personal"]["full_name"];
  
  $body = $data["personal"]["full_name"]." added new accompanying person. Details of the person are available below:\n\nPERSONAL DATA\n\nTitle: ".$data["accomp"]["title"]."\nFull name: ".$data["accomp"]["full_name"]."\nAdditional information: ".$data["accomp"]["additional_info"];
  
  $mail->Body = $body;
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
    exit;
  }

  $mail->clearAddresses();
  
  $mail->addAddress("secretary@sims21.org", "SIMS21 Secretary");
  $mail->Subject = "New accompanying person added for ".$data["personal"]["full_name"];
  
  $body = $data["personal"]["full_name"]." added new accompanying person. Details of the person are available below:\n\nPERSONAL DATA\n\nTitle: ".$data["accomp"]["title"]."\nFull name: ".$data["accomp"]["full_name"]."\nAdditional information: ".$data["accomp"]["additional_info"];
  
  $mail->Body = $body;
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
    exit;
  }

  $mail = null;
}

require "./database/db_connect.php";

if(isset($_POST["add"])) {
  $sql = "SELECT email, excursion_first, excursion_second, dinner, affiliation_id FROM people WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($_SESSION["person_id"]));
  $accomp_data = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $accomp_last_name = test_input($_POST["last_name"]);
  $accomp_first_name = test_input($_POST["first_name"]);
  $accomp_middle_name = test_input($_POST["middle_name"]);
  $accomp_full_name = get_full_name(
      array(
        "first_name" => $accomp_first_name,
        "middle_name" => $accomp_middle_name,
        "last_name" => $accomp_last_name
      )
    );
  $accomp_title = test_input($_POST["title"]);
  $accomp_additional_info = test_input($_POST["additional_info"]);
  
  
  $sql = "INSERT INTO people SET last_name=:last_name, first_name=:first_name, middle_name=:middle_name, full_name=:full_name, title=:title, email=:email, type='accomp', paid=0, excursion_first=:excursion_first, excursion_second=:excursion_second, dinner=:dinner, additional_info=:additional_info, cost=:cost, affiliation_id=:affiliation_id, create_time=NULL";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array(
    "last_name" => $accomp_last_name,
    "first_name" => $accomp_first_name,
    "middle_name" => $accomp_middle_name,
    "full_name" => $accomp_full_name,
    "title" => $accomp_title,
    "email" => $accomp_data["email"],
    "excursion_first" => $accomp_data["excursion_first"],
    "excursion_second" => $accomp_data["excursion_second"],
    "dinner" => $accomp_data["dinner"],
    "additional_info" => $accomp_additional_info,
    "cost" => $fees_current["accomp"],
    "affiliation_id" => $accomp_data["affiliation_id"]
  ));
  $accomp_id = $conn->lastInsertId();
  
  $sql = "INSERT INTO affiliations_to_people SET affiliation_id=:affiliation_id, person_id=:person_id, create_time=NULL";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("affiliation_id" => $accomp_data["affiliation_id"], "person_id" => $accomp_id));

  $sql = "INSERT INTO accomp_to_users SET user_id=:user_id, person_id=:person_id, create_time=NULL";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("user_id" => $_SESSION["user_id"], "person_id" => $accomp_id));
  
  $sql = "SELECT full_name FROM people WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($_SESSION["person_id"]));
  $personal_full_name = $stmt->fetch(PDO::FETCH_ASSOC);
  $personal_full_name = $personal_full_name["full_name"];
  
  $data = array();
  $data["personal"]["full_name"] = $personal_full_name;
  $data["accomp"]["title"] = $accomp_title;
  $data["accomp"]["full_name"] = $accomp_full_name;
  $data["accomp"]["additional_info"] = $accomp_additional_info;
  send_mails($data);
}

if(isset($_POST["ctrl"])) {
  $ctrl = explode("_", $_POST["ctrl"]);
  if($ctrl[0] == "delete") {
    $sql = "DELETE FROM accomp_to_users WHERE person_id=? AND user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($ctrl[1], $_SESSION["user_id"]));
    
    $sql = "DELETE FROM affiliations_to_people WHERE person_id=? AND affiliation_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($ctrl[1], $_SESSION["affiliation_id"]));

    $sql = "DELETE FROM people WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($ctrl[1]));
  }
}

$sql = "SELECT GROUP_CONCAT(DISTINCT(person_id)) AS ids FROM `accomp_to_users` WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["user_id"]));
$accomp_ids = $stmt->fetch(PDO::FETCH_ASSOC);
$accomp_ids = $accomp_ids["ids"];

$accomps = array();
$accomp_cost = 0;
if(!empty($accomp_ids)) {
  $sql = "SELECT id, full_name, title, additional_info, cost, paid FROM people WHERE id IN (".$accomp_ids.")";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  while($accomp = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $accomps[] = $accomp;
    $accomp_cost += $accomp["cost"];
  }
}

$_SESSION["accomp_nr"] = count($accomps);

$sql = "UPDATE users SET accomp_persons=:accomp_persons, accomp_cost=:accomp_cost WHERE id=:id";
$stmt = $conn->prepare($sql);
$stmt->execute(array("id" => $_SESSION["user_id"], "accomp_persons" => $_SESSION["accomp_nr"], "accomp_cost" => $accomp_cost));

$sql = "SELECT accomp_grant FROM users WHERE id=:id";
$stmt = $conn->prepare($sql);
$stmt->execute(array("id" => $_SESSION["user_id"]));
$user_data = $stmt->fetch(PDO::FETCH_ASSOC);

if($accomp_cost - $user_data["accomp_grant"] < 0) {
  $accomp_fee = 0;
} else {
  $accomp_fee = $accomp_cost - $user_data["accomp_grant"];
}

$sql = "SELECT id FROM payments WHERE user_id=? AND type='accomp' AND success IS NULL LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["user_id"]));
$payment = $stmt->fetch(PDO::FETCH_ASSOC);
if(!empty($payment)) {
  $sql = "UPDATE payments SET amount=? WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($accomp_fee, $payment["id"]));
} else {
  $sql = "INSERT INTO payments SET user_id=:user_id, type='accomp', amount=:amount, create_time=NULL";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("user_id" => $_SESSION["user_id"], "amount" => $accomp_fee));
}

$conn = null;

$_SESSION["last_site"] = "register_accomp1";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

    <script>
      function ctrlFunction(type, id) {
        var ctrl = document.getElementById("ctrl");
        ctrl.value = type + "_" + id;
        ctrl.disabled = false;
      }
    </script>
    
    <style type="text/css">
      textarea {
        width: 100%;
        margin-top: 0.5em;
        margin-bottom: 0.5em;
      }
      
      table {
        margin-bottom: 1em;
      }
    </style>

      <title>SIMS21, Poland 2017 - Accompanying person(s) registration</title>
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
              <h1>Accompanying person(s) registration</h1>

              <form id="register_accomp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                
                <select id="title" name="title" required>
                  <option value="">Title...</option>
                  <?php
                  foreach ($titles_accomp as $some_title) {
                    echo "<option value=\"".$some_title."\">".$some_title."</option>\n";
                  }
                  ?>
                </select><sup class="required_info">*</sup>
                <input type="text" name="first_name" id="first_name" placeholder="First name" required><sup class="required_info">*</sup>
                <input type="text" name="middle_name" id="middle_name" placeholder="Middle name">
                <input type="text" name="last_name" id="last_name" placeholder="Last name" required><sup class="required_info">*</sup>
    	        <p>Please enter additional information, if needed (dietary requirements, excursion, etc.):</p> 
                <textarea name="additional_info" id="additional_info" cols="80" placeholder="Additional information"></textarea>

                <input type="submit" name="add" id="add" value="Add person">
              </form>
              
              <hr>
              
              <p>
                Full accompanying person(s) cost: <?php echo number_format($accomp_cost,2,"."," ");?>&nbsp;PLN<br>
                Already paid: <?php echo number_format($user_data["accomp_grant"],2,"."," ");?>&nbsp;PLN<br>
                Due: <span class="important"><?php echo number_format($accomp_fee,2,"."," ");?></span>&nbsp;PLN
              </p>
              
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <table>
                  <thead>
                    <tr>
                      <td style="width: 2em;">Title</td>
                      <td>Name</td>
                      <td>Additional information</td>
                      <td style="width: 2em;"></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(empty($accomps)) {
                      echo "<tr><td colspan=\"4\"><span class=\"important\">No accompanying persons registered</span></td></tr>";
                    } else {
                      $accomp_paid = false;
                      foreach($accomps as $accomp) {
                        if($accomp["paid"]) {
                          $accomp_paid = true;
                        }
                        echo "<tr>\n";
                        echo "<td>".$accomp["title"]."</td>\n";
                        echo "<td>".$accomp["full_name"]."</td>\n";
                        echo "<td>".$accomp["additional_info"]."</td>\n";
                        echo "<td><button type=\"submit\" onclick=\"ctrlFunction('delete', ".$accomp["id"].")\"";
                        echo $accomp["paid"] ? " disabled" : "";
                        echo "><span class=\"fa fa-trash-o fa-fw\"></span></button>";
                        echo $accomp["paid"] ? "<sup class=\"required_info\">**</sup>" : "";
                        echo "</td>\n";
                        echo "</tr>\n";
                      }
                    }
                    ?>
                  </tbody>
                </table>
                <input type="hidden" name="ctrl" id="ctrl" value="" disabled>
              
                <input type="submit" name="register" id="register" value="Pay for accompanying person(s)"<?php echo (empty($accomps) || $accomp_fee <= 0) ? " disabled" : "";?>>
              </form>
              
              <p class="required_info"><sup>*</sup>) Required field</p>
              <?php if($accomp_paid):?>
                <p class="required_info"><sup>**</sup>) You already paid for the person. If you would like to cancel their registration or change their details please contact us.</p>
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
