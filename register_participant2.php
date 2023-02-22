<?php
require "./extras/always_require.php";

//check if logged in, if not send to login page and terminate the script
if(empty($_SESSION["login"])) {
  $_SESSION["last_site"] = "register_participant2";
  header("Location:login.php");
  exit;
}

//check if comes from proper page, if not send to first page of the module and terminate the script
if(
  ($_SESSION["last_site"] == "register_participant2" or
  (($_SESSION["last_site"] == "register_participant1" or
  $_SESSION["last_site"] == "payment_card" or
  $_SESSION["last_site"] == "payment_transfer") and
  $_SESSION["next"])) and
  !$_SESSION["registered"]
) {
} else {
  $_SESSION["last_site"] = "error";
  header("Location:registration.php");
  exit;
}

unset($_SESSION["next"]);

function send_mails($data) {
  require("./extras/PHPMailer/PHPMailerAutoload.php");
  require('./extras/mail_connect.php');
  
  $mail->addAddress("user@user.user", "SIMS21");
  $mail->Subject = "New conference registration of ".$data["personal"]["full_name"];
  
  $body = $data["personal"]["full_name"]." has registered for the conference. Details of the registration are available below:\n\nPERSONAL DATA\n\nTitle: ".$data["personal"]["title"]."\nFull name: ".$data["personal"]["full_name"]."\nEmail: ".$data["personal"]["email"]."\nType: ".$data["personal"]["type"]."\nShort course: ";
  if($data["personal"]["short_course"]) {
    $body = $body."Yes\n";
  } else {
    $body = $body."No\n";
  }
  $body = $body."Excursion 1: ".$data["personal"]["excursion1"]."\nExcursion 2: ".$data["personal"]["excursion2"]."\nDinner: ".$data["personal"]["dinner"]."\nAdditional information: ".$data["personal"]["additional_info"]."\n\n";
  $body = $body."AFFILIATION DATA\n\n";
  $i = 0;
  foreach($data["affiliations"] as $aff) {
    $i++;
    $body = $body."Affiliation nr ".$i."\nName: ".$aff["name"]."\nStreet: ".$aff["street"]."\nZipcode: ".$aff["zipcode"]."\nCity: ".$aff["city"]."\nCountry: ".$aff["country"]."\n";
    if($aff["country"] == $USA_name) {
      $body = $body."State: ".$aff["state"]."\n";
    }
  }
  $body = $body."\nCOSTS\n\nRegistration cost: ".$data["cost"]["registration"]."\nShort course cost: ".$data["cost"]["short_course"]."\nTotal cost: ".$data["cost"]["total"]."\nGrant: ".$data["cost"]["grant"]."\nDue: ".$data["cost"]["fee"]."\n\nINVOICE ADDRESS\n\n";
  if($data["billing"]["same"]) {
    $body = $body."Same as affiliation nr 1";
  } else {
    $body = $body."Name: ".$data["billing"]["name"]."\nStreet: ".$data["billing"]["street"]."\nZipcode: ".$data["billing"]["zipcode"]."\nCity: ".$data["billing"]["city"]."\nCountry: ".$data["billing"]["country"]."\n";
    if($data["billing"]["country"] == $USA_name) {
      $body = $body."State: ".$data["billing"]["state"];
    }
  }
  $body = $body."\n\nVAT INVOICE\n\n";
  if($data["vat"]["vat_invoice"]) {
    $body = $body."VAT nr: ".$data["vat"]["nr"];
  } else {
    $body = $body."No VAT invoice required";
  }
  $mail->Body = $body;
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
    exit;
  }

  $mail->clearAddresses();
  
  $mail->addAddress("secretary@sims21.org", "SIMS21 Secretary");
  $mail->Subject = "New conference registration of ".$data["personal"]["full_name"];
  $body = $data["personal"]["full_name"]." has registered for the conference. Details of the registration are available below:\n\nPERSONAL DATA\n\nTitle: ".$data["personal"]["title"]."\nFull name: ".$data["personal"]["full_name"]."\nEmail: ".$data["personal"]["email"]."\nType: ".$data["personal"]["type"]."\nShort course: ";
  if($data["personal"]["short_course"]) {
    $body = $body."Yes\n";
  } else {
    $body = $body."No\n";
  }
  $body = $body."Additional information: ".$data["personal"]["additional_info"]."\n\n";
  $body = $body."AFFILIATION DATA\n\n";
  $i = 0;
  foreach($data["affiliations"] as $aff) {
    $i++;
    $body = $body."Affiliation nr ".$i."\nName: ".$aff["name"]."\nStreet: ".$aff["street"]."\nZipcode: ".$aff["zipcode"]."\nCity: ".$aff["city"]."\nCountry: ".$aff["country"]."\n";
    if($aff["country"] == $USA_name) {
      $body = $body."State: ".$aff["state"]."\n";
    }
  }
  $body = $body."\nCOSTS\n\nRegistration cost: ".$data["cost"]["registration"]."\nShort course cost: ".$data["cost"]["short_course"]."\nTotal cost: ".$data["cost"]["total"]."\nGrant: ".$data["cost"]["grant"]."\nDue: ".$data["cost"]["fee"]."\n\nINVOICE ADDRESS\n\n";
  if($data["billing"]["same"]) {
    $body = $body."Same as affiliation";
  } else {
    $body = $body."Name: ".$data["billing"]["name"]."\nStreet: ".$data["billing"]["street"]."\nZipcode: ".$data["billing"]["zipcode"]."\nCity: ".$data["billing"]["city"]."\nCountry: ".$data["billing"]["country"]."\n";
    if($data["billing"]["country"] == $USA_name) {
      $body = $body."State: ".$data["billing"]["state"];
    }
  }
  $body = $body."\n\nVAT INVOICE\n\n";
  if($data["vat"]["vat_invoice"]) {
    $body = $body."VAT nr: ".$data["vat"]["nr"];
  } else {
    $body = $body."No VAT invoice required";
  }
  $mail->Body = $body;
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
    exit;
  }

  $mail->clearAddresses();

  $mail->addAddress($data["personal"]["email"]);
  $mail->Subject = "Registration for SIMS21 conference successful";
  if($data["fee"] <= 0) {
    $body = "Dear ".$data["personal"]["full_name"].",\n\nYou have been successfully registered for the conference.\n\nThank you,\nSIMS21 Organizers";
  } else {
    $body = "Dear ".$data["personal"]["full_name"].",\n\nYou have been successfully registered for the conference. We will send you a message as soon as the payment for the conference will be completed.\n\nThank you,\nSIMS21 Organizers";
  }
  $mail->Body = $body;
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
    exit;
  }

  $mail = null;
}

