<?php
session_start();
require("../extras/useful_functions.php");
require("./db_connect.php");

function find_duplicates($conn, $table, $columns){
  $implode = implode(", ", $columns);
  $sql = "SELECT GROUP_CONCAT(id) AS ids FROM `".$table."` GROUP BY ".$implode." HAVING (COUNT(*) > 1)";
  $duplicates = $conn->query($sql);
  $duplicates = $duplicates->fetchAll(PDO::FETCH_ASSOC);
  if(isset($duplicates)){
    return $duplicates;
  } else {
    return 0;
  }
}

echo "Initialized<br>";
echo "affiliations start<br>";

$columns = array("affiliation1", "affiliation2", "country", "state", "city", "street", "zipcode");
$duplicates = find_duplicates($conn, "affiliations", $columns);
if($duplicates != 0){
  foreach($duplicates as $duplicate){
    $ids = explode(",", $duplicate["ids"]);
    $main_id = $ids[0];
    $other_ids = implode(", ", array_slice($ids, 1));
    $sql = "UPDATE `people` SET affiliation_id=".$main_id." WHERE affiliation_id IN (".$other_ids.")";
    $conn->query($sql);
    $sql = "DELETE FROM `affiliations` WHERE id IN (".$other_ids.")";
    $conn->query($sql);
  }
}

echo "affiliations end<br>";
echo "people start<br>";

$columns = array("last_name", "first_name", "middle_name", "title", "email", "affiliation_id", "type");
$duplicates = find_duplicates($conn, "people", $columns);
if($duplicates != 0){
  foreach($duplicates as $duplicate){
    $ids = explode(",", $duplicate["ids"]);
    $main_id = $ids[0];
    $other_ids = implode(", ", array_slice($ids, 1));
    $sql = "UPDATE `users` SET person_id=".$main_id." WHERE person_id IN (".$other_ids.")";
    $conn->query($sql);
    $sql = "UPDATE `abstracts_to_people` SET person_id=".$main_id." WHERE person_id IN (".$other_ids.")";
    $conn->query($sql);
    $sql = "UPDATE `accomp_to_users` SET person_id=".$main_id." WHERE person_id IN (".$other_ids.")";
    $conn->query($sql);
    $sql = "DELETE FROM `people` WHERE id IN (".$other_ids.")";
    $conn->query($sql);
  }
}

echo "people end<br>";

$conn = null;

echo "finished";
?>