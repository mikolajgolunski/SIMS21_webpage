<?php
require "./extras/always_require.php";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <link type="text/css" rel="stylesheet" href="./css/db_check.css">

      <title>SIMS21, Poland 2017</title>
  </head>

  <body>
    <div id="main">
      <?php
      require("./includes/menu.php");
      ?>

        <div id="content">
          <div id="openModal" class="modalDialog">
            <div>
              <a href="#close" title="Close" class="close">X</a>
              <?php
              if(isset($_GET["change"]) and $_GET["change"] == "true"){
                if ($_POST["form_type"] == "edit"){
                  require("./database/db_connect.php");

                  $sql = "UPDATE `".$_POST["table"]."` SET";
                  foreach($_POST as $key => $value){
                    if($key == "table" or $key == "id" or $key == "form_type"){
                      continue;
                    }
                    $sql = $sql." ".$key."='".test_input($value)."', ";
                  }
                  $sql = mb_substr($sql, 0, -2);
                  $sql = $sql." WHERE id='".$_POST["id"]."'";
                  $conn->query($sql);

                  $conn = null;

                  echo "<p>Database record has been changed.</p>";
                }
                elseif($_POST["form_type"] == "add"){
                  require("./database/db_connect.php");

                  $sql = "INSERT INTO `".$_POST["table"]."` (";
                  foreach($_POST as $key => $value){
                    if($key == "table" or $key == "id" or $key == "form_type" or $key == "create_time"){
                      continue;
                    }
                    $sql = $sql."`".$key."`, ";
                  }
                  if(isset($_POST["create_time"])){
                    $sql = $sql."`create_time`";
                  }
                  else{
                    $sql = mb_substr($sql, 0, -2);
                  }
                  $sql = $sql.") VALUES (";
                  foreach($_POST as $key => $value){
                    if($key == "table" or $key == "id" or $key == "form_type" or $key == "create_time"){
                      continue;
                    }
                    if(ctype_digit($value)){
                      $sql = $sql.$value.", ";
                    }
                    elseif(strpos($value, '.') !== false && ctype_digit(str_replace('.', '', $value))){
                      $sql = $sql.$value.", ";
                    }
                    else{
                      $sql = $sql."'".$value."', ";
                    }
                  }
                  if(isset($_POST["create_time"])){
                    $sql = $sql."NULL";
                  }
                  else{
                    $sql = mb_substr($sql, 0, -2);
                  }
                  $sql = $sql.")";
                  $conn->query($sql);

                  $conn = null;

                  echo "<p>Database record added.</p>";
                }
                elseif($_POST["form_type"] == "delete"){
                  require("./database/db_connect.php");
                  
                  $sql = "DELETE FROM `".$_POST["table"]."` WHERE id='".$_POST["id"]."'";
                  $conn->query($sql);
                  
                  $conn = null;
                  
                  echo "<p>Database record deleted.</p>";
                }
              }
              ?>
            </div>
          </div>

          <h1>Moderator view - check database</h1>
          <h3>None of the moderator actions trigger sending emails.</h3>

          <?php
          require("./database/db_connect.php");

          $alltables = $conn->query("SHOW TABLES", PDO::FETCH_NUM);
          while($table = $alltables->fetch()){
            $sql = "SELECT COUNT(*) FROM " . $table[0];
            $users_count = $conn->query($sql);
            $count = $users_count->fetchColumn();
            
            echo "<table>\n";
            echo "<caption>Table: ".$table[0]." (entries total - ".$count.") <a href=\"mod_adddb.php?table=".$table[0]."\" class=\"button\">Add new entry</a></caption>\n";

            $sql = "SELECT * FROM " . $table[0];
            $rows = $conn->query($sql);
            $col_number = $rows->columnCount();
            echo "<tr>\n";
            for($i = 0; $i < $col_number; $i++){
              $col = $rows->getColumnMeta($i);
              $names[] = $col["name"];
              echo "<th>" . $col["name"] . "</th>\n";
            }
            $col = null;
            echo "<th>Action</th>\n";
            echo "</tr>\n";

            $sql = "SELECT COUNT(*) FROM " . $table[0];
            try{
              if($count > 0){
                foreach($rows as $row){
                  echo "<tr>\n";
                  foreach($names as $name){
                    echo "<td>" . $row[$name] . "</td>\n";
                  }
                  echo "<td><a href=\"mod_editdb.php?table=".$table[0]."&id=".$row["id"]."\" class=\"button\">Edit</a><br>
                    <a href=\"mod_deletedb.php?table=".$table[0]."&id=".$row["id"]."\" class=\"button\">Delete</a></td>\n";
                  echo "</tr>\n";
                }
              } else{
                echo "<tr>\n";
                echo "<td class=\"no_rows\" colspan=\"" . ($col_number + 1) . "\">No records in the table.</td>\n";
                echo "</tr>\n";
              }
            } catch(PDOException $exception){
              echo $query . "<br />" . $exception->getMessage();
            }
            $rows = null;
            $col_number = null;
            $users_count = null;
            $names = null;
            echo "</table>\n";
            }
          $alltables = null;
          $conn = null;
          ?>

        </div>
    </div>

  </body>

  </html>