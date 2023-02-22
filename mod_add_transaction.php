<?php
require "./extras/always_require.php";

require('./database/db_connect.php');

$sql = "SELECT id, person_id FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = array();
$person_ids = array();
foreach($stmt->fetch(PDO::FETCH_ASSOC) as $result) {
  $users[] = array("user_id" => $result["id"], "person_id" => $result["person_id"]);
  $person_ids[] = $result["person_id"];
}

$sql = "SELECT id, full_name FROM people WHERE id IN (".implode(",", $person_ids).")";
$stmt = $conn->prepare($sql);
$stmt->execute();
$id_to_name = array();
foreach($stmt->fetch(PDO::FETCH_ASSOC) as $result) {
  $id_to_name[$result["id"]] = $result["full_name"];
}

$tmp_users = array();
foreach($users as $user) {
  $tmp_users[] = array("user_id" => $user["user_id"], "person_id" => $user["person_id"], "full_name" => $id_to_name[$user["person_id"]]);
}
$users = $tmp_users;
unset($tmp_users);

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $sql = "INSERT INTO payments (success, type, amount, user_id, create_time) VALUES (:success, :type, :amount, :user_id, NULL)";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("success" => $_POST["success"], "type" => $_POST["type"], "amount" => $_POST["amount"], "user_id" => $_POST["user_id"]));
}

$conn = null;
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
      <h1>Moderator view - add transaction</h1>
      
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <input type="submit" name="submit" id="submit" value="Submit">
        <br>
        <br>
        <table>
          <thead>
            <tr>
              <th>Null?</th>
              <th>Name</th>
              <th>Content</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="checkbox" name="type_null" id="type_null" disabled></td>
              <td>Type</td>
              <td>
                <select name="type" id="type" required>
                  <option value="transfer">Bank transfer</option>
                  <option value="card">Credit card</option>
                  <option value="other">Other</option>
                </select>
              </td>
            </tr>
            <tr>
              <td><input type="checkbox" name="amount_null" id="amount_null" disabled></td>
              <td>Amount (in PLN)</td>
              <td><input type="number" name="amount" id="amount" step="0.01" required></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="user_id_null" id="user_id_null" disabled></td>
              <td>User ID</td>
              <td><input type="number" name="user_id" id="user_id" step="1" required></td>
            </tr>
            <tr>
              <td><input type="checkbox" name="success_null" id="success_null"></td>
              <td>Success</td>
              <td><input type="checkbox" name="success" id="success" checked></td>
            </tr>
          </tbody>
        </table>
        <input type="submit" name="submit" id="submit" value="Submit">
      </form>
    </div>
  </div>

</body>

</html>