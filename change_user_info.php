<?php
require "./extras/always_require.php";

if (!isset($_SESSION["login"])) {
  $_SESSION["last_site"] = "change_user_info";
  header("Location:login.php");
  exit;
}

//no need to check if comes from proper page

$user_id = $_SESSION["user_id"];
$person_id = $_SESSION["person_id"];
$affiliation_id = $_SESSION["affiliation_id"];

require('./database/db_connect.php');

$required_fields = array(
  "first_name" => "First name",
  "last_name" => "Last name",
  "title" => "Title",
  "affiliation1" => "Affiliation 1",
  "city" => "City",
  "zipcode" => "Zip code",
  "street" => "Street",
  "country" => "Country",
  "email" => "Email"
);

$affiliation_fields = array(
  "affiliation1", "affiliation2", "country", "state", "city", "street", "zipcode"
);
$person_fields = array(
  "last_name", "first_name", "middle_name", "title", "email"
);
$additional_fields = array();
$all_fields = array_merge($affiliation_fields, $person_fields, $additional_fields);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $message = array();
  foreach($required_fields as $field => $name){
    if(empty($_POST[$field]) || $_POST[$field] == ""){
      $message[] = $name;
    }
  }
  if($_POST["country"]=="United States" && (empty($_POST["state"]) || $_POST["state"] == "")){
    $message[] = "State";
  }
  if(!empty($message)){
    $message = implode(", ", $message);
    $err = "Following fields are required and were not filled in: ".$message.".";
  }
  else {
    $values = array();
    foreach($all_fields as $field){
      $values[$field] = test_input($_POST[$field]);
    }
    if(!filter_var($values["email"], FILTER_VALIDATE_EMAIL)) {
      $err = "Invalid email format.";
    }

    $sql = "UPDATE `people` SET ";
    $message = array();
    $message_in = array();
    foreach($person_fields as $field){
      if($values[$field] == ""){
        $message[] = $field."=NULL";
      } else{
        $message[] = $field."=?";
        $message_in[] = $values[$field];
      }
    }
    $message[] = "full_name=?";
    $message_in[] = get_full_name($values);
    $message = implode(", ", $message);
    $sql = $sql.$message." WHERE id=?";
    $message_in[] = $person_id;
    
    $stmt = $conn->prepare($sql);
    $stmt->execute($message_in);

    $sql = "SELECT * FROM `affiliations` WHERE id=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($affiliation_id));
    $affiliation_data = $stmt->fetch(PDO::FETCH_ASSOC);
    $ok = true;
    foreach($affiliation_fields as $field){
      if($affiliation_data[$field] != $values[$field]){
        $ok = false;
        break;
      }
    }
    if($ok === false){
      $sql = "SELECT COUNT(*) FROM `people` WHERE affiliation_id=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($affiliation_id));
      if($stmt->fetchColumn() == 1){
        $sql = "UPDATE `affiliations` SET ";
        $message = array();
        $message_in = array();
        foreach($affiliation_fields as $field){
          if($values[$field] == ""){
            $message[] = $field."=NULL";
          } else{
            $message[] = $field."=?";
            $message_in[] = $values[$field];
          }
        }
        $message = implode(", ", $message);
        $sql = $sql.$message." WHERE id=?";
        $message_in[] = $affiliation_id;
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($message_in);
      } else{
        $sql = "INSERT INTO `affiliations` SET ";
        $message = array();
        $message_in = array();
        foreach($affiliation_fields as $field){
          if($values[$field] == ""){
            $message[] = $field."=NULL";
          } else{
            $message[] = $field."=?";
            $message_in[] = $values[$field];
          }
        }
        $message = implode(", ", $message);
        $sql = $sql.$message;
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($message_in);
        $affiliation_id_old = $affiliation_id;
        $affiliation_id = $conn->lastInsertId();
        $sql = "UPDATE `affiliations_to_people` SET affiliation_id=? WHERE affiliation_id=? AND person_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($affiliation_id, $affiliation_id_old, $person_id));
        
        $_SESSION["affiliation_id"] = $affiliation_id;
      }
    }
    
    $txt = $_SESSION["full_name"]." (user_id: ".$_SESSION["user_id"].", person_id: ".$_SESSION["person_id"].") changed his/her personal information.";
    log_save($conn, "change_user_info", $txt);
    
    $conn = null;
  }
} else {
  $values = array();
  $sql = "SELECT * FROM `people` WHERE id = ? LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($person_id));
  $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
  foreach ($person_fields as $field) {
    $values[$field] = $user_data[$field];
  }

  $sql = "SELECT * FROM `affiliations` WHERE id = ? LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($affiliation_id));
  $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
  foreach ($affiliation_fields as $field) {
    $values[$field] = $user_data[$field];
  }
}

