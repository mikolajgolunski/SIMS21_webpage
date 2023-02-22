<?php
require "./extras/always_require.php";

//no need to check if logged in
//TODO Add logged in check

//no need to check if comes from proper page
//TODO Add transaction site origin

function send_mails($data) {
  require("./extras/PHPMailer/PHPMailerAutoload.php");
  require('./extras/mail_connect.php');
  $mail->addAddress("user@user.user", "SIMS21");
  if($data["payment"]["type"] == "accomp") {
    if($data["payment"]["success"]) {
      $mail->Subject = "New card payment successfull - accompanying persons: ".$data["personal"]["full_name"];
      
      $body = "Full name: ".$data["personal"]["full_name"]."\nAmount: ".$data["payment"]["cost"]." PLN\nOrder ID: ".$data["payment"]["order_id"]."\nType: Accompanying persons\nStatus: accepted.\n\nACCOMPANYING PERSONS DETAILS\n\n";
      foreach($data["accomps"] as $accomp) {
        $body = $body."Name: ".$accomp["name"]."\nAdditional information: ".$accomp["additional_information"]."\n\n";
      }
      $body = $body."INVOICE INFORMATION\n\nName: ".$data["billing"]["name"]."\nCountry: ".$data["billing"]["country"]."\n";
      if($data["billing"]["country"] == $USA_name) {
        $body = $body."State: ".$data["billing"]["state"]."\n";
      }
      $body = $body."City: ".$data["billing"]["city"]."\nStreet: ".$data["billing"]["street"]."\nZipcode: ".$data["billing"]["zipcode"]."\n\nVAT INVOICE\n\n";
      if($data["vat"]["vat_invoice"]) {
        $body = $body."VAT nr: ".$data["vat"]["nr"];
      } else {
        $body = $body."No VAT invoice required";
      }
    
      $mail->Body = $body;
    } else {
      $mail->Subject = "New card payment rejected - accompanying persons: ".$data["personal"]["full_name"];
      $mail->Body = "Full name: ".$data["personal"]["full_name"]."\nAmount: ".$data["payment"]["cost"]." PLN\nOrder ID: ".$data["payment"]["order_id"]."\nType: Accompanying persons\nStatus: rejected.";
    }
  } else {
    if($data["payment"]["success"]) {
      $mail->Subject = "New card payment successfull: ".$data["personal"]["full_name"];
      $mail->Body = "Full name: ".$data["personal"]["full_name"]."\nAmount: ".$data["payment"]["cost"]." PLN\nOrder ID: ".$data["payment"]["order_id"]."\nType: Conference registration\nStatus: accepted.";
    } else {
      $mail->Subject = "New card payment rejected: ".$data["personal"]["full_name"];
      $mail->Body = "Full name: ".$data["personal"]["full_name"]."\nAmount: ".$data["payment"]["cost"]." PLN\nOrder ID: ".$data["payment"]["order_id"]."\nType: Conference registration\nStatus: rejected.";
    }
  }
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
  }
  
  $mail->clearAddresses();
  
  $mail->addAddress("user@user.user", "SIMS21 Secretary");
  if($data["payment"]["type"] == "accomp") {
    if($data["payment"]["success"]) {
      $mail->Subject = "New card payment successfull - accompanying persons: ".$data["personal"]["full_name"];
      
      $body = "Full name: ".$data["personal"]["full_name"]."\nAmount: ".$data["payment"]["cost"]." PLN\nOrder ID: ".$data["payment"]["order_id"]."\nType: Accompanying persons\nStatus: accepted.\n\nACCOMPANYING PERSONS DETAILS\n\n";
      foreach($data["accomps"] as $accomp) {
        $body = $body."Name: ".$accomp["name"]."\nAdditional information: ".$accomp["additional_information"]."\n\n";
      }
      $body = $body."INVOICE INFORMATION\n\nName: ".$data["billing"]["name"]."\nCountry: ".$data["billing"]["country"]."\n";
      if($data["billing"]["country"] == $USA_name) {
        $body = $body."State: ".$data["billing"]["state"]."\n";
      }
      $body = $body."City: ".$data["billing"]["city"]."\nStreet: ".$data["billing"]["street"]."\nZipcode: ".$data["billing"]["zipcode"]."\n\nVAT INVOICE\n\n";
      if($data["vat"]["vat_invoice"]) {
        $body = $body."VAT nr: ".$data["vat"]["nr"];
      } else {
        $body = $body."No VAT invoice required";
      }
    
      $mail->Body = $body;
    } else {
      $mail->Subject = "New card payment rejected - accompanying persons: ".$data["personal"]["full_name"];
      $mail->Body = "Full name: ".$data["personal"]["full_name"]."\nAmount: ".$data["payment"]["cost"]." PLN\nOrder ID: ".$data["payment"]["order_id"]."\nType: Accompanying persons\nStatus: rejected.";
    }
  } else {
    if($data["payment"]["success"]) {
      $mail->Subject = "New card payment successfull: ".$data["personal"]["full_name"];
      $mail->Body = "Full name: ".$data["personal"]["full_name"]."\nAmount: ".$data["payment"]["cost"]." PLN\nOrder ID: ".$data["payment"]["order_id"]."\nType: Conference registration\nStatus: accepted.";
    } else {
      $mail->Subject = "New card payment rejected: ".$data["personal"]["full_name"];
      $mail->Body = "Full name: ".$data["personal"]["full_name"]."\nAmount: ".$data["payment"]["cost"]." PLN\nOrder ID: ".$data["payment"]["order_id"]."\nType: Conference registration\nStatus: rejected.";
    }
  }
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
  }
  
  $mail->clearAddresses();
  
  $mail->addAddress($data["personal"]["email"]);
  if($data["payment"]["type"] == "accomp") {
    if($data["payment"]["success"]) {
      $mail->Subject = "SIMS21 accompanying person(s) payment successfull";
      $mail->Body = "Your accompanying person(s) payment has been successfully completed.\n\nBest regards,\nSIMS21 Organizing Committee";
    } else {
      $mail->Subject = "SIMS21 accompanying person(s) payment unsuccessfull";
      $mail->Body = "Your accompanying person(s) payment has not been completed.\n\nBest regards,\nSIMS21 Organizing Committee";
    }
  } else {
    if($data["payment"]["success"]) {
      $mail->Subject = "SIMS21 conference registration payment successfull";
      $mail->Body = "Your conference registration payment has been successfully completed. The invoice will be sent to you in a separate email within next 2 weeks.\n\nBest regards,\nSIMS21 Organizing Committee";
    } else {
      $mail->Subject = "SIMS21 conference registration payment unsuccessfull";
      $mail->Body = "Your conference registration payment has not been completed.\n\nBest regards,\nSIMS21 Organizing Committee";
    }
  }
  if(!$mail->send()) {
    echo "Mailer error: " . $mail->ErrorInfo;
  }

  $mail = null;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $order_id = array_pop(explode(" ", $_POST["order_id"]));

  if($_POST["service_response"] == 30 or $_POST["service_response"] == 35 or $_POST["response_code"] == 30 or $_POST["response_code"] == 35) {
    $success = true;
  } else {
    $success = false;
  }
  
  $log = fopen("abstracts/payment_check.log", "a");
  $txt = date("c").", ".$order_id.", ".var_export($success, true)."\n";
  fwrite($log, $txt);
  fclose($log);

  require('./database/db_connect.php');
  
  if(!$success) {
    $sql = "SELECT user_id, cc_number_hash, type, method, amount FROM payments WHERE id=? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array($order_id));
    $payment = $stmt->fetch(PDO::FETCH_ASSOC);
    $user_id = $payment["user_id"];
    
    $sql = "INSERT INTO payments (amount, user_id, cc_number_hash, type, method, create_time) VALUES (:amount, :user_id, :hash, :type, :method, NULL)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array("amount" => $payment["amount"], "user_id" => $user_id, "hash" => $payment["cc_number_hash"], "type" => $payment["type"], "method" => $payment["method"]));
  }

  $sql = "UPDATE payments SET success=:success, transaction_id=:transaction_id, response_code=:response_code, method='card', session_id=:session_id, bin=:bin, cc_number_hash=:cc_number_hash, card_type=:card_type WHERE id=:id";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("success" => $success, "transaction_id" => $_POST["transaction_id"], "response_code" => $_POST["response_code"], "session_id" => $_POST["session_id"], "bin" => $_POST["bin"], "cc_number_hash" => $_POST["cc_number_hash"], "card_type" => $_POST["card_type"], "id" => $order_id));
  
  $sql = "SELECT user_id, type, amount FROM payments WHERE id=? LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($order_id));
  $payment = $stmt->fetch(PDO::FETCH_ASSOC);
  $user_id = $payment["user_id"];
  $payment_type = $payment["type"];

  $sql = "SELECT person_id, personal_paid, accomp_paid FROM users WHERE id=? LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($user_id));
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
  $person_id = $user["person_id"];
  if(empty($user["personal_paid"])) {
    $personal_paid = 0.0;
  } else {
    $personal_paid = $user["personal_paid"];
  }
  if(empty($user["accomp_paid"])) {
    $accomp_paid = 0.0;
  } else {
    $accomp_paid = $user["accomp_paid"];
  }

  $sql = "SELECT full_name, email, vat_affiliation, vat_invoice, vat_nr FROM people WHERE id=? LIMIT 1";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array($person_id));
  $person = $stmt->fetch(PDO::FETCH_ASSOC);
  $full_name = $person["full_name"];
  
  if($payment_type == "personal") {
    
  } else if($payment_type == "accomp") {
    
  }
  
  
  
  if($success) {
    if($payment_type == "personal") {
      $personal_paid = $personal_paid + $payment["amount"];
      
      $sql = "UPDATE people SET paid=1 WHERE id=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($person_id));
    } elseif($payment_type == "accomp") {
      $accomp_paid = $accomp_paid + $payment["amount"];
      
      $sql = "SELECT id, person_id FROM accomp_to_users WHERE user_id=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($user_id));
      $accomp_ids = array();
      while($accomp_nr = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $accomp_ids[] = $accomp_nr["person_id"];
      }
      $sql = "SELECT id, full_name, additional_info, paid, cost FROM people WHERE id=?";
      $stmt = $conn->prepare($sql);
      $accomps = array();
      $accomp_payment = $payment["amount"];
      foreach($accomp_ids as $accomp_id) {
        $stmt->execute(array($accomp_id));
        $accomp = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$paid && $accomp_payment >= 0){
          $accomp_payment = $accomp_payment - $accomp["cost"];
          $accomps[] = array("id" => $accomp["id"],"name" => $accomp["full_name"], "additional_information" => $accomp["additional_info"]);
        }
      }
      
      $sql = "UPDATE people SET paid=1 WHERE id=?";
      $stmt = $conn->prepare($sql);
      foreach($accomps as $accomp) {
        $stmt->execute(array($accomp["id"]));
      }

      $sql = "SELECT affiliation1, affiliation2, country, state, city, street, zipcode FROM affiliations WHERE id=?";
      $stmt = $conn->prepare($sql);
      $stmt->execute(array($person["vat_affiliation"]));
      $billing = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    $sql = "UPDATE users SET personal_paid=:personal_paid, accomp_paid=:accomp_paid WHERE id=:id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array("personal_paid" => $personal_paid, "accomp_paid" => $accomp_paid, "id" => $user_id));
  }
  
  $txt = $full_name." (user_id: ".$user_id.", person_id: ".$person_id.") tried paying ".$payment["amount"]." PLN using credit card (order_id: ".$order_id."). Success: ".var_export($success, true);
  log_save($conn, "payment_auto_check", $txt);

  $conn = null;

  http_response_code(200);
  
  $data = array();
  
  $data["personal"]["full_name"] = $person["full_name"];
  $data["personal"]["email"] = $person["email"];

  $data["payment"]["cost"] = $payment["amount"];
  $data["payment"]["order_id"] = $order_id;
  $data["payment"]["success"] = $success;
  $data["payment"]["type"] = $payment["type"];

  foreach($accomps as $accomp) {
    $data["accomps"][] = array("name" => $accomp["name"], "additional_information" => $accomp["additional_information"]);
  }

  $data["billing"]["name"] = $billing["affiliation1"];
  if(!empty($billing["affiliation2"])) {
    $data["billing"]["name"] = $data["billing"]["name"]." - ".$billing["affiliation2"];
  }
  $data["billing"]["country"] = $billing["country"];
  $data["billing"]["state"] = $billing["state"];
  $data["billing"]["city"] = $billing["city"];
  $data["billing"]["street"] = $billing["street"];
  $data["billing"]["zipcode"] = $billing["zipcode"];

  $data["vat"]["nr"] = $person["vat_nr"];
  $data["vat"]["vat_invoice"] = $person["vat_invoice"];
  
  send_mails($data);
  
} else {
  $log = fopen("abstracts/payment_check.log", "a");
  $txt = date("c").", Unauthorised access\n";
  fwrite($log, $txt);
  fclose($log);
  
  echo "Error";
}
?>
