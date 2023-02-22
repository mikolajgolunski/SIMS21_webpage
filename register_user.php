<?php
require "./extras/always_require.php";

if (isset($_SESSION["login"])) {
  $_SESSION["last_site"] = "error";
  header("Location:index.php");
  exit;
}

//no need to check if comes from proper page

function send_mails($user_info) {
  require("./extras/PHPMailer/PHPMailerAutoload.php");
  require('./extras/mail_connect.php');
  $mail->addAddress("user@user.user", "SIMS21");
  $mail->Subject = "New user registered ".$user_info["username"].": ".$user_info["full_name"];
  $mail->Body = "There is a new user registered on the website: ".$user_info["username"]."\nName: ".$user_info["full_name"]."\nAffiliation1: ".$user_info["affiliation1"];
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
  }
/*
  $mail->clearAddresses();
  
  $mail->addAddress($user_info["email"]);
  $mail->Subject = "New account successfully created";
  $mail->Body = "Dear ".$user_info["title"]." ".$user_info["full_name"].",\n\nYour account has been successfully created.\n\nYour username is: ".$user_info["username"]."\n\nWe are looking forward to see you in Kraków.\n\nBest regards,\nSIMS21 Organizing Committee";
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
  }
*/
  $mail = null;
}

$required_fields = array(
  "email" => "Email",
  "username" => "Username",
  "password" => "Password",
  "re_password" => "Retyped password",
  "first_name" => "First name",
  "last_name" => "Last name",
  "title" => "Title",
  "affiliation1" => "Affiliation 1",
  "city" => "City",
  "zipcode" => "Zip code",
  "street" => "Street",
  "country" => "Country"
);

$affiliation_fields = array(
  "affiliation1", "affiliation2", "country", "state", "city", "street", "zipcode"
);
$person_fields = array(
  "last_name", "first_name", "middle_name", "title", "email"
);
$participant_fields = array("username", "password");
$additional_fields = array("re_password");
$all_fields = array_merge($affiliation_fields, $person_fields, $participant_fields, $additional_fields);

