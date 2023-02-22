<?php
require "./extras/always_require.php";

if(!empty($_SESSION["mod"]["user_id"]) && $_SESSION["mod"]["user_id"] != $_SESSION["user_id"]) {
  $_SESSION["person_id"] = $_SESSION["mod"]["person_id"];
  $_SESSION["user_id"] = $_SESSION["mod"]["user_id"];
  $_SESSION["full_name"] = $_SESSION["mod"]["full_name"];
  $_SESSION["registered"] = $_SESSION["mod"]["registered"];
  header("Location:mod_choose_action.php");
  exit;
}

if(!empty($_POST["add_abstract"])) {
  $_SESSION["mod"]["user_id"] = $_SESSION["user_id"];
  $_SESSION["mod"]["person_id"] = $_SESSION["person_id"];
  $_SESSION["mod"]["full_name"] = $_SESSION["full_name"];
  $_SESSION["mod"]["registered"] = $_SESSION["registered"];
  $_SESSION["person_id"] = $_SESSION["mod"]["person"]["id"];
  $_SESSION["user_id"] = $_SESSION["mod"]["user"]["id"];
  $_SESSION["full_name"] = $_SESSION["mod"]["person"]["full_name"];
  header("Location:abstract_upload1.php");
  exit;
}

if($_SERVER["REQUEST_METHOD"] === "POST" && $_POST["method"] == "full_name") {
  $_SESSION["mod"]["method"] = "full_name";
  $_SESSION["mod"]["person"]["full_name"] = test_input($_POST["full_name"]);
}

$ok = true;


require "./database/db_connect.php";

$sql = "SELECT id, person_id FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute(array());
$users = array();
$person_ids = array();
while($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $users[$user["id"]] = $user;
  $person_ids[] = $user["person_id"];
}
$person_ids = implode(",", $person_ids);

$sql = "SELECT id, full_name FROM people WHERE id IN (".$person_ids.")";
$stmt = $conn->prepare($sql);
$stmt->execute(array());
$people = array();
while($person = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $people[$person["id"]] = $person;
}

/*---*/

if(true) {
  if($_SESSION["mod"]["method"] == "user_id") {
    $sql = "SELECT id FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($_SESSION["mod"]["user"]["id"]));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if(empty($user)) {
      $ok = false;
    }
  } elseif($_SESSION["mod"]["method"] == "full_name") {
    $sql = "SELECT id FROM people WHERE full_name=? AND (NOT (type='author' OR type='accomp' OR type='removed') OR type IS NULL)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($_SESSION["mod"]["person"]["full_name"]));
    $person = $stmt->fetch(PDO::FETCH_ASSOC);
    if(empty($person)) {
      $ok = false;
    } else {
      $sql = "SELECT id FROM users WHERE person_id=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($person["id"]));
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      $_SESSION["mod"]["user"]["id"] = $user["id"];
    }
    $_SESSION["mod"]["method"] = "user_id";
  } else {
    $ok = false;
  }
} else {
  $user["id"] = 1;
}