$_SESSION["last_site"] = "change_user_info";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
require('./includes/head.html');
?>

      <title>SIMS21, Poland 2017 - Change personal information</title>
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
              <h1>Change personal information</h1>

              <form id="account" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."#openModal " ?>" method="post">
                <fieldset>
                  <label>Name</label>

                  <div class="form_entry form_name">
                    <label for="title">Title<sup class="required_info">*</sup></label>
                    <select id="title" name="title" tabindex="0" required>
                      <option value="">Title...</option>
                      <?php
                      foreach ($titles as $title) {
                        echo "<option value=\"" . $title . "\"";
                        if ($title == $values["title"]) {
                          echo " selected";
                        }
                        echo ">".$title."</option>\n";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form_entry form_name">
                    <label for="first_name">First<sup class="required_info">*</sup></label>
                    <input id="first_name" name="first_name" placeholder="First name" required tabindex="1" type="text" value="<?php echo $values["first_name"]; ?>">
                  </div>

                  <div class="form_entry form_name">
                    <label for="middle_name">Middle<sup class="required_info"></sup></label>
                    <input id="middle_name" name="middle_name" placeholder="Middle name" tabindex="2" type="text" value="<?php echo $values["middle_name"]; ?>">
                  </div>

                  <div class="form_entry form_name">
                    <label for="last_name">Last<sup class="required_info">*</sup></label>
                    <input id="last_name" name="last_name" placeholder="Last name" required tabindex="3" type="text" value="<?php echo $values["last_name"]; ?>">
                  </div>
                </fieldset>

                <fieldset>
                  <label>Main affiliation</label>
                  <p style="font-style: italic; font-size: 0.9em;">If you need to change additional affiliations please contact us at <a href="mailto:user@user.user?Subject=Change in affiliations">user@user.user</a></p>

                  <div class="form_entry form_affiliation">
                    <label for="affiliation1">Affiliation 1<sup class="required_info">*</sup></label>
                    <input id="affiliation1" name="affiliation1" placeholder="Affiliation 1" required tabindex="5" type="text" value="<?php echo $values["affiliation1"]; ?>">
                  </div>

                  <div class="form_entry form_affiliation">
                    <label for="affiliation2">Affiliation 2<sup class="required_info"></sup></label>
                    <input id="affiliation2" name="affiliation2" placeholder="Affiliation 2" tabindex="6" type="text" value="<?php echo $values["affiliation2"]; ?>">
                  </div>

                  <div class="form_entry form_address1">
                    <label for="city">City<sup class="required_info">*</sup></label>
                    <input id="city" name="city" placeholder="City" required tabindex="7" type="text" value="<?php echo $values["city"]; ?>">
                  </div>

                  <div class="form_entry form_address1">
                    <label for="zipcode">Zip-code<sup class="required_info">*</sup></label>
                    <input id="zipcode" name="zipcode" placeholder="Zip-code" required tabindex="8" type="text" value="<?php echo $values["zipcode"]; ?>">
                  </div>

                  <div class="form_entry form_address1">
                    <label for="street">Street<sup class="required_info">*</sup></label>
                    <input id="street" name="street" placeholder="Street" required tabindex="9" type="text" value="<?php echo $values["street"]; ?>">
                  </div>

                  <div class="form_entry form_address2">
                    <label for="country">Country<sup class="required_info">*</sup></label>
                    <select id="country" name="country" required tabindex="10" onchange="checkcountry(this.value)">
                      <option value="">Country...</option>
                      <?php
                      foreach ($all_countries as $country) {
                        echo "<option value=\"".$country."\"";
                        if ($country == $values["country"]) {
                          echo " selected";
                        }
                        echo ">".$country."</option>\n";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form_entry form_address2">
                    <label for="state">State<span id="state_required" style="visibility: <?php if($values["country"] != "United States"){ echo "hidden"; } else {echo "visible";} ?>;"><sup class="required_info">*</sup></span></label>
                    <select id="state" name="state" tabindex="11" <?php if($values["country"] != $USA_name){ echo " disabled"; }?>>
                      <option value="">State...</option>
                      <?php
                      foreach ($all_states as $state_abbr => $state_name) {
                        echo "<option value=\"".$state_abbr."\"";
                        if ($state_abbr == $values["state"]) {
                          echo " selected";
                        }
                        echo ">".$state_name."</option>\n";
                      }
                      ?>
                    </select>
                  </div>
                </fieldset>

                <fieldset>
                  <label>Additional information</label>

                  <div class="form_entry form_additional">
                    <label for="email">Email<sup class="required_info">*</sup></label>
                    <input id="email" name="email" placeholder="Email" required tabindex="12" type="text" value="<?php echo $values["email"]; ?>">
                  </div>
                </fieldset>

                <input class="button important" name="change" id="change_button" tabindex="13" value="Update" type="submit">
              </form>

              <p class="required_info"><sup>*</sup>) Required field</p>

              <div id="openModal" class="modalDialog">
                <div>
                  <a href="#close" title="Close" class="close">X</a>
                  <?php
                  if ($err == ""){
                    echo "<p>Your personal information has been changed.</p>";
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
