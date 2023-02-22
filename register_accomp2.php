<?php
require "./extras/always_require.php";

//check if logged in, if not send to login page and terminate the script
if(empty($_SESSION["login"])) {
  $_SESSION["last_site"] = "register_accomp2";
  header("Location:login.php");
  exit;
}

//check if comes from proper page, if not send to first page of the module and terminate the script
if(
  $_SESSION["last_site"] == "register_accomp2" or
  (($_SESSION["last_site"] == "register_accomp1" or
  $_SESSION["last_site"] == "payment_card" or
  $_SESSION["last_site"] == "payment_transfer") and
  $_SESSION["next"])
) { 
} else {
  $_SESSION["last_site"] = "error";
  header("Location:register_accomp1.php");
  exit;
}

unset($_SESSION["next"]);

if(isset($_POST["back"])) {
  $_SESSION["next"] = true;
  $_SESSION["last_site"] = "register_accomp2";
  header("Location: register_accomp1.php");
  exit;
}

if(!$_SESSION["accomp"]["excursion_q"]) {
  $excursion1 = "Not interested";
  $db_excursion1 = "none";
} else if($_SESSION["accomp"]["excursion1"] == "krakow") {
  $excursion1 = "The Old Krak&oacute;w";
  $db_excursion1 = "krakow";
} else if($_SESSION["accomp"]["excursion1"] == "wieliczka") {
  $excursion1 = "The Wieliczka Salt Mine";
  $db_excursion1 = "wieliczka";
} else if($_SESSION["accomp"]["excursion1"] == "ojcow") {
  $excursion1 = "The Ojc&oacute;w National Park";
  $db_excursion1 = "ojcow";
}

if(!$_SESSION["accomp"]["excursion_q"]) {
  $excursion2 = "Not interested";
  $db_excursion2 = "none";
} else if($_SESSION["accomp"]["excursion2"] == "krakow") {
  $excursion2 = "The Old Krak&oacute;w";
  $db_excursion2 = "krakow";
} else if($_SESSION["accomp"]["excursion2"] == "wieliczka") {
  $excursion2 = "The Wieliczka Salt Mine";
  $db_excursion2 = "wieliczka";
} else if($_SESSION["accomp"]["excursion2"] == "ojcow") {
  $excursion2 = "The Ojc&oacute;w National Park";
  $db_excursion2 = "ojcow";
}

if(!$_SESSION["accomp"]["dinner_q"]) {
  $dinner = "Not interested";
  $db_dinner = "none";
} else if($_SESSION["accomp"]["dinner"] == "meat") {
  $dinner = "Meat/Fish";
  $db_dinner = "meat";
} else if($_SESSION["accomp"]["dinner"] == "veg") {
  $dinner = "Vegetarian";
  $db_dinner = "veg";
}

$_SESSION["accomp"]["cost"] = $fees_current["accomp"];

