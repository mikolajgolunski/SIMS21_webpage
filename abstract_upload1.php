<?php
require "./extras/always_require.php";

//check if logged in, if not send to login page and terminate the script
if(empty($_SESSION["login"])) {
  $_SESSION["last_site"] = "abstract_upload1";
  header("Location:login.php");
  exit;
}

//no need to check if comes from proper page

unset($_SESSION["next"]);

require('./database/db_connect.php');

$required_check = true;

$sql = "SELECT COUNT(*) AS count FROM `abstracts_to_people` WHERE person_id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["person_id"]));
$abstract_count = $stmt->fetch(PDO::FETCH_ASSOC);

if($abstract_count["count"] > 0){
  $sql = "SELECT GROUP_CONCAT(abstract_id) AS ids FROM `abstracts_to_people` WHERE person_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($_SESSION["person_id"]));
  $abstracts = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $sql = "SELECT GROUP_CONCAT(DISTINCT(person_id)) AS ids FROM `abstracts_to_people` WHERE abstract_id IN (".$abstracts["ids"].")";
  $abstracts_people = $conn->query($sql);
  $abstracts_people = $abstracts_people->fetch(PDO::FETCH_ASSOC);
} else {
  $abstracts_people["ids"] = $_SESSION["person_id"];
}
if(isset($_SESSION["authors"])) {
  $temp_ids = explode(",", $abstracts_people["ids"]);
  foreach($_SESSION["authors"] as $person) {
    if(!in_array($person["id"], $temp_ids)) {
      $temp_ids[] = $person["id"];
    }
  }
  $abstracts_people["ids"] = implode(",", $temp_ids);
}
$sql = "SELECT id, last_name, first_name, middle_name, email FROM `people` WHERE id IN (".$abstracts_people["ids"].")";
$question = $conn->query($sql);
$people = array();
$affiliations = array();
$names_check = array("ids" => array(), "names" => array());
foreach($question as $person) {
  $person["affiliations"] = array();
  $person["affiliations_ids"] = array();
  $sql = "SELECT affiliation_id, person_id, order_nr FROM affiliations_to_people WHERE person_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($person["id"]));
  while($affiliation = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $person["affiliations"][] = $affiliation;
  }
  
  $sql = "SELECT id, affiliation1, affiliation2, country, state, city, street, zipcode FROM `affiliations` WHERE id = ? LIMIT 1";
  $stmt = $conn->prepare($sql);
  foreach($person["affiliations"] as $affiliation_info) {
    $person["affiliations_ids"][] = $affiliation_info["affiliation_id"];
    $stmt->execute(array($affiliation_info["affiliation_id"]));
    $affiliation = $stmt->fetch(PDO::FETCH_ASSOC);

    $affiliation["name_shown"] = $affiliation["affiliation1"];
    if(!in_array($affiliation["affiliation1"], $names_check["names"])) {
      $names_check["ids"][] = $affiliation["id"];
      $names_check["names"][] = $affiliation["affiliation1"];
    } elseif(!in_array($affiliation["id"], $names_check["ids"])) {
      $names_count = array_count_values($names_check["names"]);
      $affiliation["name_shown"] = $affiliation["name_shown"]." (".($names_count[$affiliation["affiliation1"]] + 1).")";
      $names_check["ids"][] = $affiliation["id"];
      $names_check["names"][] = $affiliation["affiliation1"];
    }
    $affiliations[$affiliation["id"]] = $affiliation;
  }
  if($person["id"] == $_SESSION["person_id"]) {
    $main_person = $person;
  } else {
    $people[] = $person;
  }
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["next_step"])) {
    $_SESSION["next"] = true;
    $_SESSION["last_site"] = "abstract_upload1";
    header("Location: abstract_upload2.php");
    exit;
  }

  if($_POST["submit"] == "Add author"){
    $required_author_fields = array("last_name", "first_name", "email");
    if(!isset($_POST["author_id"])) {
      foreach($required_author_fields as $field) {
        if(empty($_POST[$field])) {
          $required_check = false;
          $err_list[] = $field;
        }
      }
      if(!isset($_POST["affiliation_id"])) {
        $required_affiliation_fields = array("affiliation1", "city", "zipcode", "street", "country");
        if($_POST["country"] == "United States") {
          $required_affiliation_fields[] = "state";
        }
        foreach($required_affiliation_fields as $field) {
          if(empty($_POST[$field])) {
            $required_check = false;
            $err_list[] = $field;
          }
        }
      }
    }
    if($required_check){
      if(isset($_POST["affiliation_id"])) {
        $affiliation_id_checked = test_input($_POST["affiliation_id"]);
        $sql = "SELECT id, affiliation1, affiliation2, country, state, city, street, zipcode FROM `affiliations` WHERE id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($affiliation_id_checked));
        $author_affiliation = $stmt->fetch(PDO::FETCH_ASSOC);
      } else {
        $fields = array("affiliation1", "affiliation2", "city", "zipcode", "street", "country", "state");

        $author_affiliation = array();
        foreach($fields as $field) {
          $author_affiliation[$field] = test_input($_POST[$field]);
        }

        $sql = "INSERT INTO `affiliations` SET ";
        $message = array();
        $message_in = array();
        foreach($fields as $field){
          if($author_affiliation[$field] == ""){
            $message[] = $field."=NULL";
          } else{
            $message[] = $field."=?";
            $message_in[] = $author_affiliation[$field];
          }
        }
        $message[] = "create_time=NULL";
        $message = implode(", ", $message);
        $sql = $sql.$message;
        $stmt = $conn->prepare($sql);
        $stmt->execute($message_in);
        $author_affiliation["id"] = $conn->lastInsertId();
        
        $author_affiliation["name_shown"] = $author_affiliation["affiliation1"];
        if(!in_array($author_affiliation["affiliation1"], $names_check["names"])) {
          $names_check["ids"][] = $author_affiliation["id"];
          $names_check["names"][] = $author_affiliation["affiliation1"];
        } elseif(!in_array($author_affiliation["id"], $names_check["ids"])) {
          $names_count = array_count_values($names_check["names"]);
          $author_affiliation["name_shown"] = $author_affiliation["name_shown"]." (".($names_count[$author_affiliation["affiliation1"]] + 1).")";
          $names_check["ids"][] = $author_affiliation["id"];
          $names_check["names"][] = $author_affiliation["affiliation1"];
        }
        $affiliations[$author_affiliation["id"]] = $author_affiliation;
      }

      if(isset($_POST["author_id"])) {
        $author_id_checked = test_input($_POST["author_id"]);
        $sql = "SELECT id, last_name, first_name, middle_name, email, affiliation_id FROM `people` WHERE id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($author_id_checked));
        $author_data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql = "SELECT affiliation_id FROM affiliations_to_people WHERE person_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($author_id_checked));
        $author_data["affiliations_ids"] = array();
        while($aff = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $author_data["affiliations_ids"][] = $aff["affiliation_id"];
        }
      } else {
        $fields = array("last_name", "first_name", "middle_name", "email");

        $author_data = array();
        foreach($fields as $field) {
          $author_data[$field] = test_input($_POST[$field]);
        }

        $sql = "INSERT INTO `people` SET ";
        $message = array();
        $message_in = array();
        foreach($fields as $field){
          if($author_data[$field] == ""){
            $message[] = $field."=NULL";
          } else{
            $message[] = $field."=?";
            $message_in[] = $author_data[$field];
          }
        }
        $message[] = "full_name=?";
        $message_in[] = get_full_name($author_data);
        $message[] = "affiliation_id=?";
        $message_in[] = $author_affiliation["id"];
        $message[] = "type='author'";
        $message[] = "create_time=NULL";
        $message = implode(", ", $message);
        $sql = $sql.$message;
        $stmt = $conn->prepare($sql);
        $stmt->execute($message_in);
        
        $author_data["id"] = $conn->lastInsertId();
        $author_data["affiliations_ids"] = array($author_affiliation["id"]);
        
        $sql = "INSERT INTO affiliations_to_people SET affiliation_id=?, person_id=?, create_time=NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($author_affiliation["id"], $author_data["id"]));
        
        $sql = "INSERT INTO person_to_authors SET person_id=?, user_id=?, author_id=?, create_time=NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($_SESSION["person_id"], $_SESSION["user_id"], $author_data["id"]));
      }
      $_SESSION["authors"][] = $author_data;
    } else {
      $err = "Please fill in the required fields: ".implode(", ", $err_list);
    }
  } elseif(isset($_POST["ctrl"])) {
    $ctrl = explode("_", test_input($_POST["ctrl"]));
    if($ctrl[0] == "up") {
      moveElement($_SESSION["authors"], $ctrl[1], $ctrl[1]-1);
    } elseif($ctrl[0] == "down") {
      moveElement($_SESSION["authors"], $ctrl[1], $ctrl[1]+1);
    } elseif($ctrl[0] == "delete") {
      $deleted["presenting"] = $_SESSION["authors"][$ctrl[1]]["presenting"];
      unset($_SESSION["authors"][$ctrl[1]]);
      $_SESSION["authors"] = array_values($_SESSION["authors"]);
    }
  }

  if(isset($_POST["presenting"])) {
    if(isset($ctrl) and $ctrl[0] == "delete" and $deleted["presenting"]) {
      $presenting_checked = $_SESSION["person_id"];
    } else {
      $presenting_checked = test_input($_POST["presenting"]);
    }
    foreach($_SESSION["authors"] as $key => $person) {
      $_SESSION["authors"][$key]["presenting"] = ($person["id"] == $presenting_checked);
    }
  }
} else {
  /*if($_SESSION["abstract"]["last_step"] != 2) {
    unset($_SESSION["abstract"]);
    $main_person["presenting"] = true;
    $_SESSION["authors"] = array($main_person);
  }*/
  if(empty($_SESSION["authors"])){
    $main_person["presenting"] = true;
    $_SESSION["authors"] = array($main_person);
  }
}

