<?php
require "./extras/always_require.php";

//check if logged in, if not send to login page and terminate the script
if(empty($_SESSION["login"])) {
  $_SESSION["last_site"] = "user_summary";
  header("Location:login.php");
  exit;
}

//no need to check if comes from proper page

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if(!empty($_POST["payment"])) {
    $_SESSION["fee_type"] = $_POST["type"];
    $_SESSION["last_site"] = "user_summary";
    
    header("Location:payment.php");
    exit;
  }
  
  if(!empty($_POST["add_accomp"])) {
    $_SESSION["last_site"] = "user_summary";
    header("Location:register_accomp1.php");
    exit;
  }
}

require('./database/db_connect.php');

//Person data
$sql = "SELECT last_name, first_name, middle_name, full_name, title, email, registered FROM `people` WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["person_id"]));
$person = $stmt->fetch(PDO::FETCH_ASSOC);

//Registration data if registered
if($person["registered"]) {
  $sql = "SELECT type, excursion_first, excursion_second, dinner, short_course, additional_info, vat_invoice, vat_nr, vat_affiliation FROM `people` WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($_SESSION["person_id"]));
  $registration = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $sql = "SELECT personal_cost, short_course_cost, personal_grant, personal_fee, personal_paid, accomp_cost, accomp_grant, accomp_fee, accomp_paid, total_fee, fee_paid FROM users WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($_SESSION["user_id"]));
  $fees = $stmt->fetch(PDO::FETCH_ASSOC);
  
  if($fees["personal_grant"] >= $fees["personal_cost"]) {
    $fees["personal_cost"] = 0.00;
    $fees["personal_grant"] = 0.00;
  }
  
  $sql = "SELECT id, affiliation1, affiliation2, country, state, city, street, zipcode FROM `affiliations` WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($registration["vat_affiliation"]));
  $registration["vat_affiliation"] = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
  $registration = null;
}

if($registration["type"] == "regular") {
  $registration["type_show"] = "Regular";
} else if($registration["type"] == "student") {
  $registration["type_show"] = "Student";
} else if($registration["type"] == "exhibitor") {
  $registration["type_show"] = "Exhibitor";
} else if($registration["type"] == "invited") {
  $registration["type_show"] = "Invited speaker";
} else if($registration["type"] == "one_day") {
  $registration["type_show"] = "One day participant";
} else {
  $registration["type_show"] = $registration["type"];
}

$registration["excursion_first_show"] = get_excursion_showname($registration["excursion_first"]);

$registration["excursion_second_show"] = get_excursion_showname($registration["excursion_second"]);

if($registration["dinner"] == "meat") {
  $registration["dinner_show"] = "Meat/Fish";
} else if($registration["dinner"] == "veg") {
  $registration["dinner_show"] = "Vegetarian";
} else {
  $registration["dinner_show"] = $registration["dinner"];
}

//Affiliation data
$sql = "SELECT affiliation_id, order_nr FROM affiliations_to_people WHERE person_id=?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["person_id"]));
$affiliations_ids = array();
while($aff = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $affiliations_ids[] = $aff;
}

$sql = "SELECT affiliation1, affiliation2, country, state, city, street, zipcode FROM `affiliations` WHERE id=?";
$stmt = $conn->prepare($sql);
$affiliations = array();
foreach($affiliations_ids as $aff_id) {
  $stmt->execute(array($aff_id["affiliation_id"]));
  $affiliations[] = $stmt->fetch(PDO::FETCH_ASSOC);
}
$affiliation = $affiliations[0];

//User data
$sql = "SELECT username, accomp_persons FROM `users` WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["user_id"]));
$participant = $stmt->fetch(PDO::FETCH_ASSOC);

