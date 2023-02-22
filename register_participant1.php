<?php
require "./extras/always_require.php";

//check if logged in, if not send to login page and terminate the script
if(empty($_SESSION["login"])) {
  $_SESSION["last_site"] = "register_participant1";
  header("Location:login.php");
  exit;
}

//check if comes from proper page, if not send to first page of the module and terminate the script
if($_SESSION["registered"]) {
  $_SESSION["last_site"] = "register_participant1";
  header("Location:user_summary.php");
  exit;
}

require "./database/db_connect.php";

$sql = "SELECT affiliation1, affiliation2, street, zipcode, state, country, city FROM `affiliations` WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["affiliation_id"]));
$affiliation = $stmt->fetch(PDO::FETCH_ASSOC);

if(empty($affiliation["affiliation2"])) {
  $affiliation["name"] = $affiliation["affiliation1"];
} else {
  $affiliation["name"] = $affiliation["affiliation1"]." ".$affiliation["affiliation2"];
}

$sql = "SELECT type FROM people WHERE id=? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["person_id"]));
$type = $stmt->fetch(PDO::FETCH_ASSOC);
$type = $type["type"];

$conn = null;

if(!($_SESSION["last_site"] == "register_participant1" or $_SESSION["last_site"] == "register_participant2")) {
  unset($_SESSION["register"]);
  $_SESSION["register"]["excursion1"] = "wieliczka";
  $_SESSION["register"]["excursion2"] = "wieliczka";
  $_SESSION["register"]["dinner"] = "meat";
  $_SESSION["register"]["excursion_q"] = true;
  $_SESSION["register"]["dinner_q"] = true;
  $_SESSION["register"]["type"] = "Regular";
  $_SESSION["register"]["short_course"] = "no";
  
  $_SESSION["register"]["same_affiliation"] = true;
  $_SESSION["register"]["invoice"] = true;
  $_SESSION["register"]["VAT_name"] = $affiliation["name"];
  $_SESSION["register"]["VAT_street"] = $affiliation["street"];
  $_SESSION["register"]["VAT_zipcode"] = $affiliation["zipcode"];
  $_SESSION["register"]["VAT_city"] = $affiliation["city"];
  $_SESSION["register"]["VAT_country"] = $affiliation["country"];
  $_SESSION["register"]["VAT_state"] = $affiliation["state"];
}

unset($_SESSION["next"]);

$affiliation_data = array("name" => $affiliation["name"], "street" => $affiliation["street"], "zipcode" => $affiliation["zipcode"], "city" => $affiliation["city"], "country" => $affiliation["country"], "state" => $all_states[$affiliation["state"]]);

if(isset($_POST["register"])) {
  if(!empty($_POST["excursion1"])) {
    $_SESSION["register"]["excursion1"] = $_POST["excursion1"];
    $_SESSION["register"]["excursion2"] = $_POST["excursion2"];
    $_SESSION["register"]["excursion_q"] = true;
  } else {
    $_SESSION["register"]["excursion_q"] = false;
  }
  if(!empty($_POST["dinner"])) {
    $_SESSION["register"]["dinner"] = $_POST["dinner"];
    $_SESSION["register"]["dinner_q"] = true;
  } else {
    $_SESSION["register"]["dinner_q"] = false;
  }
  $_SESSION["register"]["type"] = $_POST["registration_type"];
  $_SESSION["register"]["short_course"] = $_POST["short_course"];
  $_SESSION["register"]["additional_info"] = test_input($_POST["additional_info"]);
  
  if(empty($_POST["invoice"])) {
    $_SESSION["register"]["invoice"] = true;
    $_SESSION["register"]["VAT_nr"] = test_input($_POST["VAT_nr"]);
  } else {
    $_SESSION["register"]["invoice"] = false;
  }
  
  if($_POST["same_affiliation"] == "1") {
    $_SESSION["register"]["same_affiliation"] = true;
    $_SESSION["register"]["VAT_name"] = $affiliation["name"];
    $_SESSION["register"]["VAT_street"] = $affiliation["street"];
    $_SESSION["register"]["VAT_zipcode"] = $affiliation["zipcode"];
    $_SESSION["register"]["VAT_city"] = $affiliation["city"];
    $_SESSION["register"]["VAT_country"] = $affiliation["country"];
    $_SESSION["register"]["VAT_state"] = $affiliation["state"];
  } else {
    $_SESSION["register"]["same_affiliation"] = false;
    $_SESSION["register"]["VAT_name"] = test_input($_POST["VAT_name"]);
    $_SESSION["register"]["VAT_street"] = test_input($_POST["VAT_street"]);
    $_SESSION["register"]["VAT_zipcode"] = test_input($_POST["VAT_zipcode"]);
    $_SESSION["register"]["VAT_city"] = test_input($_POST["VAT_city"]);
    $_SESSION["register"]["VAT_country"] = test_input($_POST["VAT_country"]);
    $_SESSION["register"]["VAT_state"] = test_input($_POST["VAT_state"]);
  }
  
  $_SESSION["next"] = true;
  
  header("Location: register_participant2.php");
  exit;
} else {
  if($type == "regular") {
    $_SESSION["register"]["type"] = "Regular";
  } elseif($type == "student") {
    $_SESSION["register"]["type"] = "Student";
  } elseif($type == "exhibitor") {
    $_SESSION["register"]["type"] = "Exhibitor";
  } elseif($type == "invited") {
    $_SESSION["register"]["type"] = "Invited";
  } elseif($type == "one_day") {
    $_SESSION["register"]["type"] = "One day";
  }
}

