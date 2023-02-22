<?php
require "./extras/always_require.php";

//check if logged in, if not send to login page and terminate the script
if(empty($_SESSION["login"])) {
  $_SESSION["last_site"] = "abstract_upload4";
  header("Location:login.php");
  exit;
}

//check if comes from proper page, if not send to first page of the module and terminate the script
/*if(
  $_SESSION["last_site"] == "abstract_upload4" or
  ($_SESSION["last_site"] == "abstract_upload3"
  and
  $_SESSION["next"])
) {
} else {
  require('./database/db_connect.php');
  log_save($conn, "abstract_upload4", "Redirect from abstract_upload4 to abstract_upload1 (user_id: ".$_SESSION["user_id"].", person_id: ".$_SESSION["person_id"].", session_id: ".session_id().", last site: ".$_SESSION["last_site"].", next: ".$_SESSION["next"]."). SESSION: ".var_dump($_SESSION).".");
  $conn = null;
  $_SESSION["last_site"] = "error";
  header("Location:abstract_upload1.php");
  exit;
}*/

unset($_SESSION["next"]);

function send_mails($data) {
  require("./extras/PHPMailer/PHPMailerAutoload.php");
  require('./extras/mail_connect.php');
  $mail->addAddress("user@user.user", "SIMS21");
  $mail->Subject = "New abstract uploaded by ".$data["full_name"];
  $body = "There is a new abstract uploaded by ".$data["full_name"].". Its details are listed below. The abstract is also in the attachment.\n\nAuthors:\n";
  foreach($data["authors"] as $author) {
    $body = $body.$author."\n";
  }
  $body = $body."-----\nTitle:\n".$data["title"]."\n-----\nChosen topics:\n";
  foreach($data["topics"] as $topic) {
    $body = $body.$topic."\n";
  }
  $body = $body."-----\nPresentation form:\n".$data["form"]."\n-----\nContent:\n".$data["text"];
  $mail->Body = $body;
  $name = explode(" ", $data["full_name"]);
  if(count($name) == 2) {
    $last_name = $name[1];
    $first_name = $name[0];
  } elseif(count($name) >= 3) {
    $last_name = array_pop($name);
    $first_name = implode(" ", $name);
  } elseif(count($name) == 1) {
    $last_name = " ";
    $first_name = $name[0];
  } else {
    echo "Something went wrong. Please contact site administrator.";
    exit;
  }
  do {
    $target_name = $last_name."_".$first_name."_".random_str(10).".".pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
    $target_file = "./abstracts/".$target_name;
  } while(file_exists($target_file));
  $mail->AddAttachment("./abstracts/".$data["file"], $target_name);
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
    exit;
  }

  $mail->clearAddresses();

  $mail->addAddress($data["email"]);
  $mail->Subject = "Abstract successfully submitted";
  $body = "Dear ".$data["full_name"].",\n\nYour abstract entitled \"".$data["title"]."\" has been successfully submitted.";
  if($data["award"]) {
    $body = $body."\n\nPlease remember to deliver a letter of support from your immediate supervisor before May 15, 2017. Details can be found at the following address: http://sims.confer.uj.edu.pl/awards.php";
  }
  $body = $body."\n\nThank you and see you in Krakow,\nSIMS21 Program Committee";
  $mail->Body = $body;
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
    exit;
  }

  $mail = null;
}

if(isset($_POST["back"])) {
  $_SESSION["next"] = true;
  $_SESSION["last_site"] = "abstract_upload4";
  header("Location: abstract_upload3.php");
  exit;
}

require('./database/db_connect.php');

if(isset($_POST["submit"])) {
  $type = "";
  if($_SESSION["abstract"]["type"] == "Oral") {
    $type = "oral";
  } elseif($_SESSION["abstract"]["type"] == "Poster") {
    $type = "poster";
  } elseif($_SESSION["abstract"]["type"] == "Anything") {
    $type = "other";
  }
  
  $title = $_SESSION["abstract"]["title"];
  $text = $_SESSION["abstract"]["text"];
  
  $sql = "
    INSERT INTO `abstracts`
    SET
      title=:title, 
      text=:text, 
      topics=:topics, 
      type_proposed=:type, 
      file=:file, 
      name=:name, 
      award=:award, 
      create_time=NULL";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("title" => $title, "text" => $text, "topics" => implode(";", $_SESSION["abstract"]["topics"]), "type" => $type, "file" => $_SESSION["abstract"]["file"], "name" =>$_SESSION["abstract"]["show_name"], "award" => !empty($_SESSION["abstract"]["award"])));
  $abstract_id = $conn->lastInsertId();
  
  foreach($_SESSION["authors"] as $person) {
    $sql = "INSERT INTO `abstracts_to_people` SET abstract_id=".$abstract_id.", person_id=".$person["id"].", presenting=";
    if(!empty($person["presenting"]) and $person["presenting"] == true) {
      $sql = $sql."TRUE";
    } else {
      $sql = $sql."FALSE";
    }
    $sql = $sql.", corresponding=NULL";
    $sql = $sql.", create_time=NULL";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array());
  }
  
  $authors_send = array();
  foreach($_SESSION["authors"] as $a) {
    $authors_send[] = $a["full_name"];
    if($a["id"] == $_SESSION["person_id"]) {
      $main_name = $a["full_name"];
      $main_mail = $a["email"];
    }
  }
  
  $data = array("full_name"=>$main_name, "authors"=>$authors_send, "title"=>htmlspecialchars_decode($_SESSION["abstract"]["title"]), "text"=>htmlspecialchars_decode($_SESSION["abstract"]["text"]), "topics"=>$_SESSION["abstract"]["topics"], "form"=>$_SESSION["abstract"]["type"], "file"=>$_SESSION["abstract"]["file"], "email"=>$main_mail, "award"=>$_SESSION["abstract"]["award"]);
  send_mails($data);
  
  $txt = $_SESSION["full_name"]." (user_id: ".$_SESSION["user_id"].", person_id: ".$_SESSION["person_id"].") registered his/her abstract (abstract_id: ".$abstract_id.") titled: \"".htmlspecialchars_decode($_SESSION["abstract"]["title"])."\" and saved it in file ".$_SESSION["abstract"]["file"].".";
  log_save($conn, "abstract_upload4", $txt);
  
  $conn = null;
  
  unset($_SESSION["abstract"]);
  unset($_SESSION["authors"]);
  
  $_SESSION["last_site"] = "abstract_upload4";
  header("Location: user_summary.php");
  exit;
}
  
