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
          <h1>Moderator view - database cleanup</h1>
          <?php
require("./database/db_connect.php");

function find_duplicates($conn, $table, $columns){
  $implode = implode(", ", $columns);
  $sql = "SELECT GROUP_CONCAT(id) AS ids FROM `".$table."` GROUP BY ".$implode." HAVING (COUNT(*) > 1)";
  $duplicates = $conn->query($sql);
  $duplicates = $duplicates->fetchAll(PDO::FETCH_ASSOC);
  if(!empty($duplicates)){
    return $duplicates;
  } else {
    return 0;
  }
}

echo "Begin cleanup<br>";

echo "<br>Delete duplicates in affiliations<br>";

$columns = array("affiliation1", "affiliation2", "country", "state", "city", "street", "zipcode");
$duplicates = find_duplicates($conn, "affiliations", $columns);
if($duplicates != 0){
  echo "Deleted ids:<br>";
  foreach($duplicates as $duplicate){
    $ids = explode(",", $duplicate["ids"]);
    $main_id = $ids[0];
    $other_ids = implode(", ", array_slice($ids, 1));
    $sql = "UPDATE `affiliations_to_people` SET affiliation_id=".$main_id." WHERE affiliation_id IN (".$other_ids.")";
    $conn->query($sql);
    $sql = "UPDATE `people` SET vat_affiliation=".$main_id." WHERE vat_affiliation IN (".$other_ids.")";
    $conn->query($sql);
    $sql = "UPDATE `people` SET affiliation_id=".$main_id." WHERE affiliation_id IN (".$other_ids.")";
    $conn->query($sql);
    $sql = "DELETE FROM `affiliations` WHERE id IN (".$other_ids.")";
    $conn->query($sql);
    echo $other_ids."<br>";
  }
} else {
  echo "No duplicates<br>";
}

echo "<br>Delete duplicates in people<br>";

$columns = array("last_name", "first_name", "middle_name", "title", "email", "type");
$duplicates = find_duplicates($conn, "people", $columns);
if($duplicates != 0){
  echo "Deleted ids:<br>";
  foreach($duplicates as $duplicate){
    $ids = explode(",", $duplicate["ids"]);
    /*$main_id = $ids[0];
    $other_ids = implode(", ", array_slice($ids, 1));*/
    
    $sql = "SELECT GROUP_CONCAT(affiliation_id) AS ids FROM affiliations_to_people WHERE person_id=?";
    $stmt = $conn->prepare($sql);
    $affiliations = array();
    foreach($ids as $id) {
      $stmt->execute(array($id));
      $aff = $stmt->fetch(PDO::FETCH_ASSOC);
      $affiliations[] = array("person_id" => $id, "affiliations_ids" => $aff["ids"]);
    }
    
    $same_people = array();
    $people_temp = array();
    foreach($affiliations as $affiliation) {
      $people_temp[] = $affiliation["person_id"];
      $same_people[$affiliation["person_id"]] = array();
      foreach($affiliations as $affiliation2) {
        if(!in_array($affiliation2["person_id"], $people_temp)) {
          if($affiliation2["affiliations_ids"] == $affiliation["affiliations_ids"]) {
            $same_people[$affiliation["person_id"]][$affiliation["person_id"]] = $affiliation2["person_id"];
          }
        }
      }
    }
    
    foreach($same_people as $same_person) {
      if(count($same_person) > 0) {
        $main_id = key($same_person);
        $other_ids = implode(",", $same_person);
        
        $sql = "UPDATE `affiliations_to_people` SET person_id=".$main_id." WHERE person_id IN (".$other_ids.")";
        $conn->query($sql);
        $sql = "UPDATE `users` SET person_id=".$main_id." WHERE person_id IN (".$other_ids.")";
        $conn->query($sql);
        $sql = "UPDATE `abstracts_to_people` SET person_id=".$main_id." WHERE person_id IN (".$other_ids.")";
        $conn->query($sql);
        $sql = "UPDATE `accomp_to_users` SET person_id=".$main_id." WHERE person_id IN (".$other_ids.")";
        $conn->query($sql);
        $sql = "UPDATE `person_to_authors` SET person_id=".$main_id." WHERE person_id IN (".$other_ids.")";
        $conn->query($sql);
        $sql = "UPDATE `person_to_authors` SET author_id=".$main_id." WHERE author_id IN (".$other_ids.")";
        $conn->query($sql);
        $sql = "UPDATE `affiliations_to_people` SET person_id=".$main_id." WHERE person_id IN (".$other_ids.")";
        $conn->query($sql);
        $sql = "DELETE FROM `people` WHERE id IN (".$other_ids.")";
        $conn->query($sql);
        echo $other_ids."<br>";
      }
    }
  }
} else {
  echo "No duplicates<br>";
}

echo "<br>Delete duplicates in affiliations_to_people<br>";

$columns = array("affiliation_id", "person_id", "order_nr");
$duplicates = find_duplicates($conn, "affiliations_to_people", $columns);
if($duplicates != 0){
  echo "Deleted ids:<br>";
  foreach($duplicates as $duplicate){
    $ids = explode(",", $duplicate["ids"]);
    $main_id = $ids[0];
    $other_ids = implode(", ", array_slice($ids, 1));
    $sql = "DELETE FROM `affiliations_to_people` WHERE id IN (".$other_ids.")";
    $conn->query($sql);
    echo $other_ids."<br>";
  }
} else {
  echo "No duplicates<br>";
}