if(isset($_POST["back"])) {
  $_SESSION["last_site"] = "register_participant2";
  $_SESSION["next"] = true;
  header("Location: register_participant1.php");
  exit;
}

if(!$_SESSION["register"]["excursion_q"]) {
  $excursion1 = "Not interested";
  $db_excursion1 = "none";
} else if($_SESSION["register"]["excursion1"] == "krakow") {
  $excursion1 = "The Old Krak&oacute;w";
  $db_excursion1 = "krakow";
} else if($_SESSION["register"]["excursion1"] == "wieliczka") {
  $excursion1 = "The Wieliczka Salt Mine";
  $db_excursion1 = "wieliczka";
} else if($_SESSION["register"]["excursion1"] == "ojcow") {
  $excursion1 = "The Ojc&oacute;w National Park";
  $db_excursion1 = "ojcow";
}

if(!$_SESSION["register"]["excursion_q"]) {
  $excursion2 = "Not interested";
  $db_excursion2 = "none";
} else if($_SESSION["register"]["excursion2"] == "krakow") {
  $excursion2 = "The Old Krak&oacute;w";
  $db_excursion2 = "krakow";
} else if($_SESSION["register"]["excursion2"] == "wieliczka") {
  $excursion2 = "The Wieliczka Salt Mine";
  $db_excursion2 = "wieliczka";
} else if($_SESSION["register"]["excursion2"] == "ojcow") {
  $excursion2 = "The Ojc&oacute;w National Park";
  $db_excursion2 = "ojcow";
}