//Accompanying persons data if registered
if($participant["accomp_persons"] != 0) {
  $sql = "SELECT GROUP_CONCAT(DISTINCT(person_id)) AS ids FROM `accomp_to_users` WHERE user_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($_SESSION["user_id"]));
  $accomp_nrs = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $accomp_persons = array();
  $sql = "SELECT first_name, middle_name, last_name, full_name, title, excursion_first, excursion_second, dinner, additional_info FROM `people` WHERE id IN (".$accomp_nrs["ids"].")";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  
  while($answer = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $answer["excursion_first_show"] = get_excursion_showname($answer["excursion_first"]);
    
    $answer["excursion_second_show"] = get_excursion_showname($answer["excursion_second"]);

    if($answer["dinner"] == "meat") {
      $answer["dinner_show"] = "Meat/Fish";
    } else if($answer["dinner"] == "veg") {
      $answer["dinner_show"] = "Vegetarian";
    } else {
      $answer["dinner_show"] = $answer["dinner"];
    }
    
    $accomp_persons[] = $answer;
  }
}

//Changes in list of abstracts
if($_SERVER["REQUEST_METHOD"] == "POST") {
  if(isset($_POST["ctrl"])) {
    $ctrl = explode("_", $_POST["ctrl"]);
    if($ctrl[0] == "delete") {
      $_SESSION["tmp"]["id"] = $ctrl[1];
      
      $conn = null;
      
      header("Location:abstract_delete.php");
      exit;
    }
  }
}

//List of abstracts
$sql = "SELECT GROUP_CONCAT(DISTINCT(abstract_id)) AS ids FROM `abstracts_to_people` WHERE person_id=?";
$stmt = $conn->prepare($sql);
$stmt->execute(array($_SESSION["person_id"]));
$abstracts_ids = $stmt->fetch(PDO::FETCH_ASSOC);

$abstracts = array();
if(!is_null($abstracts_ids["ids"])) {
  $sql = "SELECT id, title, name, type_proposed, accepted, type_assigned, session_assigned, file, award, change_time FROM `abstracts` WHERE id IN (".$abstracts_ids["ids"].")";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  while($abstract = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $abstracts[] = $abstract;
  }
  
  $length = count($abstracts);
  for($i = 0; $i < $length; $i++) {
    if($abstracts[$i]["type_proposed"] == "poster") {
      $abstracts[$i]["type_proposed"] = "Poster";
    } elseif($abstracts[$i]["type_proposed"] == "oral") {
      $abstracts[$i]["type_proposed"] = "Oral";
    } elseif($abstracts[$i]["type_proposed"] == "other") {
      $abstracts[$i]["type_proposed"] = "Oral/Poster";
    }
    
    if($abstracts[$i]["type_assigned"] == "poster") {
      $abstracts[$i]["type_assigned"] = "Poster";
    } elseif($abstracts[$i]["type_assigned"] == "oral") {
      $abstracts[$i]["type_assigned"] = "Oral";
    } elseif($abstracts[$i]["type_assigned"] == "other") {
      $abstracts[$i]["type_assigned"] = "Oral/Poster";
    }
  }
}

if(!empty($abstracts)) {
  $abstracts_people = array();
  foreach($abstracts as $abstract) {
    $sql = "SELECT GROUP_CONCAT(DISTINCT(person_id)) AS ids FROM `abstracts_to_people` WHERE abstract_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($abstract["id"]));
    $people_ids = $stmt->fetch(PDO::FETCH_ASSOC);
    $people_ids = explode(",", $people_ids["ids"]);
  
    $abstract_people = array();
    foreach($people_ids as $person_id) {
      $sql = "SELECT first_name, middle_name, last_name FROM `people` WHERE id=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($person_id));
      $abstract_person = $stmt->fetch(PDO::FETCH_ASSOC);
      $abstract_people[] = $abstract_person;
    }
    
    $abstracts_people[$abstract["id"]] = $abstract_people;
  }
}

$conn = null;

