<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <link type="text/css" rel="stylesheet" href="db_check.css" />
  <title>Check SIMS21 database</title>
</head>

<body>
  <?php
  require("db_connect.php");
    
  $alltables = $conn->query("SHOW TABLES", PDO::FETCH_NUM);
  while($table = $alltables->fetch()){
    echo "<table>\n";
    echo "<caption>Table: " . $table[0] . "</caption>\n";
    
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
      if($users_count = $conn->query($sql)){
        if($users_count->fetchColumn() > 0){
          foreach($rows as $row){
            echo "<tr>\n";
            foreach($names as $name){
              echo "<td>" . $row[$name] . "</td>\n";
            }
            echo "<td><a href=\"db_edit.php?id=".$row["id"]."\" class=\"button\">Edit</a><br>
              <a href=\"db_delete.php?id=".$row["id"]."\" class=\"button\">Delete</a></td>\n";
            echo "</tr>\n";
          }
        }
        else{
          echo "<tr>\n";
          echo "<td class=\"no_rows\" colspan=\"" . $col_number . "\">Brak wpisów w bazie danych</td>\n";
          echo "</tr>\n";
        }
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
</body>

</html>