if(!$_SESSION["register"]["dinner_q"]) {
  $dinner = "Not interested";
  $db_dinner = "none";
} else if($_SESSION["register"]["dinner"] == "meat") {
  $dinner = "Meat/Fish";
  $db_dinner = "meat";
} else if($_SESSION["register"]["dinner"] == "veg") {
  $dinner = "Vegetarian";
  $db_dinner = "veg";
}

require "./database/db_connect.php";

$sql = "SELECT personal_grant FROM `users` WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["user_id"]));
$grant = $stmt->fetch(PDO::FETCH_ASSOC);
$grant = $grant["personal_grant"];

$sql = "SELECT type FROM people WHERE id=? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["person_id"]));
$type = $stmt->fetch(PDO::FETCH_ASSOC);
$type = $type["type"];

$conn = null;

$cost = 0.0;
if($_SESSION["register"]["type"] == "Regular") {
  $cost += $fees_current["regular"];
  $db_type = "regular";
} else if($_SESSION["register"]["type"] == "Student") {
  $cost += $fees_current["student"];
  $db_type = "student";
} else if($_SESSION["register"]["type"] == "One day") {
  $cost += $fees_current["one_day"];
  $db_type = "one_day";
} else if($_SESSION["register"]["type"] == "Exhibitor") {
  $cost += $fees_current["exhibitor"];
  $db_type = "exhibitor";
} else if($_SESSION["register"]["type"] == "Invited") {
  $cost += $fees_current["regular"];
  $db_type = "invited";
}

$personal_cost = $cost;

if($_SESSION["register"]["short_course"] == "yes") {
  $cost += $fees_current["short_course"];
  $short_course_cost = $fees_current["short_course"];
  $db_short_course = 1;
} else {
  $short_course_cost = 0;
  $db_short_course = 0;
}

if(!empty($grant)) {
  if($cost < $grant) {
    $fee = 0;
  } else {
    $fee = $cost - $grant;
  }
} else {
  $fee = $cost;
}
$_SESSION["cost"] = $cost;
$_SESSION["fee"] = $fee;
$_SESSION["register"]["cost"] = $cost;
$_SESSION["register"]["fee"] = $fee;

require "./database/db_connect.php";