echo "<br>Get files in abstracts folder<br>";
$path = "./abstracts";
$files = scandir($path);
$files = array_diff($files, array(".", ".."));
echo "Found ".count($files)." files<br>";

echo "<br>Delete all person_to_authors records that are not connected to abstracts<br>";
$sql = "
DELETE
FROM
  `person_to_authors`
WHERE
  author_id NOT IN 
    (
    SELECT 
      person_id
    FROM 
      `abstracts_to_people`
    )
";
$conn->query($sql);
$sql = "SELECT ROW_COUNT()";
$count = $conn->query($sql);
$count = $count->fetch(PDO::FETCH_ASSOC);
echo "Deleted ".$count["ROW_COUNT()"]." records<br>";
          
echo "<br>Delete all people->type:author that are not connected to abstracts<br>";
$sql = "SELECT GROUP_CONCAT(id) AS ids FROM people WHERE type='author' AND id NOT IN (SELECT person_id FROM abstracts_to_people)";
$stmt = $conn->prepare($sql);
$stmt->execute();
$author_delete = $stmt->fetch(PDO::FETCH_ASSOC);
$author_delete = $author_delete["ids"];

if(!is_null($author_delete)) {
  $sql = "DELETE FROM affiliations_to_people WHERE person_id IN (".$author_delete.")";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $sql = "DELETE FROM people WHERE id IN (".$author_delete.")";
  $stmt = $conn->prepare($sql);
  $stmt->execute();

  $sql = "SELECT ROW_COUNT()";
  $count = $conn->query($sql);
  $count = $count->fetch(PDO::FETCH_ASSOC);
  echo "Deleted ".$count["ROW_COUNT()"]." records<br>";
} else {
  echo "No records to delete.<br>";
}

echo "<br>Delete all people that are not connected to anything<br>";
$sql = "SET SESSION group_concat_max_len = 1000000";
$conn->query($sql);

$sql = "SELECT GROUP_CONCAT(person_id) AS ids FROM (SELECT person_id FROM abstracts_to_people UNION SELECT person_id FROM accomp_to_users UNION SELECT person_id FROM users UNION SELECT author_id FROM person_to_authors UNION SELECT person_id FROM affiliations_to_people) AS u";
$ids = $conn->query($sql);
$ids = $ids->fetch(PDO::FETCH_ASSOC);
$ids = $ids["ids"];

$sql = "DELETE FROM people WHERE id NOT IN (".$ids.")";
$conn->query($sql);
$sql = "SELECT ROW_COUNT()";
$count = $conn->query($sql);
$count = $count->fetch(PDO::FETCH_ASSOC);
echo "Deleted ".$count["ROW_COUNT()"]." records<br>";

/*
echo "<br>Delete all affiliations that are connected to unexistent people<br>";
$sql = "
DELETE a FROM `affiliations` a
  LEFT JOIN `people` b ON b.affiliation_id = a.id OR b.vat_affiliation = a.id
    WHERE b.affiliation_id IS NULL AND b.vat_affiliation IS NULL
";
$conn->query($sql);
$sql = "SELECT ROW_COUNT()";
$count = $conn->query($sql);
$count = $count->fetch(PDO::FETCH_ASSOC);
echo "Deleted ".$count["ROW_COUNT()"]." records<br>";
*/

echo "<br>Delete all abstracts_to_people that are connected to unexistent people<br>";
$sql = "
DELETE a FROM `abstracts_to_people` a
  LEFT JOIN `people` b ON b.id = a.person_id
    WHERE b.id IS NULL
";
$conn->query($sql);
$sql = "SELECT ROW_COUNT()";
$count = $conn->query($sql);
$count = $count->fetch(PDO::FETCH_ASSOC);
echo "Deleted ".$count["ROW_COUNT()"]." records<br>";

echo "<br>Delete all abstracts that are connected to unexistent abstracts_to_people<br>";
$sql = "
DELETE a FROM `abstracts` a
  LEFT JOIN `abstracts_to_people` b ON b.abstract_id = a.id
    WHERE b.abstract_id IS NULL
";
$conn->query($sql);
$sql = "SELECT ROW_COUNT()";
$count = $conn->query($sql);
$count = $count->fetch(PDO::FETCH_ASSOC);
echo "Deleted ".$count["ROW_COUNT()"]." records<br>";

echo "<br>Get all file names in database<br>";
$sql = "SELECT file FROM `abstracts`";
$question = $conn->query($sql);
$files_db = array();
foreach($question as $file_db) {
  $files_db[] = $file_db["file"];
}
echo "Found ".count($files_db)." records<br>";

echo "<br>Delete files nonexistent in database<br>";
$old_dir = getcwd();
chdir($path);
echo "Deleted files:<br>";
foreach($files as $file) {
  if(!in_array($file, $files_db) and $file != "payment_check.log") {
    unlink($file);
    echo $file."<br>";
  }
}
chdir($old_dir);
          
/*echo "<br>Delete unprocessed transactions<br>";
$sql = "DELETE FROM payments WHERE success IS NULL";
$conn->query($sql);
$sql = "SELECT ROW_COUNT()";
$count = $conn->query($sql);
$count = $count->fetch(PDO::FETCH_ASSOC);
echo "Deleted ".$count["ROW_COUNT()"]." records<br>";*/

echo "<br>Finished cleanup";

$conn = null;
    ?>
        </div>
    </div>

  </body>

  </html>