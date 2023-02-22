<?php
require "./extras/always_require.php";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        #main {
          width: auto;
        }
        
        #content {
          width: auto;
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
          <h1>Moderator view - edit database record</h1>
          <p class="important">Watch out for your input. Fields in this form are not checked for correctness! You can really mess up the database.</p>
          <h2>Editing record with id = <span class="important"><?php echo $_POST["id"];?></span> from table <span class="important"><?php echo $_POST["table"];?></span></h2>
          <h3>Are you sure you want to change the record to the one listed below?</h3>


          <form action="<?php echo htmlspecialchars("mod_checkdb.php?change=true#openModal");?>" method="post">
            <input type="hidden" id="form_type" name="form_type" value="edit">
            <?php
          echo "<input type=\"hidden\" id=\"table\" name=\"table\" value=\"".$_POST["table"]."\">\n";
          foreach($_POST as $key => $value){
            if($key == "table"){
              continue;
            }
            echo "<p><strong>".$key."</strong><br>".$value."</p>\n";
            echo "<input type=\"hidden\" id=\"".$key."\" name=\"".$key."\" value=\"".$value."\">\n";
          }
            ?>
              <button type="submit" formaction="<?php echo htmlspecialchars("mod_editdb.php?id=".$_POST["id"]."&table=".$_POST["table"]);?>" class="button" style="float: left;">Back</button>
              <button type="reset" class="button" style="float: left;" disabled>Reset</button>
              <input type="submit" value="Edit" class="button" style="float: left;">
          </form>

        </div>
    </div>

  </body>

  </html>