if(isset($_POST["payment"])) {
  require "./database/db_connect.php";
  
  if($_SESSION["accomp"]["invoice"]) {
    if($_SESSION["accomp"]["same_affiliation"]) {
      $vat_affiliation = $_SESSION["affiliation_id"];
    } else if(!empty($_SESSION["accomp"]["VAT_affiliation"])) {
      $vat_affiliation = $_SESSION["accomp"]["VAT_affiliation"];
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
      $stmt->execute(array("name" => $_SESSION["accomp"]["VAT_name"], "country" => $_SESSION["accomp"]["VAT_country"], "state" => $_SESSION["accomp"]["VAT_state"], "city" => $_SESSION["accomp"]["VAT_city"], "street" => $_SESSION["accomp"]["VAT_street"], "zipcode" => $_SESSION["accomp"]["VAT_zipcode"]));
      $vat_affiliation = $conn->lastInsertId();
    }
  }
  
  if($_POST["payment"] == "Submit / Bank transfer") {
    $payment_type = "transfer";
  } else if($_POST["payment"] == "Submit / Credit card") {
    $payment_type = "card";
  } else {
    $payment_type = "other";
  }
  
  $sql = "
    INSERT INTO `people`
    SET 
      last_name=:last_name, 
      middle_name=:middle_name, 
      first_name=:first_name, 
      full_name=:full_name, 
      title=:title, 
      type='accomp', 
      excursion_first=:excursion1, 
      excursion_second=:excursion2, 
      dinner=:dinner, 
      short_course=false, 
      additional_info=:additional_info, 
      cost=:cost, 
      payment_type=:payment_type,
      affiliation_id=:affiliation_id, 
      create_time=NULL, 
      email='accompanying@person.mail', 
      vat_invoice=";
  if(empty($_SESSION["accomp"]["invoice"])) {
    $sql = $sql."false,";  
  } else {
    $sql = $sql."true,";
  }
  $sql = $sql."
      vat_nr=:vat_nr, 
      vat_affiliation=:vat_affiliation
  ";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("last_name" => $_SESSION["accomp"]["last_name"], "middle_name" => $_SESSION["accomp"]["middle_name"], "first_name" => $_SESSION["accomp"]["first_name"], "full_name" => $_SESSION["accomp"]["full_name"], "title" => $_SESSION["accomp"]["title"], "excursion1" => $db_excursion1, "excursion2" => $db_excursion2, "dinner" => $db_dinner, "additional_info" => $_SESSION["accomp"]["additional_info"], "cost" => $_SESSION["accomp"]["cost"], "payment_type" => $payment_type, "affiliation_id" => $accomp_affiliation_id, "vat_nr" => $_SESSION["accomp"]["VAT_nr"], "vat_affiliation" => $vat_affiliation));
  $accomp_id = $conn->lastInsertId();
  
  $sql = "INSERT INTO `accomp_to_users` SET user_id=:user_id, person_id=:person_id, create_time=NULL";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("user_id" => $_SESSION["user_id"], "person_id" => $accomp_id));
  
  if($_SESSION["accomp"]["invoice"]) {
    $_SESSION["VAT_accomp"] = true;
  }
  
  $sql = "UPDATE `users` SET accomp_persons=accomp_persons+1 WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($_SESSION["user_id"]));
  $conn = null;
  
  $_SESSION["next"] = true;
  $_SESSION["last_site"] = "register_accomp2";
  
  if($_POST["payment"] == "Submit / Bank transfer") {
    header("Location: payment_transfer.php");
  } else if($_POST["payment"] == "Submit / Credit card") {
    header("Location: payment_card.php");
  } else {
    header("Location: index.php");
  }
  exit;
}

$_SESSION["last_site"] = "register_accomp2";
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

      <title>SIMS21, Poland 2017 - Accompanying person registration</title>
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
              <h1>Register accompanying person - summary</h1>

              <p>If the information below is correct please follow to the payment section.</p>

              <h2>Personal information</h2>
              <p><span class="important"><?php echo $_SESSION["accomp"]["title"]." ".$_SESSION["accomp"]["full_name"];?></span></p>

              <h2>Excursion</h2>
              <p>First choice: <span class="important"><?php echo $excursion1;?></span></p>
              <p>Second choice: <span class="important"><?php echo $excursion2;?></span></p>

              <h2>Conference dinner</h2>
              <p><span class="important"><?php echo $dinner;?></span></p>

              <h2>Additional information</h2>
              <p>
                <?php echo $_SESSION["accomp"]["additional_info"];?>
              </p>

              <hr>

              <p>Total payment: <span class="important"><?php echo $_SESSION["accomp"]["cost"];?></span> PLN</p>

              <hr>

              <h2>VAT invoice</h2>
              <?php if($_SESSION["accomp"]["invoice"]): //IF START?>
              <p>
                VAT identification number:
                <?php echo $_SESSION["accomp"]["VAT_nr"];?><br> Full name:
                <?php echo $_SESSION["accomp"]["VAT_name"];?><br> Street:
                <?php echo $_SESSION["accomp"]["VAT_street"];?><br> Zipcode:
                <?php echo $_SESSION["accomp"]["VAT_zipcode"];?><br> City:
                <?php echo $_SESSION["accomp"]["VAT_city"];?><br> Country:
                <?php echo $_SESSION["accomp"]["VAT_country"];?>
                <?php echo $_SESSION["accomp"]["VAT_country"] == $USA_name ? "<br>\nState: ".$all_states[$_SESSION["accomp"]["VAT_state"]] : "";?>
              </p>
              <?php else:?>
              <p>VAT invoice not required.</p>
              <?php endif; //IF END?>

              <form id="register_accomp" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="submit" name="back" id="back" value="Back">
                <input type="submit" name="payment" id="payment_transfer" value="Submit / Bank transfer">
                <input type="submit" name="payment" id="payment_card" value="Submit / Credit card">
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