if($ok) {
  $sql = "SELECT * FROM users WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($user["id"]));
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $sql = "SELECT * FROM people WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($user["person_id"]));
  $person = $stmt->fetch(PDO::FETCH_ASSOC);
  $_SESSION["mod"]["person"]["id"] = $person["id"];
  $_SESSION["mod"]["person"]["full_name"] = $person["full_name"];
  
  $sql = "SELECT * FROM affiliations_to_people WHERE person_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($person["id"]));
  $affiliations_ids = array();
  while($affiliation_id = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $affiliations_ids[] = $affiliation_id;
  }
  
  $sql = "SELECT * FROM affiliations WHERE id=?";
  $stmt = $conn->prepare($sql);
  $affiliations = array();
  foreach($affiliations_ids as $affiliation_id) {
    $stmt->execute(array($affiliation_id["affiliation_id"]));
    $affiliation = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $affiliation["full_name"] = $affiliation["affiliation1"];
    if(!empty($affiliation["affiliation2"])) {
      $affiliation["full_name"] = $affiliation["full_name"]." - ".$affiliation["affiliation2"];
    }
    
    $affiliations[] = $affiliation;
  }
  
  $sql = "SELECT * FROM affiliations WHERE id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($person["vat_affiliation"]));
  $vat_affiliation = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $vat_affiliation["full_name"] = $vat_affiliation["affiliation1"];
  if(!empty($vat_affiliation["affiliation2"])) {
    $vat_affiliation["full_name"] = $vat_affiliation["full_name"]." - ".$vat_affiliation["affiliation2"];
  }
  
  $sql = "SELECT * FROM payments WHERE user_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($user["id"]));
  $payments = array();
  while($payment = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $payments[$payment["id"]] = $payment;
  }
  
  $sql = "SELECT person_id FROM accomp_to_users WHERE user_id=?";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($user["id"]));
  $accomps_ids = array();
  while($id = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $accomps_ids[] = $id["person_id"];
  }
  
  $sql = "SELECT * FROM people WHERE id=?";
  $stmt = $conn->prepare($sql);
  $accomps = array();
  foreach($accomps_ids as $id) {
    $stmt->execute(array($id));
    $accomps[$id] = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  
  $sql = "SELECT abstract_id FROM abstracts_to_people WHERE person_id=? AND presenting=1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($person["id"]));
  $abstracts_ids = array();
  while($id = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $abstracts_ids[] = $id["abstract_id"];
  }
  
  $sql = "SELECT person_id, presenting, corresponding FROM abstracts_to_people WHERE abstract_id=?";
  $stmt = $conn->prepare($sql);
  $abstracts = array();
  foreach($abstracts_ids as $id) {
    $stmt->execute(array($id));
    $abstracts[$id]["id"] = $id;
    $abstracts[$id]["authors"] = array();
    while($author = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $abstracts[$id]["authors"][$author["person_id"]] = $author;
    }
  }
  
  $sql = "SELECT * FROM people WHERE id=?";
  $stmt = $conn->prepare($sql);
  foreach($abstracts as $abstract) {
    foreach($abstract["authors"] as $author) {
      $stmt->execute(array($author["person_id"]));
      $abstracts[$abstract["id"]]["authors"][$author["person_id"]] = array_merge($abstracts[$abstract["id"]]["authors"][$author["person_id"]], $stmt->fetch(PDO::FETCH_ASSOC));
    }
  }
  
  $sql = "SELECT * FROM affiliations_to_people WHERE person_id=?";
  $stmt = $conn->prepare($sql);
  foreach($abstracts as $abstract) {
    foreach($abstract["authors"] as $author) {
      $stmt->execute(array($author["person_id"]));
      $abstracts[$abstract["id"]]["authors"][$author["person_id"]]["affiliations_ids"] = array();
      while($affiliation_id = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $abstracts[$abstract["id"]]["authors"][$author["person_id"]]["affiliations_ids"][] = $affiliation_id;
      }
      
    }
  }
  
  $sql = "SELECT * FROM affiliations WHERE id=?";
  $stmt = $conn->prepare($sql);
  foreach($abstracts as $abstract) {
    foreach($abstract["authors"] as $author) {
      $abstracts[$abstract["id"]]["authors"][$author["person_id"]]["affiliations"] = array();
      foreach($author["affiliations_ids"] as $affiliation_id) {
        $stmt->execute(array($affiliation_id["affiliation_id"]));
        $abstracts[$abstract["id"]]["authors"][$author["person_id"]]["affiliations"][] = $stmt->fetch(PDO::FETCH_ASSOC);
      }
    }
  }
  
  $sql = "SELECT * FROM abstracts WHERE id=?";
  $stmt = $conn->prepare($sql);
  foreach($abstracts as $abstract) {
    $stmt->execute(array($abstract["id"]));
    $abstracts[$abstract["id"]] = array_merge($abstracts[$abstract["id"]], $stmt->fetch(PDO::FETCH_ASSOC));
  }
}

$conn = null;