$err = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  foreach($all_fields as $field) {
    if($field != "password" and $field != "re_password") {
      $_SESSION["registration"][$field] = $_POST[$field];
    }
  }

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
  } else {
    $values = array();
    foreach($all_fields as $field){
      if($field != "password" && $field != "re_password"){
        $values[$field] = test_input($_POST[$field]);
      } else {
        $values[$field] = $_POST[$field];
      }
    }
    if (!filter_var($values["email"], FILTER_VALIDATE_EMAIL)) {
      $err = "Invalid email format.";
      $values["email"] = "";
      $_SESSION["registration"]["email"] = "";
    }
    elseif ($values["password"] != $values["re_password"]) {
      $err = "Both passwords are different. Please check for typing errors.";
      $values["password"] = "";
      $values["re_password"] = "";
    } else {
      require('./database/db_connect.php');

      $sql = "SELECT COUNT(*) FROM `users` WHERE username = ? LIMIT 1";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($values["username"]));
      $users_count = $stmt->fetchColumn();
      if($users_count > 0) {
        $err = "Username already present in the database. Please choose another username or login to the existing account.";
        $values["username"] = "";
        $_SESSION["registration"]["username"] = "";
      } else {
        $values["password"] = create_hash($values["password"]);

        $sql = "INSERT INTO `affiliations` SET ";
        $message = array();
        $input = array();
        foreach($affiliation_fields as $field){
          if($values[$field] == ""){
            $message[] = $field."=NULL";
          } else{
            $message[] = $field."=?";
            $input[] = $values[$field];
          }
        }
        $message[] = "create_time=NULL";
        $message = implode(", ", $message);
        $sql = $sql.$message;
        $stmt = $conn->prepare($sql);
        $stmt->execute($input);
        $affiliation_id = $conn->lastInsertId();

        $sql = "INSERT INTO `people` SET ";
        $message = array();
        $input = array();
        foreach($person_fields as $field){
          if($values[$field] == ""){
            $message[] = $field."=NULL";
          } else{
            $message[] = $field."=?";
            $input[] = $values[$field];
          }
        }
        $message[] = "full_name=?";
        $input[] = get_full_name($values);
        $message[] = "affiliation_id=?";
        $input[] = $affiliation_id;
        $message[] = "create_time=NULL";
        $message = implode(", ", $message);
        $sql = $sql.$message;
        $stmt = $conn->prepare($sql);
        $stmt->execute($input);
        $person_id = $conn->lastInsertId();
        
        $sql = "INSERT INTO affiliations_to_people SET affiliation_id=?, person_id=?, create_time=NULL";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($affiliation_id, $person_id));

        $sql = "INSERT INTO `users` SET ";
        $message = array();
        $input = array();
        foreach($participant_fields as $field){
          if($values[$field] == ""){
            $message[] = $field."=NULL";
          } else{
            $message[] = $field."=?";
            $input[] = $values[$field];
          }
        }
        $message[] = "person_id=".$person_id;
        $message[] = "create_time=NULL";
        $message = implode(", ", $message);
        $sql = $sql.$message;
        $stmt = $conn->prepare($sql);
        $stmt->execute($input);
        
        $sql = "SELECT id, username, person_id FROM `users` WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($conn->lastInsertId()));
        $participant_data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql = "SELECT id, last_name, first_name, middle_name, full_name, title, email FROM `people` WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($participant_data["person_id"]));
        $person_data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $sql = "SELECT affiliation_id, person_id, order_nr FROM `affiliations_to_people` WHERE person_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array($participant_data["person_id"]));
        $person_data["affiliations_ids"] = array();
        while($aff = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $person_data["affiliations_ids"][] = $aff["affiliation_id"];
        }
        
        $sql = "SELECT id, affiliation1, affiliation2, country, state, city, street, zipcode FROM `affiliations` WHERE id=?";
        $stmt = $conn->prepare($sql);
        $affiliations_data = array();
        foreach($person_data["affiliations_ids"] as $affiliation_id) {
          $stmt->execute(array($affiliation_id));
          $affiliations_data[] = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        $affiliation_data = $affiliations_data[0];

        $user_info = array("email" => $person_data["email"], "username" => $participant_data["username"], "full_name" => $person_data["full_name"], "affiliation1" => $affiliation_data["affiliation1"], "title" => $person_data["title"]);
        send_mails($user_info);

        $conn = null;
        
        unset($_SESSION["registration"]);
        header("Refresh: 2; URL=login.php");
      }
    }
  } 
}