$_SESSION["last_site"] = "register_participant1";
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
        
        form label {
          display: inline;
        }
        
        .whole-width {
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -webkit-box-pack: start;
          -ms-flex-pack: start;
          justify-content: flex-start;
          -webkit-box-align: center;
          -ms-flex-align: center;
          align-items: center;
          width: 100%;
          margin-bottom: 0.5em;
        }
        
        .width-33 {
          width: 33%;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
        }
        
        .width-50 {
          width: 50%;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
        }
        
        #street-zip-city {
          -webkit-box-pack: justify;
          -ms-flex-pack: justify;
          justify-content: space-between;
        }
        
        #zipcode {
          -webkit-box-pack: center;
          -ms-flex-pack: center;
          justify-content: center;
        }
        
        #city {
          -webkit-box-pack: end;
          -ms-flex-pack: end;
          justify-content: flex-end;
        }
        
        #VAT-ID {
          margin-bottom: 1em;
        }
        
        #VAT_nr {
          width: 20em;
          margin-left: 1em;
        }
        
        #VAT_name {
          width: 100%;
        }
        
        #VAT_street {
          margin-left: 1em;
          width: 20em;
        }
        
        #VAT_zipcode {
          margin-left: 1em;
        }
        
        #VAT_city {
          margin-left: 1em;
        }
        
        #country {
          margin-right: 2em;
        }
        
        #VAT_country {
          margin-left: 1em;
        }
        
        #VAT_state {
          margin-left: 1em;
        }
        
        #additional_info {
          width: 100%;
        }
      </style>

      <script>
        function toggleDisableExcursion() {
          checkbox = document.getElementById("excursion_no");
          ex1krakow = document.getElementById("excursion1_krakow");
          ex1ojcow = document.getElementById("excursion1_ojcow");
          ex1wieliczka = document.getElementById("excursion1_wieliczka");
          ex2krakow = document.getElementById("excursion2_krakow");
          ex2ojcow = document.getElementById("excursion2_ojcow");
          ex2wieliczka = document.getElementById("excursion2_wieliczka");
          
          ex1 = document.getElementById("ex1");
          ex2 = document.getElementById("ex2");

          /*if(ex1krakow.disabled && ex1ojcow.disabled) {
            if(ex1.value == "krakow") {
              ex2krakow.disabled = true;
            } else {
              ex2krakow.disabled = false;
            }
            if(ex1.value == "ojcow") {
              ex2ojcow.disabled = true;
            } else {
              ex2ojcow.disabled = false;
            }
            if(ex1.value == "wieliczka") {
              ex2wieliczka.disabled = true;
            } else {
              ex2wieliczka.disabled = false;
            }
            if(ex2.value == "krakow") {
              ex1krakow.disabled = true;
            } else {
              ex1krakow.disabled = false;
            }
            if(ex2.value == "ojcow") {
              ex1ojcow.disabled = true;
            } else {
              ex1ojcow.disabled = false;
            }
            if(ex2.value == "wieliczka") {
              ex1wieliczka.disabled = true;
            } else {
              ex1wieliczka.disabled = false;
            }
          } else {
            ex1krakow.disabled = true;
            ex1wieliczka.disabled = true;
            ex1ojcow.disabled = true;
            ex2krakow.disabled = true;
            ex2wieliczka.disabled = true;
            ex2ojcow.disabled = true;
          }*/
          
          /*ex1krakow.disabled = !ex1krakow.disabled;
          ex1ojcow.disabled = !ex1ojcow.disabled;*/
          ex1wieliczka.disabled = !ex1wieliczka.disabled;
          /*ex2krakow.disabled = !ex2krakow.disabled;
          ex2ojcow.disabled = !ex2ojcow.disabled;*/
          ex2wieliczka.disabled = !ex2wieliczka.disabled;
        }

        function toggleDisableDinner() {
          meat = document.getElementById("dinner_meat");
          veg = document.getElementById("dinner_veg");

          meat.disabled = !meat.disabled;
          veg.disabled = !veg.disabled;
        }

        function VAT_change() {
          var nr = document.getElementById("VAT_nr");

          nr.disabled = !nr.disabled;
          nr.required = !nr.required;
        }

        function VAT_checkcountry(val) {
          if (val === "United States") {
            document.getElementById("VAT_state").disabled = false;
            document.getElementById("VAT_state").required = true;
          } else {
            document.getElementById("VAT_state").disabled = true;
            document.getElementById("VAT_state").required = false;
          }
        }

        function toggle_affiliation() {
          var data_in = JSON.parse('<?php echo json_encode($affiliation_data);?>');
          var same = document.getElementById("same_q");
          var same_hidden = document.getElementById("same_affiliation_hidden");
          var name = document.getElementById("VAT_name");
          var street = document.getElementById("VAT_street");
          var zipcode = document.getElementById("VAT_zipcode");
          var city = document.getElementById("VAT_city");
          var country = document.getElementById("VAT_country");
          var state = document.getElementById("VAT_state");

          if (same.value == "1") {
            name.value = "";
            street.value = "";
            zipcode.value = "";
            city.value = "";
            country.value = "";
            state.value = "";
            name.disabled = false;
            street.disabled = false;
            zipcode.disabled = false;
            city.disabled = false;
            country.disabled = false;
            state.disabled = true;
            same.value = "0";
            same_hidden.value = "0";
          } else {
            name.value = data_in['name'];
            street.value = data_in['street'];
            zipcode.value = data_in['zipcode'];
            city.value = data_in['city'];
            country.value = data_in['country'];
            state.value = data_in['state'];
            name.disabled = true;
            street.disabled = true;
            zipcode.disabled = true;
            city.disabled = true;
            country.disabled = true;
            state.disabled = true;
            same.value = "1";
            same_hidden.value = "1";
          }
        }
      </script>

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

              <form id="register_participant" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

                <p class="additions">Received grants, if any, will be automatically subtracted from your final payment.</p>

                <h2>Registration fee</h2>
                <p>Select registration type:</p>
                <input type="radio" name="registration_type" id="type_regular" value="Regular" <?php echo ($_SESSION["register"]["type"]=="Regular") ? " checked" : "";?>>
                <label for="type_regular">Regular participant</label>
                <input type="radio" name="registration_type" id="type_student" value="Student" <?php echo ($_SESSION["register"]["type"]=="Student") ? " checked" : "";?>>
                <label for="type_student">Student</label>
                <input type="radio" name="registration_type" id="type_one_day" value="One day" <?php echo ($_SESSION["register"]["type"]=="One day") ? " checked" : "";?>>
                <label for="type_one_day">One Day Attendee</label>
                <input type="radio" name="registration_type" id="type_exgibitor" value="Exhibitor" <?php echo ($_SESSION["register"]["type"]=="Exhibitor") ? " checked" : "";?>>
                <label for="type_exhibitor">Exhibitor</label>
                <input type="radio" name="registration_type" id="type_invited" value="Invited" <?php echo ($_SESSION["register"]["type"]=="Invited") ? " checked" : "";?>>
                <label for="type_invited">Invited speaker</label>

                <h2>IUVSTA Short Course</h2>
                <p>I am planning to participate in the IUVSTA Short Course on Sunday:</p>
                <input type="radio" name="short_course" id="short_course_yes" value="yes" <?php echo ($_SESSION["register"]["short_course"]=="yes") ? " checked" : "";?>>
                <label for="short_course_yes">Yes</label>
                <input type="radio" name="short_course" id="short_course_no" value="no" <?php echo ($_SESSION["register"]["short_course"]=="no") ? " checked" : "";?>>
                <label for="short_course_no">No</label>

                <h2>Excursion</h2>
                <p>Please select excursion. Depending on the availability we will honor your choices in the order given below.</p>
                <p class="important">Only excursion to the Wieliczka Salt Mine is available now.</p>
                
                <input type="checkbox" name="excursion_no" id="excursion_no" value="excursion_no" onchange="toggleDisableExcursion()" <?php echo ($_SESSION["register"]["excursion_q"]) ? "" : " checked";?>>
                <label for="excursion_no">I do not plan to participate</label>
                
                <p>First choice:</p>
                
                <input type="radio" name="excursion1" id="excursion1_krakow" value="krakow" <?php echo ($_SESSION["register"]["excursion1"]=="krakow") ? " checked" : "";/* echo (!$_SESSION["register"]["excursion_q"]) ? " disabled" : "";*/?> disabled>
                <label for="excursion1_krakow">Old Krak&oacute;w</label>
                
                <input type="radio" name="excursion1" id="excursion1_ojcow" value="ojcow" <?php echo ($_SESSION["register"]["excursion1"]=="ojcow") ? " checked" : "";/* echo (!$_SESSION["register"]["excursion_q"]) ? " disabled" : "";*/?> disabled>
                <label for="excursion1_ojcow">The Ojc&oacute;w National Park</label>
                
                <input type="radio" name="excursion1" id="excursion1_wieliczka" value="wieliczka" <?php echo ($_SESSION["register"]["excursion1"]=="wieliczka") ? " checked" : ""; echo (!$_SESSION["register"]["excursion_q"]) ? " disabled" : "";?>>
                <label for="excursion1_wieliczka">The Wieliczka Salt Mine</label>
                
                <input type="hidden" name="ex1" id="ex1" value="<?php echo empty($_SESSION["register"]["excursion1"]) ? "wieliczka" : $_SESSION["register"]["excursion1"];?>">
                
                <p>Second choice:</p>
                
                <input type="radio" name="excursion2" id="excursion2_krakow" value="krakow" <?php echo ($_SESSION["register"]["excursion2"]=="krakow") ? " checked" : "";/* echo (!$_SESSION["register"]["excursion_q"]) ? " disabled" : "";*/?> disabled>
                <label for="excursion2_krakow">Old Krak&oacute;w</label>
                
                <input type="radio" name="excursion2" id="excursion2_ojcow" value="ojcow" <?php echo ($_SESSION["register"]["excursion2"]=="ojcow") ? " checked" : "";/* echo (!$_SESSION["register"]["excursion_q"]) ? " disabled" : "";*/?> disabled>
                <label for="excursion2_ojcow">The Ojc&oacute;w National Park</label>
                
                <input type="radio" name="excursion2" id="excursion2_wieliczka" value="wieliczka" <?php echo ($_SESSION["register"]["excursion2"]=="wieliczka") ? " checked" : ""; echo (!$_SESSION["register"]["excursion_q"]) ? " disabled" : "";?>>
                <label for="excursion2_wieliczka">The Wieliczka Salt Mine</label>
                
                <input type="hidden" name="ex2" id="ex2" value="<?php echo empty($_SESSION["register"]["excursion2"]) ? "wieliczka" : $_SESSION["register"]["excursion2"];?>">
                
                <p class="additions">Participation to tours is limited: groups will be formed based on the date of registration payment.</p>

                <h2>Conference Banquet</h2>
                <input type="checkbox" name="dinner_no" id="dinner_no" value="dinner_no" onchange="toggleDisableDinner()" <?php echo ($_SESSION["register"]["dinner_q"]) ? "" : " checked";?>>
                <label for="dinner_no">I do not plan to participate</label>
                <p>Select a meal:</p>
                <input type="radio" name="dinner" id="dinner_meat" value="meat" <?php echo ($_SESSION["register"]["dinner"]=="meat") ? " checked" : ""; echo ($_SESSION["register"]["dinner_q"]) ? "" : " disabled";?>>
                <label for="dinner_meat">Meat/Fish</label>
                <input type="radio" name="dinner" id="dinner_veg" value="veg" <?php echo ($_SESSION["register"]["dinner"]=="veg") ? " checked" : ""; echo ($_SESSION["register"]["dinner_q"]) ? "" : " disabled";?>>
                <label for="dinner_veg">Vegetarian</label>

                <h2>Accompanying persons</h2>
                <p class="additions">Accompanying person(s) should be registered and paid for <strong>separately</strong> by using <span class="menu-item">Add accompanying persons</span> in <span class="menu-item">My Account</span>.</p>

                <hr>

                <h2>Invoice address</h2>
                
                <div class="whole-width">
                  <input type="hidden" name="same_q" id="same_q" value="<?php echo $_SESSION["register"]["same_affiliation"] ? "1" : "0";?>">
                  <input type="hidden" name="same_affiliation" id="same_affiliation_hidden" value="<?php echo $_SESSION["register"]["same_affiliation"] ? "1" : "0";?>">
                  <input type="checkbox" name="same_affiliation" id="same_affiliation" value="1" onchange="toggle_affiliation()"<?php echo $_SESSION["register"]["same_affiliation"] ? " checked" : "";?>>
                  <label for="same_affiliation">Same address as main affiliation's address</label>
                </div>

                <div class="whole-width">
                  <label for="VAT_name">Company Name</label>
                  <input type="text" name="VAT_name" id="VAT_name" required<?php echo !empty($_SESSION["register"]["VAT_name"]) ? " value=\"".$_SESSION["register"]["VAT_name"]."\"" : ""; echo (!$_SESSION["register"]["same_affiliation"]) ? "" : " disabled";?>>
                </div>

                <div class="whole-width" id="street-zip-city">
                  <div class="width-33" id="street">
                    <label for="VAT_street">Street</label>
                    <input type="text" name="VAT_street" id="VAT_street" required<?php echo !empty($_SESSION["register"]["VAT_street"]) ? " value=\"".$_SESSION["register"]["VAT_street"]."\"" : ""; echo (!$_SESSION["register"]["same_affiliation"]) ? "" : " disabled";?>>
                  </div>

                  <div class="width-33" id="zipcode">
                    <label for="VAT_zipcode">Zipcode</label>
                    <input type="text" name="VAT_zipcode" id="VAT_zipcode" required<?php echo !empty($_SESSION["register"]["VAT_zipcode"]) ? " value=\"".$_SESSION["register"]["VAT_zipcode"]."\"" : ""; echo (!$_SESSION["register"]["same_affiliation"]) ? "" : " disabled";?>>
                  </div>

                  <div class="width-33" id="city">
                    <label for="VAT_city">City</label>
                    <input type="text" name="VAT_city" id="VAT_city" required<?php echo !empty($_SESSION["register"]["VAT_city"]) ? " value=\"".$_SESSION["register"]["VAT_city"]."\"" : ""; echo (!$_SESSION["register"]["same_affiliation"]) ? "" : " disabled";?>>
                  </div>
                </div>

                <div class="whole-width" id="country-state">
                  <div class="width-50" id="country">
                    <label for="VAT_country">Country</label>
                    <select id="VAT_country" name="VAT_country" onchange="VAT_checkcountry(this.value)" required<?php echo (!$_SESSION["register"]["same_affiliation"]) ? "" : " disabled";?>>
                    <option value="">Country...</option>
                    <?php
                    foreach ($all_countries as $some_country) {
                      echo "<option value=\"" . $some_country . "\"";
                      if($some_country == $_SESSION["register"]["VAT_country"]) {
                        echo " selected";
                      }
                      echo ">" . $some_country . "</option>\n";
                    }
                    ?>
                    </select>
                  </div>

                  <div class="width-50" id="state">
                    <label for="VAT_state">State</label>
                    <select id="VAT_state" name="VAT_state" <?php echo ($_SESSION["register"]["VAT_country"]==$USA_name and (!$_SESSION["register"]["same_affiliation"])) ? "" : " disabled";?>>
                      <option value="">State...</option>
                      <?php
                      foreach ($all_states as $some_state_abbr => $some_state_name) {
                        echo "<option value=\"" . $some_state_abbr . "\"";
                        if($some_state_abbr == $_SESSION["register"]["VAT_state"]) {
                          echo " selected";
                        }
                        echo ">" . $some_state_name . "</option>\n";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                
                <hr>

                <h2>VAT invoice</h2>
                
                <div class="whole-width">
                  <input type="checkbox" name="invoice" id="invoice" value="1" onchange="VAT_change()" <?php echo (!$_SESSION["register"]["invoice"]) ? " checked" : "";?>>
                  <label for="invoice">Outside of EU / No VAT number</label>
                </div>
                
                <div class="whole-width" id="VAT-ID">
                  <label for="VAT_nr">VAT identification number</label>
                  <input type="text" name="VAT_nr" id="VAT_nr" <?php echo !empty($_SESSION["register"]["VAT_nr"]) ? " value=".$_SESSION["register"]["VAT_nr"] : ""; echo ($_SESSION["register"]["invoice"]) ? " required" : " disabled";?>>
                </div>

                <hr>

                <h2>Additional informations</h2>
                <p>Additional message to the Organizers if needed (<span id="additional_counter">255</span> characters left):</p>
                <textarea name="additional_info" id="additional_info" maxlength="255" onInput="textCounter(this,'additional_counter',255)"><?php echo $_SESSION["register"]["additional_info"];?></textarea>

                <hr>

                <input type="submit" name="register" id="register" value="Summary">
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
