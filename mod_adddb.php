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
      <script type="text/javascript">
        function checkcountry(val) {
          if (val === "United States") {
            document.getElementById("state").disabled = false;
          } else {
            document.getElementById("state").disabled = true;
          }
        }
      </script>

      <title>SIMS21, Poland 2017</title>
  </head>

  <body>
    <div id="main">
      <?php
      require("./includes/menu.php");
      ?>

        <div id="content">
          <h1>Moderator view - add database record</h1>
          <p class="important">Watch out for your input. Fields in this form are not checked for correctness! You can really mess up the database.</p>
          <h2>Adding record for table <span class="important"><?php echo $_GET["table"];?></span></h2>
          <?php
          if($_GET["table"] == "users"){
            echo "<h3>Password must be created through \"Forgot password\" procedure.</h3>\n";
          }
          ?>

            <form action="<?php echo htmlspecialchars("mod_checkdb.php?change=true#openModal");?>" method="post">
              <input type="hidden" id="form_type" name="form_type" value="add">
              <input type="hidden" id="table" name="table" value="<?php echo $_GET["table"];?>">
              <?php
              require("./database/db_connect.php");
            
              $sql = "DESCRIBE ".$_GET["table"];
              $desc = $conn->query($sql);
              $desc_result = $desc->fetchAll(PDO::FETCH_ASSOC);
              $col_num = $desc->rowCount();
              foreach($desc_result as $column){
                $col_types[] = $column["Type"];
                $col_names[] = $column["Field"];
              }
            
              for($i = 0; $i < $col_num; $i++){
                echo "<label for=\"".$col_names[$i]."\">".$col_names[$i]."</label>\n";
              if(strpos($col_types[$i], "enum") !== false){
                echo "<select id=\"".$col_names[$i]."\" name=\"".$col_names[$i]."\">\n";
                foreach(getSQLEnumArray($_GET["table"], $col_names[$i], $conn) as $option){
                  echo "<option value=\"".$option."\"";
                  if($row[$i] == $option){
                    echo " selected";
                  }
                  echo ">".$option."</option>\n";
                }
                echo "</select>";
              }
              elseif($col_types[$i] == "tinyint(1)"){
                echo "<input type=\"checkbox\" id=\"".$col_names[$i]."\" name=\"".$col_names[$i]."\" value=\"1\"";
                if($row[$i]){
                  echo " checked";
                }
                echo ">\n";
              }
              elseif(strpos($col_types[$i], "int") !== false){
                echo "<input type=\"number\" step=\"1\" id=\"".$col_names[$i]."\" name=\"".$col_names[$i]."\" value=\"".$row[$i]."\"";
                if($col_names[$i] == "id"){
                  echo " disabled";
                }
                echo ">\n";
              }
              elseif($col_types[$i] == "timestamp"){
                echo "<input type=\"datetime-local\" id=\"".$col_names[$i]."\" name=\"".$col_names[$i]."\" value=\"".$row[$i]."\" disabled>\n";
                if($col_names[$i] == "create_time"){
                  echo "<input type=\"hidden\" id=\"create_time\" name=\"create_time\" value=\"true\">\n";
                }
              }
              elseif(strpos($col_types[$i], "char") === false){
                echo "<input type=\"number\" step=\"0.01\" id=\"".$col_names[$i]."\" name=\"".$col_names[$i]."\" value=\"".$row[$i]."\"";
                if($col_names[$i] == "id"){
                  echo " disabled";
                }
                echo ">\n";
              }
              elseif($col_names[$i] == "country"){
                echo "<select id=\"".$col_names[$i]."\" name=\"".$col_names[$i]."\" onchange=\"checkcountry(this.value)\">\n";
                echo "<option value=\"\"></option>\n";
                foreach($all_countries as $country){
                  echo "<option value=\"".$country."\"";
                  if($row[$i] == $country){
                    echo " selected";
                  }
                  echo ">".$country."</option>\n";
                }
                echo "</select>\n";
              }
              elseif($col_names[$i] == "state"){
                echo "<select id=\"".$col_names[$i]."\" name=\"".$col_names[$i]."\"";
                if($row["country"] != "United States"){
                  echo " disabled";
                }
                echo ">\n";
                echo "<option value=\"\"></option>\n";
                foreach($all_states as $state){
                  echo "<option value=\"".$state."\"";
                  if($row[$i] == $state){
                    echo " selected";
                  }
                  echo ">".$state."</option>\n";
                }
                echo "</select>\n";
              }
              elseif($col_names[$i] == "title"){
                echo "<select id=\"".$col_names[$i]."\" name=\"".$col_names[$i]."\">\n";
                echo "<option value=\"\"></option>\n";
                foreach($titles as $title){
                  echo "<option value=\"".$title."\"";
                  if($row[$i] == $title){
                    echo " selected";
                  }
                  echo ">".$title."</option>\n";
                }
                echo "</select>\n";
              }
              else{
                if(strlen($row[$i]) > 40){
                  echo "<textarea id=\"".$col_names[$i]."\" name=\"".$col_names[$i]."\" maxlength=\"255\" style=\"width: 200px;\"";
                  if($col_names[$i] == "password"){
                    echo " disabled";
                  }
                  echo ">".$row[$i]."</textarea>\n";
                }
                else{
                  echo "<input type=\"text\" id=\"".$col_names[$i]."\" name=\"".$col_names[$i]."\" value=\"".$row[$i]."\" style=\"width: 200px;\"";
                  if($col_names[$i] == "password"){
                    echo " disabled";
                  }
                  echo ">\n";
                }
              }
            }
            $conn = null;
            ?>
                <div>
                  <button type="submit" formaction="<?php echo htmlspecialchars("mod_checkdb.php");?>" class="button" style="float: left;">Back</button>
                  <button type="reset" class="button" style="float: left;">Reset</button>
                  <input type="submit" value="Add" class="button" style="float: left;">
                </div>
            </form>

        </div>
    </div>

  </body>

  </html>