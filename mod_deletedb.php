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
          <h1>Moderator view - delete database record</h1>
          <p class="important">Watch out for your input. Fields in this form are not checked for correctness! You can really mess up the database.</p>
          <h2>Deleting record with id = <span class="important"><?php echo $_GET["id"];?></span> from table <span class="important"><?php echo $_GET["table"];?></span></h2>
          <h3>Are you sure you want to DELETE the record listed below?</h3>

          <?php
          require("./database/db_connect.php");
          
          $sql = "SELECT * FROM ".$_GET["table"]." WHERE id=".$_GET["id"];
          $rows = $conn->query($sql);
          $col_num = $rows->columnCount();
          for($i = 0; $i < $col_num; $i++){
            $col = $rows->getColumnMeta($i);
            $col_names[] = $col["name"];
          }
          $sql = "DESCRIBE ".$_GET["table"];
          $desc = $conn->query($sql);
          $desc_result = $desc->fetchAll(PDO::FETCH_ASSOC);
          foreach($desc_result as $column){
            $col_types[] = $column["Type"];
          }
          $conn = null;
          ?>

            <form action="<?php echo htmlspecialchars("mod_checkdb.php?change=true#openModal");?>" method="post">
              <input type="hidden" id="form_type" name="form_type" value="delete">
              <input type="hidden" id="id" name="id" value="<?php echo $_GET["id"];?>">
              <input type="hidden" id="table" name="table" value="<?php echo $_GET["table"];?>">
              <?php
              foreach($rows as $row){
                for($i = 0; $i < $col_num; $i++){
                  echo "<p><strong>".$col_names[$i]."</strong><br>".$row[$i]."</p>\n";
                }
                break;
              }
              ?>
                <div>
                  <button type="submit" formaction="<?php echo htmlspecialchars("mod_checkdb.php");?>" class="button" style="float: left;">Back</button>
                  <button type="reset" class="button" style="float: left;" disabled>Reset</button>
                  <input type="submit" value="Delete" class="button" style="float: left;">
                </div>
            </form>
        </div>
    </div>

  </body>

  </html>