?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

    <style type="text/css">
      h2 {
        text-align: center;
      }
      
      .panes {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
      }

      .left_pane {
        -webkit-box-flex: 2;
        -ms-flex-positive: 2;
        flex-grow: 2;
        margin-right: 1em;
      }

      .right_pane {
        -webkit-box-flex: 1;
        -ms-flex-positive: 1;
        flex-grow: 1;
        flex-basis: 20em;
        margin-left: 1em;
      }

      .right_pane img {
        float: right;
      }
      
      .right_pane #basic_info {
        float: left;
      }
      
      .right_pane #registration_details {
        float: left;
        clear: both;
      }
      
      .right_pane #basic_info .yes {
        color: green;
      }
      
      .right_pane #basic_info .no {
        color: red;
      }

      tbody th {
        border-right: 1px solid #444;
        white-space: nowrap;
      }

      thead th {
        text-align: center;
      }

      tbody td {
        text-align: right;
      }
      
      tfoot td {
        text-align: right;
      }

      tr.success {
        background-color: #ccffcc;
      }

      tr.failure {
        background-color: #ffcccc;
      }
      
      .type_proposed {
        color: darkgoldenrod;
      }
      
      .type_assigned {
        color: green;
      }
      
      .topics_proposed {
        color: darkgoldenrod;
      }
      
      .topics_assigned {
        color: green;
      }
      
      .abstract_link {
        text-decoration: none;
        color: inherit;
      }
    </style>

      <title>SIMS21, Poland 2017</title>
  </head>

  <body>
    <div id="main">
      <?php
      require("./includes/menu.php");
      ?>

        <div id="content">
          <h1>Moderator view - user interaction</h1>
          
          <?php if($ok):?>
          
          <p>Choose another person</p>
          <form id="choose" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off">
            <input type="hidden" id="method" name="method" value="full_name">
            <label for="full_name">Full name</label>
            <input list="names" name="full_name" id="full_name">
            <datalist id="names">
              <?php
              foreach($users as $user_temp) {
                echo "<option value=\"".$people[$user_temp["person_id"]]["full_name"]."\">\n";
              }
              ?>
            </datalist>
            
            <br><br>
            
            <input type="submit" value="Choose" name="choose" id="choose">
          </form>
          
          <hr>
          
          <p>Choose action</p>
          <form id="action" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <input type="submit" id="add_abstract" name="add_abstract" value="Add abstract">
            <input type="submit" id="change_user_payments" name="change_user_payments" value="Change user's payments" disabled>
            <input type="submit" id="change_accomp_payments" name="change_accomp_payments" value="Change accomps' payments" disabled>
            <input type="submit" id="change_transactions" name="change_transactions" value="Change transactions" disabled>
            <input type="submit" id="change_abstracts" name="change_abstracts" value="Change abstracts" disabled>
          </form>

          <hr>
          
          <h2>User details</h2>
          
          <div class="panes">
            <div class="left_pane">
              <strong>Name and title:</strong> <?php echo $person["title"]." ".$person["full_name"];?><br>
              <strong>Username:</strong> <?php echo $user["username"];?><br>
              <strong>Email:</strong> <?php echo $person["email"];?><br>
              <strong>User ID:</strong> <?php echo $user["id"];?>; <strong>Person ID:</strong> <?php echo $person["id"];?>; <strong>Affiliation(s) ID(s):</strong> <?php $aff_ids = array(); foreach($affiliations as $aff) {$aff_ids[] = $aff["id"];} echo implode(",",$aff_ids);?><br>
              <strong>Comments:</strong> <?php echo empty($user["comments"]) ? "None" : $user["comments"];?>

              <h3>Affiliation(s)</h3>
              
              <?php foreach($affiliations as $affiliation):?>
                <strong>Name:</strong> <?php echo $affiliation["full_name"];?><br>
                <strong>Street:</strong> <?php echo $affiliation["street"];?><br>
                <strong>Zipcode:</strong> <?php echo $affiliation["zipcode"];?><br>
                <strong>City:</strong> <?php echo $affiliation["city"];?><br>
                <strong>Country:</strong> <?php echo $affiliation["country"];?>
                <?php if($affiliation["country"] == $USA_name):?>
                  <br><strong>State:</strong> <?php echo $affiliation["state"];?>
                <?php endif;?>
                <br><br>
              <?php endforeach;?>
            </div>
            <div class="right_pane">
              <?php /*
              <?php
              if($user["access_type"] == "admin") {
                $img = "admin.jpg";
              } elseif($user["access_type"] == "mod") {
                $img = "mod.jpg";
              } elseif($user["access_type"] == "user") {
                $img = "user.jpg";
              } else {
                $img = "unknown.jpg";
              }
              ?>
              <img src="img/mod/<?php echo $img;?>" class="access_type" alt="<?php echo "Type of access: ".$user["access_type"];?>">
              */ ?>
              
              <div id="basic_info">
                <span class="<?php echo $person["registered"] ? "yes" : "no";?>"><strong>Registered:</strong> <?php echo $person["registered"] ? "<span class=\"fa fa-check\"></span>" : "<span class=\"fa fa-times\"></span>";?></span><br>
                <span class="<?php echo $person["paid"] ? "yes" : "no";?>"><strong>Paid:</strong> <?php echo $person["paid"] ? "<span class=\"fa fa-check\"></span>" : "<span class=\"fa fa-times\"></span>";?></span><br>
                <strong>Type:</strong> <?php echo $person["type"];?><br>
                <strong>Accomp nr:</strong> <?php echo $user["accomp_persons"];?><br>
                <strong>Student competition:</strong> 
                <?php
                $award = false;
                $supp_letter = false;
                foreach($abstracts as $abstract) {
                  if($abstract["award"]) {
                    $award = true;
                    $supp_letter = $abstract["support_letter"];
                    break;
                  }
                }
                if($award) {
                  echo "<span class=\"fa fa-check\"></span>";
                  echo " / ";
                  echo $supp_letter ? "<span class=\"fa fa-envelope yes\"></span>" : "<span class=\"fa fa-envelope no\"></span>";
                } else {
                  echo "<span class=\"fa fa-times\"></span>";
                }
                ?><br>&nbsp;
              </div>
              
              <div id="registration_details">
                <strong>Short course:</strong> <?php echo $person["short_course"] ? "<span class=\"fa fa-check\"></span>" : "<span class=\"fa fa-times\"></span>";?><br>
                <strong>Excursion 1:</strong> <?php echo $person["excursion_first"];?><br>
                <strong>Excursion 2:</strong> <?php echo $person["excursion_second"];?><br>
                <strong>Dinner:</strong> <?php echo $person["dinner"];?><br>
                <strong>Additional info:</strong><br><?php echo $person["additional_info"];?>
              </div>
            </div>
          </div>
          
          <h2>Payments details</h2>
          <div class="panes">
            <div class="left_pane">
              <h3>Invoice affiliation</h3>
              <strong>Name:</strong> <?php echo $vat_affiliation["full_name"];?><br>
              <strong>Street:</strong> <?php echo $vat_affiliation["street"];?><br>
              <strong>Zipcode:</strong> <?php echo $vat_affiliation["zipcode"];?><br>
              <strong>City:</strong> <?php echo $vat_affiliation["city"];?><br>
              <strong>Country:</strong> <?php echo $vat_affiliation["country"];?><br>
              <?php if($vat_affiliation["country"] == $USA_name):?>
              <strong>State:</strong> <?php echo $vat_affiliation["state"];?>
              <?php endif;?>
              
              <h3>VAT</h3>
              <strong>Number:</strong> <?php echo $person["vat_nr"];?>
            </div>
            <div class="right_pane">
              <table>
                <thead>
                  <tr>
                    <th></th>
                    <th style="width: 30%">Personal</th>
                    <th style="width: 30%">Accomp(s)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>Registration</th>
                    <td><?php echo $user["personal_cost"];?></td>
                    <td><?php echo $user["accomp_cost"];?></td>
                  </tr>
                  <tr>
                    <th>Short course</th>
                    <td><?php echo $user["short_course_cost"];?></td>
                    <td>---</td>
                  </tr>
                  <tr>
                    <th>Grant</th>
                    <td><?php echo $user["personal_grant"];?></td>
                    <td><?php echo $user["accomp_grant"];?></td>
                  </tr>
                  <tr>
                    <th>Fee</th>
                    <td><?php echo $user["personal_fee"];?></td>
                    <td><?php echo $user["accomp_fee"];?></td>
                  </tr>
                  <tr>
                    <th>Paid</th>
                    <td><?php echo $user["personal_paid"];?></td>
                    <td><?php echo $user["accomp_paid"];?></td>
                  </tr>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Total fee</th>
                    <td><?php echo $user["total_fee"];?></td>
                    <td></td>
                  </tr>
                  <tr>
                    <th>Total paid</th>
                    <td><?php echo $user["fee_paid"];?></td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          
          <h2>Transactions</h2>
          
          <table>
            <thead>
              <tr>
                <th></th>
                <th>ID</th>
                <th>Type</th>
                <th>Method</th>
                <th>Amount</th>
                <th>Session ID</th>
                <th>Time</th>
                <th>Comments</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($payments as $payment):?>
              <?php
              if(is_null($payment["success"])) {
                $success = "null";
              } elseif($payment["success"]) {
                $success = "success";
              } else {
                $success = "failure";
              }
              ?>
              <tr class="<?php echo $success;?>">
                <td>
                  <?php
                  if($success == "null") {
                    echo "<span class=\"fa fa-question\"></span>";
                  } elseif($success == "success") {
                    echo "<span class=\"fa fa-check\"></span>";
                  } elseif($success == "failure")  {
                    echo "<span class=\"fa fa-times\"></span>";
                  }
                  ?>
                </td>
                <td><?php echo $payment["id"];?></td>
                <td><?php echo $payment["type"];?></td>
                <td><?php echo $payment["method"];?></td>
                <td><?php echo $payment["amount"];?></td>
                <td><?php echo implode("<br>", str_split($payment["session_id"], 10));?></td>
                <td><?php $time = strtotime($payment["change_time"]); echo date("d.m.y", $time);?></td>
                <td><?php echo $payment["comments"];?></td>
              </tr>
              <?php endforeach;?>
            </tbody>
          </table>
          
          <h2>Abstracts</h2>
          <table>
            <thead>
              <tr>
                <th></th>
                <th>ID</th>
                <th>Title</th>
                <th>Session</th>
                <th>Form</th>
                <th>Comments</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($abstracts as $abstract) {
                echo "<tr>";
                echo "<td>";
                if(empty($abstract["accepted"])) {
                  echo "<span class=\"fa fa-question\"></span>";
                } elseif ($abstract["accepted"]) {
                  echo "<span class=\"fa fa-check\"></span>";
                } else {
                  echo "<span class=\"fa fa-times\"></span>";
                }
                echo "</td>";
                echo "<td>".$abstract["id"]."</td>";
                echo "<td><a href=\"boa.php?id=".$abstract["id"]."\" target=\"_blank\" class=\"abstract_link\">".nl2br(html_entity_decode($abstract["title"]),false)."</a></td>";
                echo "<td>";
                if(empty($abstract["session_assigned"])) {
                  echo "<span class=\"topics_proposed\">".str_replace(";","<br>",$abstract["topics"])."</span>";
                } else {
                  echo "<span class=\"topics_assigned\">".$abstract["session_assigned"]."</span>";
                }
                echo "</td>";
                
                if(empty($abstract["type_assigned"])) {
                  if($abstract["type_proposed"] == "oral") {
                    echo "<td title=\"Oral\"><span class=\"fa fa-microphone type_proposed\"></span></td>";
                  } elseif($abstract["type_proposed"] == "poster") {
                    echo "<td title=\"Poster\"><span class=\"fa fa-picture-o type_proposed\"></span></td>";
                  } elseif($abstract["type_proposed"] == "other") {
                    echo "<td title=\"Oral or Poster\"><span class=\"fa fa-microphone type_proposed\"></span>/<span class=\"fa fa-picture-o type_proposed\"></span></td>";
                  }
                } else {
                  if($abstract["type_assigned"] == "oral") {
                    echo "<td title=\"Oral\"><span class=\"fa fa-microphone type_assigned\"></span></td>";
                  } elseif($abstract["type_assigned"] == "poster") {
                    echo "<td title=\"Poster\"><span class=\"fa fa-picture-o type_assigned\"></span></td>";
                  } elseif($abstract["type_assigned"] == "other") {
                    echo "<td title=\"Oral or Poster\"><span class=\"fa fa-microphone type_assigned\"></span>/<span class=\"fa fa-picture-o type_assigned\"></span></td>";
                  }
                }
                
                echo "<td>".$abstract["comments"]."</td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
          
          <h2>Accompanying person(s)</h2>
          <table>
            <thead>
              <tr>
                <th>Name</th>
                <th>Additional information</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($accomps as $accomp) {
                echo "<tr>";
                echo "<td>".$accomp["title"]." ".$accomp["full_name"]."</td>";
                echo "<td>".$accomp["additional_info"]."</td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
          
          <?php else:?>
          
          <p>No such user. Please try again.</p>
          
          <?php endif;?>
        </div>
    </div>

  </body>

  </html>