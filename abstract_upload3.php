<?php
require "./extras/always_require.php";

//check if logged in, if not send to login page and terminate the script
if(empty($_SESSION["login"])) {
  $_SESSION["last_site"] = "abstract_upload3";
  header("Location:login.php");
  exit;
}

//check if comes from proper page, if not send to first page of the module and terminate the script
/*if(
  $_SESSION["last_site"] == "abstract_upload3" or
  (($_SESSION["last_site"] == "abstract_upload2" or
  $_SESSION["last_site"] == "abstract_upload4") and
  $_SESSION["next"])
) {
} else {
  require('./database/db_connect.php');
  log_save($conn, "abstract_upload3", "Redirect from abstract_upload3 to abstract_upload1 (user_id: ".$_SESSION["user_id"].", person_id: ".$_SESSION["person_id"].", session_id: ".session_id().", last site: ".$_SESSION["last_site"].", next: ".$_SESSION["next"]."). SESSION: ".var_dump($_SESSION).".");
  $conn = null;
  $_SESSION["last_site"] = "error";
  header("Location:abstract_upload1.php");
  exit;
}*/

unset($_SESSION["next"]);

$required_check = true;

$_SESSION["abstract"]["type"] = "poster";

if($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if(isset($_POST["change_file"])) {
    unlink("./abstracts/".$_SESSION["abstract"]["file"]);
    unset($_SESSION["abstract"]["file"]);
    unset($_SESSION["abstract"]["show_name"]);
  }
  
  if(!empty($_POST["topic"]) or !empty($_POST["type"])) {
    $_SESSION["abstract"]["topics"] = $_POST["topic"];
    $_SESSION["abstract"]["type"] = test_input($_POST["type"]);
  }
  
  if(!empty($_POST["award"])) {
    $_SESSION["abstract"]["award"] = true;
  }
  
  if(isset($_FILES["file"]) && !($_FILES['file']['size'] === 0 && $_FILES['file']['tmp_name'] === '')){
    $upload_ok = true;

    if($_FILES["file"]["error"] === UPLOAD_ERR_OK) {
      $target_dir = "./abstracts/";
      do {
        $target_name = pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)."_".random_str(10).".".pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
        $target_file = $target_dir.$target_name;
      } while(file_exists($target_file));

      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

      switch($mime) {
        case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
        case "application/msword":
          break;
        default:
          $err = "The type of your file is wrong.";
          $upload_ok = false;
      }

      if($_FILES["file"]["size"] > $max_file_size) {
        $err = "Your file is too large.";
        $upload_ok = false;
      }

      if($upload_ok) {
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
          $_SESSION["abstract"]["file"] = $target_name;
          $_SESSION["abstract"]["show_name"] = basename($_FILES["file"]["name"]);
        } elseif(!isset($_POST["back"])) {
          
          $err = "Sorry, there was an error uploading your file.";
          
          
          
          
          //--------------------
          function send_mails($data) {
            require("./extras/PHPMailer/PHPMailerAutoload.php");
            require('./extras/mail_connect.php');
            $mail->addAddress("user@user.user", "SIMS21");
            $mail->Subject = "[Not on server] New abstract uploaded by ".$data["full_name"];
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
            } elseif(count($name) == 3) {
              $last_name = $name[2];
              $first_name = $name[0]." ".$name[1];
            } else {
              echo "Something went wrong. Please contact site administrator.";
              exit;
            }
            do {
              $target_name = $last_name."_".$first_name."_".random_str(10).".".pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
              $target_file = "./abstracts/".$target_name;
            } while(file_exists($target_file));
            $mail->AddAttachment($_FILES["file"]["tmp_name"], $target_name);
            if(!$mail->send()) {
              echo "Mailer error: " . $mail->ErrorInfo;
              exit;
            }

            $mail->clearAddresses();
            
            $mail->addAddress($data["email"]);
            $mail->Subject = "Abstract successfully submitted";
            $body = "Dear ".$data["full_name"].",\n\nYour abstract entitled \"".$data["title"]."\" has been successfully submitted.";
            if($data["award"]) {
              $body = $body."\n\nPlease remember to submit a letter of support from your immediate supervisor. Details can be found at the following address: http://sims.confer.uj.edu.pl/awards.php";
            }
            $body = $body."\n\nThank you and see you in Krakow,\nSIMS21 Program Committee";
            $mail->Body = $body;
            if(!$mail->send()) {
              echo "Mailer error: " . $mail->ErrorInfo;
              exit;
            }

            $mail = null;
          }

          require('./database/db_connect.php');

          $type = "";
          if($_SESSION["abstract"]["type"] == "Oral") {
            $type = "oral";
          } elseif($_SESSION["abstract"]["type"] == "Poster") {
            $type = "poster";
          } elseif($_SESSION["abstract"]["type"] == "Anything") {
            $type = "other";
          }

          $title = test_input($_SESSION["abstract"]["title"]);
          $text = test_input($_SESSION["abstract"]["text"]);
          $_SESSION["abstract"]["file"] = null;
          $_SESSION["abstract"]["show_name"] = basename($_FILES["file"]["name"]);

          $sql = "
            INSERT INTO `abstracts`
            SET
              title=:title, 
              text=:text, 
              topics=:topics, 
              type_proposed=:type, 
              file=:file, 
              name=:name, 
              award=:=award, 
              create_time=NULL";
          $stmt = $conn->prepare($sql);
          $stmt->execute(array("title" => $title, "text" => $text, "topics" => implode(";", $_SESSION["abstract"]["topics"]), "type" => $type, "file" => $_SESSION["abstract"]["file"], "name" => $_SESSION["abstract"]["show_name"], "award" => !empty($_SESSION["abstract"]["award"])));
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
          
          $txt = $_SESSION["full_name"]." (user_id: ".$_SESSION["user_id"].", person_id: ".$_SESSION["person_id"].") registered his/her abstract (abstract_id: ".$abstract_id.") titled: \"".htmlspecialchars_decode($_SESSION["abstract"]["title"])."\" but could not upload it to the webserver.";
          log_save($conn, "abstract_upload3", $txt);
          
          $conn = null;

          unset($_SESSION["abstract"]);
          unset($_SESSION["authors"]);

          $_SESSION["last_site"] = "abstract_upload4";
          header("Location: user_summary.php");
          exit;
          //-----------------
          
          
          
          
          
          
          
          
        }
      }
      
    } elseif($_FILES["file"]["error"] === UPLOAD_ERR_FORM_SIZE) {
      $err = "Your file is too large.";
    } else {
      $err = "There was an unexpected error nr ".$_FILES["file"]["error"]." (".$phpFileUploadErrors[$_FILES["file"]["error"]]."). Please try again or contact us to report the problem.";
      
      require('./database/db_connect.php');
      
      $txt = $_SESSION["full_name"]." (user_id: ".$_SESSION["user_id"].", person_id: ".$_SESSION["person_id"].") tried to registered his/her abstract but there was an unexpected error (error nr ".$_FILES["file"]["error"]." - ".$phpFileUploadErrors[$_FILES["file"]["error"]].").";
      log_save($conn, "abstract_upload3", $txt);
      
      $conn = null;
    }
  }
  
  if(isset($_POST["back"])) {
    $_SESSION["next"] = true;
    $_SESSION["last_site"] = "abstract_upload3";
    header("Location: abstract_upload2.php");
    exit;
  }
  
  $required_fields = array("topics" => "\"Topic(s)\"", "type" => "\"Presentation type\"", "file" => "\"File upload\"");
  foreach($required_fields as $field => $field_name) {
    if(empty($_SESSION["abstract"][$field])) {
      $required_check = false;
      $errors[] = "Fill in the ".$field_name." field.";
    }
  }
  
  if($required_check) {
    $_SESSION["next"] = true;
    $_SESSION["last_site"] = "abstract_upload3";
    header("Location: abstract_upload4.php");
    exit;
  }
  
}