$_SESSION["last_site"] = "create_account";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
require('./includes/head.html');
?>

      <title>SIMS21, Poland 2017 - Create new account</title>
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
              <h1>Register new user</h1>

              <form id="account" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."#openModal" ?>" method="post">
                <fieldset>
                  <label>User data</label>

                  <div class="form_entry form_user">
                    <label for="email">Email<sup class="required_info">*</sup></label>
                    <input id="email" name="email" placeholder="Email" required type="email" value="<?php echo $_SESSION["registration"]["email"]?>">
                  </div>

                  <div class="form_entry form_user">
                    <label for="username">Username<sup class="required_info">*</sup></label>
                    <input id="username" name="username" placeholder="Username" required type="text" value="<?php echo $_SESSION["registration"]["username"]?>">
                  </div>

                  <div class="form_entry form_user">
                    <label for="password">Password<sup class="required_info">*</sup></label>
                    <input id="password" name="password" required type="password">
                  </div>

                  <div class="form_entry form_user">
                    <label for="re_password">Retype password<sup class="required_info">*</sup></label>
                    <input id="re_password" name="re_password" required type="password">
                  </div>
                </fieldset>

                <fieldset>
                  <label>Name</label>

                  <div class="form_entry form_name">
                    <label for="title">Title<sup class="required_info">*</sup></label>
                    <select id="title" name="title" required>
                      <option value="">Title...</option>
                      <?php
                      foreach ($titles as $some_title) {
                        echo "<option value=\"" . $some_title . "\"";
                        if($some_title == $_SESSION["registration"]["title"]) {
                          echo " selected";
                        }
                        echo ">" . $some_title . "</option>\n";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form_entry form_name">
                    <label for="first_name">First<sup class="required_info">*</sup></label>
                    <input id="first_name" name="first_name" placeholder="First name" required type="text" value="<?php echo $_SESSION["registration"]["first_name"]?>">
                  </div>

                  <div class="form_entry form_name">
                    <label for="middle_name">Middle<sup class="required_info"></sup></label>
                    <input id="middle_name" name="middle_name" placeholder="Middle name" type="text" value="<?php echo $_SESSION["registration"]["middle_name"]?>">
                  </div>

                  <div class="form_entry form_name">
                    <label for="last_name">Last<sup class="required_info">*</sup></label>
                    <input id="last_name" name="last_name" placeholder="Last name" required type="text" value="<?php echo $_SESSION["registration"]["last_name"]?>">
                  </div>
                </fieldset>

                <fieldset>
                  <label>Affiliation</label>

                  <div class="form_entry form_affiliation">
                    <label for="affiliation1">Affiliation 1<sup class="required_info">*</sup></label>
                    <input id="affiliation1" name="affiliation1" placeholder="Affiliation 1" required type="text" value="<?php echo $_SESSION["registration"]["affiliation1"]?>">
                  </div>

                  <div class="form_entry form_affiliation">
                    <label for="affiliation2">Affiliation 2<sup class="required_info"></sup></label>
                    <input id="affiliation2" name="affiliation2" placeholder="Affiliation 2" type="text" value="<?php echo $_SESSION["registration"]["affiliation2"]?>">
                  </div>

                  <div class="form_entry form_address1">
                    <label for="city">City<sup class="required_info">*</sup></label>
                    <input id="city" name="city" placeholder="City" required type="text" value="<?php echo $_SESSION["registration"]["city"]?>">
                  </div>

                  <div class="form_entry form_address1">
                    <label for="zipcode">Zip-code<sup class="required_info">*</sup></label>
                    <input id="zipcode" name="zipcode" placeholder="Zip-code" required type="text" value="<?php echo $_SESSION["registration"]["zipcode"]?>">
                  </div>

                  <div class="form_entry form_address1">
                    <label for="street">Street<sup class="required_info">*</sup></label>
                    <input id="street" name="street" placeholder="Street" required type="text" value="<?php echo $_SESSION["registration"]["street"]?>">
                  </div>

                  <div class="form_entry form_address2">
                    <label for="country">Country<sup class="required_info">*</sup></label>
                    <select id="country" name="country" required onchange="checkcountry(this.value)">
                      <option value="">Country...</option>
                      <?php
                      foreach ($all_countries as $some_country) {
                        echo "<option value=\"" . $some_country . "\"";
                        if($some_country == $_SESSION["registration"]["country"]) {
                          echo " selected";
                        }
                        echo ">" . $some_country . "</option>\n";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form_entry form_address2">
                    <label for="state">State<span id="state_required" style="visibility: <?php echo $_SESSION["registration"]["country"] == $USA_name ? "visible" : "hidden";?>;"><sup class="required_info">*</sup></span></label>
                    <select id="state" name="state" <?php echo $_SESSION["registration"]["country"]==$USA_name ? "" : " disabled";?>>
                      <option value="">State...</option>
                      <?php
                      foreach ($all_states as $some_state_abbr => $some_state_name) {
                        echo "<option value=\"" . $some_state_abbr . "\"";
                        if($some_state_abbr == $_SESSION["registration"]["state"]) {
                          echo " selected";
                        }
                        echo ">" . $some_state_name . "</option>\n";
                      }
                      ?>
                    </select>
                  </div>
                </fieldset>
                <input class="button important" name="register" id="register_button" value="Register" type="submit">
              </form>

              <p class="required_info"><sup>*</sup>) Required field</p>

              <div id="openModal" class="modalDialog">
                <div>
                  <?php
                  if ($err == ""){
                    echo "<p>Your account has been registered. You will be redirected to the login page. Please login to access personalized part of the website.<br>If you do not get redirected please click <a href=\"login.php\">here</a>.</p>";
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