$affiliations = array();
$last_affiliation_nr = 0;
foreach($_SESSION["authors"] as $key => $author) {
  $_SESSION["authors"][$key]["full_name"] = get_full_name($author);
  
  foreach($author["affiliations_ids"] as $affiliation_id) {
    if(!in_array($affiliation_id, array_keys($affiliations))){
      $affiliation_id_checked = test_input($affiliation_id);
      $sql = "SELECT affiliation1, affiliation2, country, state, city, street, zipcode FROM `affiliations` WHERE id = ".$affiliation_id_checked." LIMIT 1";
      $affiliation = $conn->query($sql);
      $affiliation = $affiliation->fetch(PDO::FETCH_ASSOC);
      $affiliations[$affiliation_id] = $affiliation;

      $last_affiliation_nr++;
      $affiliations[$affiliation_id]["nr"] = $last_affiliation_nr;
    }
  }
}

$conn = null;

$_SESSION["abstract"]["last_step"] = 4;
$_SESSION["last_site"] = "abstract_upload4";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        #presenting {
          text-decoration: underline;
        }
        
        #title {
          font-weight: bold;
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
              <h1>Abstract submission - Verification and submission - step 4 of 4</h1>
              <p>Please check if the information below is correct. If so, confirm the submission of the abstract by pressing <span class="menu-item">Submit</span> button.</p>
              <div id="main_info">
                <h2>Abstract:</h2>
                <p id="title">
                  <?php echo htmlspecialchars_decode($_SESSION["abstract"]["title"]);?>
                </p>
                <p id="authors">
                  <?php
                    $authors = array();
                    foreach($_SESSION["authors"] as $author) {
                      $author_out = "";
                      if($author["presenting"]){
                        $author_out = $author_out."<span id=\"presenting\">";
                      }
                      $author_out = $author_out.$author["full_name"];
                      if($author["presenting"]){
                        $author_out = $author_out."</span>";
                      }
                      $author_out = $author_out."<sup>";
                      $affiliations_nrs = array();
                      foreach($author["affiliations_ids"] as $affiliation_id) {
                        $affiliations_nrs[] = $affiliations[$affiliation_id]["nr"];
                      }
                      $affiliations_nrs = implode(", ", $affiliations_nrs);
                      $author_out = $author_out.$affiliations_nrs;
                      $author_out = $author_out."</sup>";
                      $authors[] = $author_out;
                    }
                  echo implode(", ", $authors);
                  ?>
                </p>
                <p id="affiliations">
                  <?php
                  $affiliations_out = array();
                  foreach($affiliations as $affiliation) {
                    $affiliation_out = "<sup>".$affiliation["nr"]."</sup> ".$affiliation["affiliation1"];
                    if (!empty($affiliation["affiliation2"]) and $affiliation["affiliation2"] != "") {
                      $affiliation_out = $affiliation_out." - ".$affiliation["affiliation2"];
                    }
                    $affiliation_out = $affiliation_out.", ".$affiliation["street"].", ";
                    if($affiliation["country"] == "United States") {
                      $affiliation_out = $affiliation_out.$affiliation["state"]." ";
                    }
                    $affiliation_out = $affiliation_out.$affiliation["zipcode"]." ".$affiliation["city"].", ".$affiliation["country"];
                    $affiliations_out[] = $affiliation_out;
                  }
                  echo implode("<br>\n", $affiliations_out);
                  ?>
                </p>
                <p>
                  <?php echo htmlspecialchars_decode(nl2br($_SESSION["abstract"]["text"], false))?>
                </p>
              </div>
              <div id="topics_info">
                <h2>Selected topics:</h2>
                <ul>
                  <?php
                  foreach($_SESSION["abstract"]["topics"] as $topic) {
                    echo "<li>".$topic."</li>\n";
                  }
                  ?>
                </ul>
              </div>
              <div id="file_info">
                <h2>Uploaded file:</h2>
                <p id="file"><span class="fa fa-file-word-o fa-fw"></span>
                  <?php echo $_SESSION["abstract"]["show_name"];?>
                </p>
              </div>
              <div id="presentation_info">
                <h2>Preffered form of presentation:</h2>
                <p id="presentation">
                  <?php echo $_SESSION["abstract"]["type"]?>
                </p>
              </div>
              <div id="award_info">
                <h2>Entering competition for the Student Presentation Awards:</h2>
                <p id="award">
                  <?php echo !empty($_SESSION["abstract"]["award"]) ? "Yes<br><span class=\"important\">Please remember to deliver a letter of support from your immediate supervisor before 15&nbsp;May&nbsp;2017.</span>" : "No"; ?>
                </p>
              </div>
              <hr>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="submit" value="Back" name="back">
                <input type="submit" value="Submit" name="submit">
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
