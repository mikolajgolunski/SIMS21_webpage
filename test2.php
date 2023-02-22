<?php

require "./extras/always_require.php";
/*
if(!empty($_POST["Submit"])) {
  $id = $_POST["abstract_id"];
  $text = test_input($_POST["abstract_text"]);
  echo $text;
  require('./database/db_connect.php');

  $sql = "UPDATE abstracts SET text=:text WHERE id=:id";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("id" => $id, "text" => $text));

  $conn = null;
  
  $_POST["abstract_id"] = 0;
}
*/
?>