$_SESSION["abstract"]["last_step"] = 3;
$_SESSION["last_site"] = "abstract_upload3";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        textarea {
          float: left;
        }
        
        button {
          display: block;
          float: left;
        }
        
        #buttons {
          float: left;
        }
        
        .button {
          width: auto;
          margin: 0 auto;
          text-align: center;
        }
        
        .supsub {
          width: 7em;
          float: none;
        }
        
        .special {
          width: 2em;
          height: 2em;
          float: left;
          padding: 0;
          text-align: center;
        }
        
        .specials {
          display: block;
          float: left;
          clear: both;
        }
        
        .main_part {
          clear: both;
        }
        
        hr {
          clear: both;
          margin-top: 1em;
          height: 2px;
          border-width: 0;
          background-color: gray;
          color: gray;
        }
        
        .topic_checkbox {
          width: 100%;
          float: left;
        }
        
        form label {
          display: inline;
        }
      </style>

      <script type="text/javascript">
        function no_required() {
          a = document.getElementById("type");
          b = document.getElementById("file");
          c = document.getElementById("abstract_finish");
          d = document.getElementById("back");

          a.required = false;
          b.required = false;
          d.disabled = false;
          c.submit();
        }
      </script>

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
              <h1>Abstract submission - Topic(s)/Form/File - step 3 of 4</h1>
              
              <?php
              if(!$required_check) {
                echo "<p class=\"important\">Please resolve the following issues:</p>\n";
                echo "<ul class=\"important\">\n";
                foreach($errors as $error){
                  echo "<li>".$error."</li>\n";
                }
                echo "</ul>\n";
              }
              ?>
              
              <form id="abstract_finish" name="abstract_finish" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
                <div class="main_part">
                  <h2>Select topic(s)<sup class="required_info">*</sup></h2>
                  <p>Please select topic(s) closest to a theme of your presentation (multiple selections are allowed):</p>
                  <?php
                  foreach($topics as $topic) {
                    echo "<div class=\"topic_checkbox\"><input type=\"checkbox\" name=\"topic[]\" id=\"".$topic."\" value=\"".$topic."\"";
                    if(!empty($_SESSION["abstract"]["topics"]) and in_array($topic, $_SESSION["abstract"]["topics"])) {
                      echo " checked";
                    }
                    echo "><label for=\"".$topic."\">".$topic."</label></div>\n";
                  }
                  ?>
                </div>

                <hr>

                <h2>Choose a form of presentation<sup class="required_info">*</sup></h2>
                <p>Please choose a preferred form of presentation (Oral/Poster/Anything):</p>
                <select id="type" name="type" required>
                  <option value="">Presentation form...</option>
                  <?php
                  $presentation_types = array("Poster");
                  /*$presentation_types = array("Oral", "Poster", "Anything");*/
                  foreach($presentation_types as $type) {
                    echo "<option value=\"".$type."\"";
                    if(!empty($_SESSION["abstract"]["type"]) and $_SESSION["abstract"]["type"] == $type) {
                      echo " selected";
                    }
                    echo ">".$type."</option>\n";
                  }
                  ?>
                </select>

                <hr>
                
                <h2>Decide if you wish to enter competition for the Student Presentation Awards</h2>
                <input type="checkbox" name="award" id="award" value="true"<?php echo !empty($_SESSION["abstract"]["award"]) ? " checked" : "";?>><label for="award"> Check if you wish to enter this presentation into competition for the Student Presentation Awards</label>
                <p>Entering only one presentation per student is allowed. Students who wish to enter the competition need to submit also a letter of support (1 page max) from her/his immediate supervisor before 15&nbsp;May&nbsp;2017. The letter should be emailed by the supervisor as an attachment to grants@sims21.org with the Subject Line: &quot;Application for the Best Presentation Award&quot;.</p>

                
                <hr>

                <h2>Upload file<sup class="required_info">*</sup></h2>
                <p>Upload abstract file (only MS Word files, size not larger than
                  <?php echo $max_file_size/1000000;?> MB):</p>
                <?php
                if(isset($_SESSION["abstract"]["file"])) {
                  echo "<p><span class=\"fa fa-file-word-o fa-fw\"></span> ".$_SESSION["abstract"]["show_name"]."</p>\n";
                  echo "<input type=\"submit\" value=\"Change file\" name=\"change_file\">";
                  echo "<input type=\"hidden\" id=\"file\" name=\"file\">"; //dummy input not to mess with javascript
                } else {
                  echo "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".$max_file_size."\">";
                  echo "<input type=\"file\" id=\"file\" name=\"file\" accept=\"application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document\" required>";
                }
                ?>

                  <hr>

                  <input type="hidden" name="back" id="back" value="back" disabled>
                  <input type="button" value="Back" name="back_button" onclick="javascript:no_required();">
                  <input type="submit" value="Next step" name="next">
              </form>
              
              <p class="required_info"><sup>*</sup>) Required field</p>
              <p  class="required_info">Please send an email to <a href="mailto:user@user.user?Subject=Problem with abstract uploading">user@user.user</a> if you experience any problem submitting the abstract.
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