$_SESSION["last_site"] = "user_summary";
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
      table {
        margin: 0 auto;
      }

      thead {
        font-weight: bold;
      }

      td {
        border-bottom-style: solid;
        border-bottom-width: 1px;
        text-align: center;
      }

      table hr {
        margin-top: 0;
        margin-bottom: 0;
      }
      
      #fees {
        width: auto;
        margin: 0;
      }
      
      table .name {
        text-align: right;
        border: none;
      }
      
      table .amount {
        text-align: right;
        border: none;
      }
    </style>

    <title>SIMS21, Poland 2017 - User's summary</title>
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
          <h1>Summary of user <?php echo $participant["username"];?></h1>
          <h2>Personal data</h2>
          <p>
            <?php echo $person["title"]." ".$person["full_name"];?>
            <br>
            <?php
            foreach($affiliations as $aff) {
              echo "<br>";
              echo $aff["affiliation1"];
              if(!empty($aff["affiliation2"])) {
                echo " - ".$aff["affiliation2"];
              }
              echo "<br>\n";
              if(trim($aff["street"]) != "") {
                echo $aff["street"].", ";
              }
              if($aff["country"] == "United States") {
                echo $aff["state"]." ";
              }
              echo $aff["zipcode"]." ".$aff["city"].", ".$aff["country"];
              echo "<br>";
            }
            ?>
            <br> email:
            <?php echo $person["email"];?>
          </p>

          <hr>

          <h2>List of abstracts</h2>
          <?php if(empty($abstracts)):?>
          <p>No abstracts uploaded. Please proceed to <span class="menu-item">Abstracts</span> menu.</p>
          <?php else:?>
          <form id="abstracts" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>" method="post">
            <table>
              <thead>
                <tr>
                  <td>Accepted</td>
                  <td>Title</td>
                  <td>Authors</td>
                  <td>File</td>
                  <td>Form</td>
                  <td>Session</td>
                  <td title="Student award competition"><span class="fa fa-trophy"></span></td>
                  <td></td>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($abstracts as $abstract) {
                  echo "<tr>\n";
                  echo "<td>";
                  if(empty($abstract["accepted"])) {
                    echo "<span class=\"fa fa-question\"></span>";
                  } else if ($abstract["accepted"]) {
                    echo "<span class=\"fa fa-check\"></span>";
                  } else {
                    echo "<span class=\"fa fa-times\"></span>";
                  }
                  echo "</td>\n";
                  echo "<td>".htmlspecialchars_decode($abstract["title"])."</td>\n";
                  echo "<td>";
                  $authors = array();
                  foreach($abstracts_people[$abstract["id"]] as $abstract_person) {
                    $authors[] = get_full_name($abstract_person);
                  }
                  echo implode("<hr>", $authors);
                  echo "</td>\n";
                  if(empty($abstract["file"])) {
                    echo "<td><span class=\"fa fa-file-text-o\" title=\"".$abstract["name"]."\"></span></td>\n";
                  } else {
                    echo "<td><a href=\"abstracts\\".$abstract["file"]."\" download><span class=\"fa fa-file-text-o\" title=\"".$abstract["name"]."\"></span></a></td>\n";
                  }
                  if(empty($abstract["type_assigned"])) {
                    echo "<td>".$abstract["type_proposed"]." (proposed)</td>\n";
                  } else {
                    if($abstract["type_assigned"] == "Oral") {
                      echo "<td title=\"Oral\"><span class=\"fa fa-microphone type_assigned\"></span></td>";
                    } elseif($abstract["type_assigned"] == "Poster") {
                      echo "<td title=\"Poster\"><span class=\"fa fa-picture-o type_assigned\"></span></td>";
                    } elseif($abstract["type_assigned"] == "Oral/Poster") {
                      echo "<td title=\"Oral or poster\"><span class=\"fa fa-microphone type_assigned\"></span>/<span class=\"fa fa-picture-o type_assigned\"></span></td>";
                    }
                    echo "\n";
                  }
                  echo "<td>";
                  if(empty($abstract["session_assigned"])) {
                    echo "Not yet assigned";
                  } else {
                    echo $abstract["session_assigned"];
                  }
                  echo "</td>\n";
                  echo "<td>";
                  echo $abstract["award"] ? "<span class=\"fa fa-check\"></span>" : "" ;
                  echo "</td>\n";
                  echo "<td><button type=\"submit\" onclick=\"ctrlFunction('delete', ".$abstract["id"].")\" title=\"Delete abstract\"";
                  if($abstract["create_time"] < '2017-05-02') {
                    echo " disabled";
                  }
                  echo "><span class=\"fa fa-trash-o fa-fw\"></span></button></td>\n";
                  echo "</tr>\n";
                }
                ?>
              </tbody>
            </table>
            <input type="hidden" name="ctrl" id="ctrl" value="" disabled>
          </form>
          <?php endif;?>

          <hr>

          <h2>Conference registration</h2>
          <?php if($_SESSION["registered"]):?>
          <p>Registration type: <strong><?php echo $registration["type_show"];?></strong><br> Excursion:
            <?php
            if($registration["excursion_first"] == "none") {
              echo "<strong>None</strong><br>";
            } else {
              echo "<br>&nbsp;&nbsp;&nbsp;&nbsp;First choice: <strong>".$registration["excursion_first_show"]."</strong><br>";
              echo "&nbsp;&nbsp;&nbsp;&nbsp;Second choice: <strong>".$registration["excursion_second_show"]."</strong><br>";
            }
            echo "Conference dinner selection: ";
            if($registration["dinner"] == "none") {
              echo "<strong>None</strong><br>";
            } else {
              echo "<strong>".$registration["dinner_show"]."</strong><br>";
            }
            echo "IUVSTA Short Course: ";
            if($registration["short_course"]) {
              echo "<strong>Yes</strong><br>";
            } else {
              echo "<strong>No</strong><br>";
            }
            echo "Additional information:<br>";
            if(empty($registration["additional_info"])) {
              echo "<strong>None</strong>";
            } else {
              echo "<strong>".$registration["additional_info"]."</strong>";
            }
            echo "</p>\n";
            ?>
              <table id="fees">
              <tr>
                <td class="name">Registration fee:</td>
                <td class="amount"><?php echo number_format($fees["personal_cost"],2,"."," ");?></td>
              </tr>
              <?php //if($registration["short_course"]):?>
              <tr>
                <td class="name">Short course fee:</td>
                <td class="amount"><?php echo empty($fees["short_course_cost"]) ? "0.00" : number_format($fees["short_course_cost"],2,"."," ");?></td>
              </tr>
              <?php //endif;?>
              <tr>
                <td class="name">Total fee:</td>
                <td class="amount"><?php echo number_format($fees["personal_cost"] + $fees["short_course_cost"],2,"."," ");?></td>
              </tr>
              <tr>
                <td class="name">Grant:</td>
                <td class="amount"><?php echo (empty($fees["personal_grant"])) ? "0.00" : number_format($fees["personal_grant"],2,"."," ");?></td>
              </tr>
              <tr>
                <td class="name">Total payment:</td>
                <td class="amount"><?php echo number_format($fees["personal_fee"],2,"."," ");?></td>
              </tr>
              <tr>
                <td class="name">Paid:</td>
                <td class="amount"><?php echo number_format($fees["personal_paid"],2,"."," ");?></td>
              </tr>
              <tr>
                <td class="name">Due:</td>
                <td class="amount"><?php echo ($fees["personal_fee"] - $fees["personal_paid"] >= 30) ? "<span class=\"important\">".number_format($fees["personal_fee"] - $fees["personal_paid"],2,"."," ")."<span>" : "0.00";?></td>
              </tr>
            </table>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
              <input type="hidden" name="type" value="personal">
              <input type="submit" name="payment" value="Pay for your registration"<?php echo ($fees["personal_paid"] >= ($fees["personal_fee"] - 30)) ? " disabled" : "";?>>
            </form>
            <?php else: ?>
            <p>You are not registered. Please proceed to <span class="menu-item">Registration</span> menu.</p>
            <?php endif;?>

            <hr>

            <h2>Accompanying person(s)</h2>
            <?php if($_SESSION["registered"]):?>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="submit" name="add_accomp" value="<?php echo $participant["accomp_persons"] > 0 ? "Edit accompanying person(s)" : "Add accompanying person(s)";?>"<?php echo ($fees["accomp_paid"] > 0) ? " disabled" : "";?>>
              </form>
              <p>Number of accompanying persons:
                <?php echo $participant["accomp_persons"];?>
              </p>
          
              <?php if($participant["accomp_persons"] > 0):?>
                <?php
                $i = 0;
                foreach($accomp_persons as $accomp_person) {
                  $i++;
                  echo "<p>";
                  echo "".$i.") ".$accomp_person["title"]." ".$accomp_person["full_name"]."<br>";
                  echo "Additional information:<br>";
                  if(empty($accomp_person["additional_info"])) {
                    echo "<strong>None</strong>";
                  } else {
                    echo "<strong>".$accomp_person["additional_info"]."</strong>";
                  }
                  echo "</p>\n";
                }?>
                <table id="fees">
                  <tr>
                    <td class="name">Accompanying person(s) fee:</td>
                    <td class="amount"><?php echo empty($fees["accomp_cost"]) ? "0.00" : number_format($fees["accomp_cost"],2,"."," ");?></td>
                  </tr>
                  <tr>
                    <td class="name">Paid:</td>
                    <td class="amount"><?php echo number_format($fees["accomp_paid"] + $fees["accomp_grant"],2,"."," ");?></td>
                  </tr>
                  <tr>
                    <td class="name">Due:</td>
                    <td class="amount"><?php echo ($fees["accomp_fee"] - $fees["accomp_paid"] >= 30) ? "<span class=\"important\">".number_format($fees["accomp_fee"] - $fees["accomp_paid"],2,"."," ")."<span>" : "0.00";?></td>
                  </tr>
                </table>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                  <input type="hidden" name="type" value="accomp">
                  <input type="submit" name="payment" value="Pay for accompanying person(s)"<?php echo ($fees["accomp_fee"] - $fees["accomp_paid"] >= 30) ? "" : " disabled";?>>
                </form>
          
              <?php else: ?>
                <p>Na accompanying persons registered.</p>
              <?php endif;?>
          
            <?php else: ?>
              <p>You are not registered. Please proceed to <span class="menu-item">Registration</span> menu.</p>
            <?php endif;?>
          
            <hr>

            <h2>Invoice address</h2>
          
            <?php if($_SESSION["registered"]):?>
            <p>
              <?php
              echo "Name: <strong>".$registration["vat_affiliation"]["affiliation1"];
              if(!empty($registration["vat_affiliation"]["affiliation2"])) {
                echo " - ".$registration["vat_affiliation"]["affiliation2"];
              }
              echo "</strong><br>";
              echo "Street: <strong>".$registration["vat_affiliation"]["street"]."</strong><br>";
              echo "Zipcode: <strong>".$registration["vat_affiliation"]["zipcode"]."</strong><br>";
              echo "City: <strong>".$registration["vat_affiliation"]["city"]."</strong><br>";
              echo "Country: <strong>".$registration["vat_affiliation"]["country"]."</strong><br>";
              if(!empty($registration["vat_affiliation"]["state"])) {
                echo "State: <strong>".$all_states[$registration["vat_affiliation"]["state"]]."</strong><br>";
              }
              ?>
              </p>
              <?php else: ?>
              <p>Not available.</p>
              <?php endif;?>

            <hr>

            <h2>VAT information</h2>
            <?php if($_SESSION["registered"]):?>
            <p>
              <?php
              if($registration["vat_invoice"]) {
                echo "VAT number: <strong>".$registration["vat_nr"]."</strong><br>";
              } else {
                echo "No VAT invoice.";
              }
              ?>
              </p>
              <?php else: ?>
              <p>Not available.</p>
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