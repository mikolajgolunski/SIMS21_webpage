<?php
require "./extras/always_require.php";

//no need to check if logged in

//no need to check if comes from proper page

$_SESSION["last_site"] = "photos";
?>
  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <title>SIMS21, Poland 2017 - Photos</title>
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
              <h1>Conference photos</h1>
              <center><a href="../img/SIMSXXI_Instalation.jpg"><img border="2" src="../img/SIMSXXI_Instalation_small.jpg"></a></br>SIMSXXI</br>
              </center>
              <p>Select the the link below to enter particular gallery. The selected gallery will open in a new window.</p>

              <hr>

              <ul>
                <li>
                  <a href="./Sept_10/index.html" target="_blank">10 September 2017 - Short Course & Reception</a><br><br>
                  <a href="./Sept_11/index.html" target="_blank">11 September 2017 - Opening & Plenary Session 1</a><br><br>
                  <a href="./Sept_12/index.html" target="_blank">12 September 2017 - Garrison & Winograd Honorary Session</a><br><br>
                  <a href="./Sept_12/Andreas_Song.mp4" target="_blank">12 September 2017 - Andreas Wucher song at the Garrison & Winograd Honorary Session</a><br><br>
                  <a href="./Sept_12_Poster/index.html" target="_blank">12 September 2017 - Poster Session I</a><br><br>
                  <a href="./Sept_13/index.html" target="_blank">13 September 2017 - Plenary Session 2 & Discussion</a><br><br>
                  <a href="./Sept_13_Krakow_Brunelle/index.html" target="_blank">13 September 2017 - The Old Krakow excursion - photos by A. Brunelle</a><br><br>
                  <a href="./Sept_13_Banquet/index.html" target="_blank">13 September 2017 - Conference Banquet</a><br><br>
                  <a href="./The_Multivariates/index.html" target="_blank">13 September 2017 - The Multivariates</a><br><br>
                  <a href="./Sept_14/index.html" target="_blank">14 September 2017 - Sponsors & Poster Session 2</a><br><br>
		  <a href="./Sept_Group/index.html" target="_blank">Group pictures</a><br><br>
                  <font color="red">We would appreciate receiving photographs from the conference sessions & excursions.</font></br>
                    Please send photos via email to <a href="mailto: sims21.krakow@gmail.com">sims21.krakow@gmail.com</a> or upload them one by one using the form below (max
                    <?php echo $max_file_size/1000000;?> MB per file, only .jpg, .jpeg and .png extensions allowed).</br></br>

                    <?php
      
      if(isset($_FILES["file"])){
        $upload_ok = true;

        if($_FILES["file"]["error"] === UPLOAD_ERR_OK) {
          
          if($_FILES["file"]["size"] > $max_file_size) {
            $err = "Your file is too large.";
            $upload_ok = false;
          }

          $finfo = finfo_open(FILEINFO_MIME_TYPE);
          $mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

          switch($mime) {
            case "image/jpeg":
            case "image/png":
              break;
            default:
              $err = "The type of your file is wrong.";
              $upload_ok = false;
          }
          
          if (!$img = @imagecreatefromjpeg($_FILES["file"]["tmp_name"])) {
            if(!$img = @imagecreatefrompng($_FILES["file"]["tmp_name"])) {
              $err = "The type of your file is wrong.";
              $upload_ok = false;
            }
          }

          if($upload_ok) {
            $target_dir = "../abstracts/";
            do {
              $target_name = "photo_".pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)."_".random_str(10).".".pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
              $target_file = $target_dir.$target_name;
            } while(file_exists($target_file));
            
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
              $_SESSION["photo"] = $target_name;
              $_SESSION["photo_name"] = basename($_FILES["file"]["name"]);
            } elseif(!isset($_POST["back"])) {
              $err = "Sorry, there was an error uploading your file.";
            } elseif($_FILES["file"]["error"] === UPLOAD_ERR_FORM_SIZE) {
              $err = "Your file is too large.";
            } else {
              $err = "There was an unexpected error nr ".$_FILES["file"]["error"]." (".$phpFileUploadErrors[$_FILES["file"]["error"]]."). Please try again or contact us to report the problem.";
            }
          }
        }
      }
      
      ?>

                      <form id="photo" name="photo" action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]);?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size;?>">
                        <input type="file" id="file" name="file" accept="image/png, image/jpeg" required>
                        <input type="submit" value="Upload" name="upload">
                      </form>
      <br>
      <?php
      if(!empty($err)) {
        echo $err;
        $err = "";
      } else {
        if(isset($_SESSION["photo_name"])){
          echo "File ".$_SESSION["photo_name"]." has been uploaded.";
          unset($_SESSION["photo_name"]);
          unset($_SESSION["photo"]);
        }
      }
      ?>
                  </p>

                </li>
              </ul>
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