$conn = null;

$_SESSION["abstract"]["last_step"] = 1;
$_SESSION["last_site"] = "abstract_upload1";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <script>
        function setAuthor() {
          var author = document.getElementById("known_authors");
          var selectedOption = author.options[author.selectedIndex];
          var authorValue = selectedOption.getAttribute("value");

          var first_name = document.getElementById("first_name");
          var middle_name = document.getElementById("middle_name");
          var last_name = document.getElementById("last_name");
          var email = document.getElementById("email");
          var known_affiliations = document.getElementById("known_affiliations");
          var author_id = document.getElementById("author_id");

          if (authorValue != "") {
            var peopleArray = <?php echo json_encode($people)?>;
            var peopleArrayLength = peopleArray.length;
            for (i = 0; i < peopleArrayLength; i++) {
              if (peopleArray[i].id == authorValue) {
                first_name.disabled = true;
                middle_name.disabled = true;
                last_name.disabled = true;
                email.disabled = true;
                known_affiliations.disabled = true;
                author_id.disabled = false;

                first_name.value = peopleArray[i].first_name;
                if (!peopleArray[i].middle_name) {
                  middle_name.value = " ";
                } else {
                  middle_name.value = peopleArray[i].middle_name;
                }
                last_name.value = peopleArray[i].last_name;
                email.value = peopleArray[i].email;
                for(j = 0; j < peopleArray[i].affiliations_ids.length; j++) {
                  known_affiliations.value = peopleArray[i].affiliations_ids[j];
                }
                author_id.value = peopleArray[i].id;

                known_affiliations.onchange();
                break;
              }
            }
          } else {
            first_name.disabled = false;
            middle_name.disabled = false;
            last_name.disabled = false;
            email.disabled = false;
            known_affiliations.disabled = false;
            author_id.disabled = true;

            first_name.value = "";
            middle_name.value = "";
            last_name.value = "";
            email.value = "";
            known_affiliations.value = "";
            author_id.value = "0";


            known_affiliations.onchange();
          }
        }

        function setAffiliation() {
          var affiliation = document.getElementById("known_affiliations");
          var selectedOption = affiliation.options[affiliation.selectedIndex];
          var affiliationValue = selectedOption.getAttribute("value");

          var affiliation1 = document.getElementById("affiliation1");
          var affiliation2 = document.getElementById("affiliation2");
          var city = document.getElementById("city");
          var zipcode = document.getElementById("zipcode");
          var street = document.getElementById("street");
          var country = document.getElementById("country");
          var state = document.getElementById("state");
          var affiliation_id = document.getElementById("affiliation_id");

          if (affiliationValue != "") {
            var affiliationsArray = <?php echo json_encode($affiliations)?>;
            for (key in affiliationsArray) {
              if (affiliationsArray[key].id == affiliationValue) {
                affiliation1.disabled = true;
                affiliation2.disabled = true;
                city.disabled = true;
                zipcode.disabled = true;
                street.disabled = true;
                country.disabled = true;
                state.disabled = true;
                affiliation_id.disabled = false;

                affiliation1.value = affiliationsArray[key].affiliation1;
                if (!affiliationsArray[key].affiliation2) {
                  affiliation2.value = " ";
                } else {
                  affiliation2.value = affiliationsArray[key].affiliation2;
                }
                city.value = affiliationsArray[key].city;
                zipcode.value = affiliationsArray[key].zipcode;
                street.value = affiliationsArray[key].street;
                country.value = affiliationsArray[key].country;
                state.value = affiliationsArray[key].state;
                affiliation_id.value = key;

                country.onchange();
                break;
              }
            }
          } else {
            affiliation1.disabled = false;
            affiliation2.disabled = false;
            city.disabled = false;
            zipcode.disabled = false;
            street.disabled = false;
            country.disabled = false;
            state.disabled = false;
            affiliation_id.disabled = true;

            affiliation1.value = "";
            affiliation2.value = "";
            city.value = "";
            zipcode.value = "";
            street.value = "";
            country.value = "";
            state.value = "";
            affiliation_id.value = "0";

            country.onchange();
          }
        }

        function ctrlFunction(type, id) {
          var ctrl = document.getElementById("ctrl");
          ctrl.value = type + "_" + id;
          ctrl.disabled = false;
        }
      </script>

      <style type="text/css">
        form > #known_authors {
          display: block;
          margin: 0 auto;
          margin-bottom: 1em;
        }
        
        form > #known_affiliations {
          display: block;
          margin: 0 auto;
          margin-bottom: 1em;
        }
        
        form > #submit {
          display: block;
          margin: 0 auto;
        }
        
        table > caption {
          font-weight: bold;
        }
        
        .control_arrows {
        }
        
        .control_other {
          
        }
      </style>

      <title>SIMS21, Poland 2017 - Abstract submission</title>
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
              <table id="bubble_tooltip">
                <tr class="bubble_middle">
                  <td>
                    <div id="bubble_tooltip_content"></div>
                  </td>
                </tr>
              </table>

              <h1>Abstract submission - Authors - step 1 of 4</h1>

              <?php if(!$required_check){echo "<p class=\"important\">.$err.</p>";} ?>

              <p class="important">Abstract must be submitted by the presenting author.</p>

              <p>Please add reference to all authors (other than yourself) by filling in required fields and clicking <span class="menu-item">Add author</span> button. All fields except for &quot;Middle name&quot;, &quot;Affiliation2&quot; and &quot;State&quot; (for non US participants) are obligatory.</p>

              <p>You may reuse data of previously entered authors and/or affiliations by choosing them from <span class="menu-item">Previous author</span> and/or <span class="menu-item">Previous affiliation</span> drop-down fields. Click <span class="menu-item">Next step</span> button when done.</p>

              <hr>

              <form id="add_author" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <select id="known_authors" name="known_authors" onchange="return setAuthor()">
                  <option value="">Previous author</option>
                  <?php
                  foreach($people as $person) {
                    echo "<option value=\"".$person["id"]."\">".get_full_name($person)."</option>\n";
                  }
                  ?>
                </select>
                <input type="hidden" name="author_id" id="author_id" value="0" disabled>

                <fieldset>
                  <input type="text" name="first_name" id="first_name" placeholder="First name" value="" required><sup class="required_info">*</sup>
                  <input type="text" name="middle_name" id="middle_name" placeholder="Middle name">
                  <input type="text" name="last_name" id="last_name" placeholder="Last name" required><sup class="required_info">*</sup>
                </fieldset>
                <fieldset>
                  <input type="email" name="email" id="email" placeholder="Email" size="41" required><sup class="required_info">*</sup>
                </fieldset>
                <br>
                <select id="known_affiliations" name="known_affiliations" onchange="return setAffiliation()">
                  <option value="">Previous affiliation</option>
                  <?php
                  foreach($affiliations as $affiliation_id => $affiliation) {
                    echo "<option value=\"".$affiliation_id."\">".$affiliation["name_shown"]."</option>\n";
                  }
                  ?>
                </select>
                <input type="hidden" name="affiliation_id" id="affiliation_id" value="0" disabled>
                <fieldset>
                  <input type="text" id="affiliation1" name="affiliation1" placeholder="Affiliation 1" size="30" required><sup class="required_info">*</sup>
                  <input type="text" id="affiliation2" name="affiliation2" placeholder="Affiliation 2" size="30">
                </fieldset>
                <fieldset>
                  <input type="text" id="city" name="city" placeholder="City" required><sup class="required_info">*</sup>
                  <input type="text" id="zipcode" name="zipcode" placeholder="Zip-code" required><sup class="required_info">*</sup>
                  <input type="text" id="street" name="street" placeholder="Street" required><sup class="required_info">*</sup>
                </fieldset>
                <fieldset>
                  <select id="country" name="country" onchange="checkcountry(this.value)" required>
                  <option value="">Country...</option>
                  <?php
                  foreach ($all_countries as $some_country) {
                    echo "<option value=\"" . $some_country . "\">" . $some_country . "</option>\n";
                  }
                  ?>
                  </select>
                  <sup class="required_info">*</sup>
                  <select id="state" name="state" required disabled>
                  <option value="">State...</option>
                  <?php
                  foreach ($all_states as $some_state_abbr => $some_state_name) {
                    echo "<option value=\"" . $some_state_abbr . "\">" . $some_state_name . "</option>\n";
                  }
                  ?>
                  </select>
                  <span id="state_required" style="visibility: hidden;"><sup class="required_info">*</sup></span>
                </fieldset>
                <br>
                <input type="submit" value="Add author" name="submit" id="submit">
              </form>

              <hr>

              <form id="edit_author" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <table>
                  <caption>List of authors</caption>
                  <thead>
                    <tr>
                      <td class="cursor_help" onmouseover="javascript:showToolTip(event, 'Presenting author', 1)" onmouseout="hideToolTip()"><span class="fa fa-microphone fa-fw"></span></td>
                      <td>Name</td>
                      <td>Email</td>
                      <td>Affiliation</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i = 0;
                    foreach($_SESSION["authors"] as $person) {
                      $aff_id = $person["affiliations_ids"][0];
                      echo "<tr>\n";
                      echo "<td><input type=\"radio\" name=\"presenting\" value=\"".$person["id"]."\"";
                      if($person["presenting"]) {
                        echo " checked";
                      }
                      echo " disabled></td>\n";
                      $data = array($person["first_name"], $person["middle_name"], $person["last_name"]);
                      echo "<td>".implode(" ", $data)."</td>\n";
                      echo "<td>".$person["email"]."</td>\n";
                      echo "<td class=\"cursor_help\" onmouseover=\"javascript:showToolTip(event,'".$affiliations[$aff_id]["affiliation1"]."<br>";
                      if ($affiliations[$aff_id]["affiliation2"] != "" || !empty($affiliations[$aff_id]["affiliation2"])) {
                        echo $affiliations[$aff_id]["affiliation2"]."<br>";
                      }
                      echo $affiliations[$aff_id]["street"].", ".$affiliations[$aff_id]["zipcode"]."<br>".$affiliations[$aff_id]["country"];
                      if ($affiliations[$aff_id]["country"] == "United States") {
                        echo ", ".$affiliations[$aff_id]["state"];
                      }
                      echo "',1)\" onmouseout=\"hideToolTip()\">".$affiliations[$aff_id]["name_shown"]."</td>\n";
                      echo "<td>
                      <div class=\"control_arrows\">
                      <button type=\"submit\" onclick=\"ctrlFunction('up', ".$i.")\"><span class=\"fa fa-arrow-up fa-fw\"></span></button>
                      <button type=\"submit\" onclick=\"ctrlFunction('down', ".$i.")\"><span class=\"fa fa-arrow-down fa-fw\"></span></button>
                      </div>";
                      /*echo "<button type=\"submit\" onclick=\"ctrlFunction('edit', ".$i.")\"";
                      if($person["id"] == $_SESSION["person_id"]) {
                        echo " disabled";
                      }
                      echo "><span class=\"fa fa-pencil-square-o fa-fw\"></span></button>";*/
                      echo "<div class=\"control_other\"><button type=\"submit\" onclick=\"ctrlFunction('delete', ".$i.")\"";
                      if($person["id"] == $_SESSION["person_id"]) {
                        echo " disabled";
                      }
                      echo "><span class=\"fa fa-trash-o fa-fw\"></span></button></div>
                      </td>\n";
                      echo "</tr>\n";
                      $i++;
                    }
                    ?>
                  </tbody>
                </table>
                <input type="hidden" name="ctrl" id="ctrl" value="" disabled>
                <input type="submit" value="Next step" name="next_step" id="next_step">
              </form>
              
              <p class="required_info"><sup>*</sup>) Required field</p>
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