if(isset($_POST["payment"])) {
  if($_SESSION["register"]["same_affiliation"]) {
  $vat_affiliation = $_SESSION["affiliation_id"];
  } else if(!empty($_SESSION["register"]["VAT_affiliation"])) {
    $vat_affiliation = $_SESSION["register"]["VAT_affiliation"];
  } else {
    $sql = "
      INSERT INTO `affiliations`
      SET
        affiliation1=:name,
        country=:country,
        state=:state,
        city=:city,
        street=:street,
        zipcode=:zipcode,
        create_time=NULL
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array("name" => $_SESSION["register"]["VAT_name"], "country" => $_SESSION["register"]["VAT_country"], "state" => $_SESSION["register"]["VAT_state"], "city" => $_SESSION["register"]["VAT_city"], "street" => $_SESSION["register"]["VAT_street"], "zipcode" => $_SESSION["register"]["VAT_zipcode"]));
    $vat_affiliation = $conn->lastInsertId();
  }
  
  $sql = "
    UPDATE `people`
    SET
      registered=TRUE,
      paid=0,
      type=:type, 
      excursion_first=:excursion1, 
      excursion_second=:excursion2, 
      dinner=:dinner, 
      short_course=".$db_short_course.", 
      additional_info=:additional_info, 
      cost=:cost,
      vat_nr=:vat_nr, 
      vat_affiliation=:vat_affiliation,
      vat_invoice=";
  if($_SESSION["register"]["invoice"]) {
    $sql = $sql."true";
  } else {
    $sql = $sql."false";
  }
  $sql = $sql." WHERE id=:id";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("type" => $db_type, "excursion1" => $db_excursion1, "excursion2" => $db_excursion2, "dinner" => $db_dinner, "additional_info" => $_SESSION["register"]["additional_info"], "cost" => $cost, "vat_nr" => $_SESSION["register"]["VAT_nr"], "vat_affiliation" => $vat_affiliation, "id" => $_SESSION["person_id"]));
  
  $sql = "SELECT email, full_name, title, affiliation_id, type, excursion_first, excursion_second, dinner, short_course, additional_info, vat_invoice, vat_nr, vat_affiliation FROM `people` WHERE id=".$_SESSION["person_id"];
  $person_data = $conn->query($sql);
  $person_data = $person_data->fetch(PDO::FETCH_ASSOC);
  
  $sql = "SELECT person_id, affiliation_id, order_nr FROM `affiliations_to_people` WHERE person_id=".$_SESSION["person_id"];
  $stmt = $conn->query($sql);
  $affiliations_ids = array();
  while($aff = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $affiliations_ids[] = $aff["affiliation_id"];
  }
  $person_data["affiliations_ids"] = $affiliations_ids;
  
  $sql = "
    UPDATE `users`
    SET
      personal_cost=:cost,
      short_course_cost=:short_course_cost
    WHERE
      id=:id";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("cost" => $personal_cost, "short_course_cost" => $short_course_cost, "id" => $_SESSION["user_id"]));
  
  $sql = "SELECT personal_cost, short_course_cost, personal_grant, personal_fee FROM users WHERE id=? LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($_SESSION["user_id"]));
  $user_data = $stmt->fetch(PDO::FETCH_ASSOC);

  $sql = "INSERT INTO payments (amount, user_id, create_time) VALUES (:amount, :user_id, NULL)";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("amount" => $fee, "user_id" => $_SESSION["user_id"]));
  
  $sql = "SELECT affiliation1, affiliation2, country, state, city, street, zipcode FROM affiliations WHERE id=? LIMIT 1";
  $stmt = $conn->prepare($sql);
  $affiliations = array();
  foreach($person_data["affiliations_ids"] as $aff) {
    $stmt->execute(array($aff));
    $affiliations[] = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  $sql = "SELECT affiliation1, affiliation2, country, state, city, street, zipcode FROM affiliations WHERE id=? LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($person_data["vat_affiliation"]));
  $billing = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $content = $_SESSION["full_name"]." (user_id: ".$_SESSION["user_id"].", person_id: ".$_SESSION["person_id"].") registered for the conference.";
  log_save($conn, "register_participant2", $content);
  
  $conn = null;
  
  $data = array();
  
  $data["personal"]["full_name"] = $person_data["full_name"];
  $data["personal"]["title"] = $person_data["title"];
  $data["personal"]["email"] = $person_data["email"];
  $data["personal"]["type"] = $person_data["type"];
  $data["personal"]["short_course"] = $person_data["short_course"];
  $data["personal"]["additional_info"] = $person_data["additional_info"];
  $data["personal"]["excursion1"] = $person_data["excursion_first"];
  $data["personal"]["excursion2"] = $person_data["excursion_second"];
  $data["personal"]["dinner"] = $person_data["dinner"];
  
  $data["affiliations"] = array();
  foreach($affiliations as $affiliation) {
    $aff = array();
    $aff["name"] = $affiliation["affiliation1"];
    if(!empty($affiliation["affiliation2"])) {
      $aff["name"] = $aff["name"]." - ".$affiliation["affiliation2"];
    }
    $aff["country"] = $affiliation["country"];
    $aff["state"] = $affiliation["state"];
    $aff["city"] = $affiliation["city"];
    $aff["street"] = $affiliation["street"];
    $aff["zipcode"] = $affiliation["zipcode"];
    $data["affiliations"][] = $aff;
  }
  
  $data["cost"]["registration"] = $user_data["personal_cost"];
  $data["cost"]["short_course"] = $user_data["short_course_cost"];
  $data["cost"]["total"] = $user_data["personal_cost"] + $user_data["short_course_cost"];
  $data["cost"]["grant"] = $user_data["personal_grant"];
  $data["cost"]["fee"] = $user_data["personal_fee"];
  
  if($person_data["affiliations_ids"][0] == $person_data["vat_affiliation"]) {
    $data["billing"]["same"] = 1;
  } else {
    $data["billing"]["same"] = 0;
  }
  
  $data["billing"]["name"] = $billing["affiliation1"];
  if(!empty($billing["affiliation2"])) {
    $data["billing"]["name"] = $data["billing"]["name"]." - ".$billing["affiliation2"];
  }
  $data["billing"]["country"] = $billing["country"];
  $data["billing"]["state"] = $billing["state"];
  $data["billing"]["city"] = $billing["city"];
  $data["billing"]["street"] = $billing["street"];
  $data["billing"]["zipcode"] = $billing["zipcode"];
  
  $data["vat"]["vat_invoice"] = $person_data["vat_invoice"];
  $data["vat"]["nr"] = $person_data["vat_nr"];
  
  $_SESSION["registered"] = true;
  $_SESSION["last_site"] = "register_participant2";
  $_SESSION["next"] = true;
  
  $_SESSION["fee_type"] = "personal";
  
  send_mails($data);
  if($fee <= 0) {
    header("Location: user_summary.php");
  } else {
    header("Location: payment.php");
  }
  exit;
}

