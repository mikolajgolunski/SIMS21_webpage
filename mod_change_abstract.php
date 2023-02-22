<?php

require "./extras/always_require.php";

if(!empty($_POST["submit"])) {
  $id = $_POST["abstract_id"];
  $title = test_input($_POST["abstract_title"]);
  $text = test_input($_POST["abstract_text"]);
  
  require('./database/db_connect.php');

  $sql = "UPDATE abstracts SET text=:text, title=:title WHERE id=:id";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("id" => $id, "text" => $text, "title" => $title));

  $conn = null;
  
  $_POST["abstract_id"] = 0;
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
  <label for="abstract_id">Abstract ID</label>
  <input type="number" name="abstract_id" id="abstract_id">
  <label for="abstract_title">Abstract title</label>
  <input type="text" name="abstract_title" id="abstract_title">
  <label for="abstract_text">Abstract text</label>
  <textarea name="abstract_text" id="abstract_text"></textarea>
  <input type="submit" name="submit" id="submit" value="Submit">
</form>