$_SESSION["last_site"] = "register_participant2";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        .additions {
          font-style: italic;
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
              <h1>Register participant - summary</h1>
              
              <form id="register_participant" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="submit" name="back" id="back" value="Back">
                <input type="submit" name="payment" id="payment" value="Submit">
              </form>

              <p>If the information below is correct please follow to the payment section.</p>

              <h2>Registration fee</h2>
              <p><span class="important"><?php echo $_SESSION["register"]["type"];?></span></p>

              <h2>IUVSTA Short Course</h2>
              <p>I <span class="important"><?php echo ($_SESSION["register"]["short_course"] == "yes") ? "am" : "am not";?></span> planning to participate in the IUVSTA Short Course on Sunday.</p>

              <h2>Excursion</h2>
              <p>First choice: <span class="important"><?php echo $excursion1;?></span></p>
              <p>Second choice: <span class="important"><?php echo $excursion2;?></span></p>

              <h2>Conference dinner</h2>
              <p><span class="important"><?php echo $dinner;?></span></p>

              <h2>Additional information</h2>
              <p>
                <span class="important"><?php echo empty($_SESSION["register"]["additional_info"]) ? "None provided" : $_SESSION["register"]["additional_info"];?></span>
              </p>

              <hr>

              <p>
                Your total payment:
                <?php
                if($grant > 0) {
                  if($fee <= 0) {
                    echo "<span class=\"important\">".number_format($fee,2)."</span>&nbsp;PLN";
                  } else {
                    echo "<strong>".number_format($cost,2)."</strong> (regular cost) - <strong>".$grant."</strong> (grant given) = <span class=\"important\">".number_format($fee,2)."</span>&nbsp;PLN";
                  }
                } else {
                  echo "<span class=\"important\">".number_format($fee,2)."</span>&nbsp;PLN";
                }
                ?>
              </p>
              
              <hr>

              <h2>Invoice address</h2>
              
              Full name: <?php echo $_SESSION["register"]["VAT_name"];?><br>
              Street: <?php echo $_SESSION["register"]["VAT_street"];?><br>
              Zipcode: <?php echo $_SESSION["register"]["VAT_zipcode"];?><br>
              City: <?php echo $_SESSION["register"]["VAT_city"];?><br>
              Country: <?php echo $_SESSION["register"]["VAT_country"];?>
              <?php echo $_SESSION["register"]["VAT_country"] == $USA_name ? "<br>\nState: ".$all_states[$_SESSION["register"]["VAT_state"]] : "";?>

              <hr>

              <h2>VAT invoice</h2>
              <?php if($_SESSION["register"]["invoice"]): //IF START?>
              <p>
                VAT identification number: <?php echo $_SESSION["register"]["VAT_nr"];?>
              </p>
              <?php else:?>
              <p>No VAT number.</p>
              <?php endif; //IF END?>

              <form id="register_participant" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="submit" name="back" id="back" value="Back">
                <input type="submit" name="payment" id="payment" value="Submit">
              </form>
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