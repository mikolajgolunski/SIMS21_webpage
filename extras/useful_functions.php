<?php
function delete_hidden_characters($txt) {
  return preg_replace('/[\x00-\x1F\x7F]/', '', nl2br($txt, false));
}

function pretty_dump($data) {
  return highlight_string("<?php\n\$data =\n".var_export($data, true).";\n?>");
}

function nl2p($string)
{
    $paragraphs = '';

    foreach (explode(PHP_EOL, $string) as $line) {
        if (trim($line)) {
            $paragraphs .= '<p>' . $line . '</p>';
        }
    }

    return $paragraphs;
}

function log_save($conn, $page, $content, $importance=3) {
  $sql = "INSERT INTO log SET page=:page, content=:content, importance=:importance, create_time=NULL";
  $stmt = $conn->prepare($sql);
  $stmt->execute(array("page" => $page, "content" => $content, "importance" => $importance));
}

function get_full_name($data) {
  if(empty($data["middle_name"])) {
    return $data["first_name"]." ".$data["last_name"];
  } else {
    return $data["first_name"]." ".$data["middle_name"]." ".$data["last_name"];
  }
}

function get_bank_transfer_html($name) {
  
  $txt = "
  <u>Bank account details:</u><br>
  NAME OF THE BANK: <b>X</b><br>
  ACCOUNT HOLDER: <b>X</b><br>
  ADDRESS:<br>
  X<br>
  <br>
  ACCOUNT NUMBER (IBAN): <b>X</b><br>
  SWIFT CODE: <b>X</b><br>
  REF: <b>SIMS21 - ".$name."</b><br>
  <br>
  <i>Please note that any extra charges associated with a fee payment must be covered by a sender.<br>
  <br>
  Several payments can be combined in a single wire-transfer. Make sure, however, that the name of the conference and the names of beneficiaries are clearly indicated on the transfer.<br>
  <br>
  The payment must be issued before 30 June 2017 to qualify for the \"early-bird\" registration rate.</i>
  ";
  return $txt;
}

/**
 * Generate a selector
 * 
 * @return string (12 characters)
 */
function generateSelector()
{
  require_once "./extras/random_compat-2.0.2/lib/random.php";
  return strtr(
    base64_encode(
      random_bytes(9)
    ),
    '+/',
    '-_'
  );
}

function calculateControlData($salt, $params) {
  $saltTab = str_split($salt);
  $hexLenght = strlen($salt);
  $saltBin = "";
  for ($x = 1; $x <= $hexLenght/2; $x++) {
    $saltBin .= (pack("H*", substr($salt,2 * $x - 2,2)));
  }
  return hash("sha256", $params.$saltBin);
}

function unique_multidim_array($array, $key) {
  $temp_array = array();
  $i = 0;
  $key_array = array();

  foreach($array as $val) {
    if (!in_array($val[$key], $key_array)) {
      $key_array[$i] = $val[$key];
      $temp_array[$i] = $val;
    }
    $i++;
  }
  return $temp_array;
}

function get_excursion_showname($data) {
  if($data == "krakow") {
    return "Krak&oacute;w Old City";
  } else if($data == "wieliczka") {
    return "Wieliczka Salt Mine";
  } else if($data == "ojcow") {
    return "Ojc&oacute;w National Park";
  } else {
    return $registration["excursion_first"];
  }
}

function getSQLEnumArray($table, $field, $db){
  $row = $db->query("SHOW COLUMNS FROM ".$table." LIKE '".$field."'")->fetch(PDO::FETCH_ASSOC);
  preg_match_all("/'(.*?)'/", $row["Type"], $categories);
  $fields = $categories[1];
  return $fields;
}

function test_input($data) {
  if(ctype_space($data)) {
    $data = " ";
  } else {
    $data = trim($data);
    $data = htmlspecialchars($data);
  }
  return $data;
}

if(!function_exists('hash_equals')){
  function hash_equals($str1, $str2)
  {
    if(strlen($str1) != strlen($str2))
    {
        return false;
    }
    else
    {
      $res = $str1 ^ $str2;
      $ret = 0;
      for($i = strlen($res) - 1; $i >= 0; $i--)
      {
        $ret |= ord($res[$i]);
      }
      return !$ret;
    }
  }
}

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'){
  require_once "./extras/random_compat-2.0.2/lib/random.php";
  $str = '';
  $max = mb_strlen($keyspace, '8bit') - 1;
  for ($i = 0; $i < $length; ++$i) {
    $str .= $keyspace[random_int(0, $max)];
  }
  return $str;
}

function create_hash($password){
  $cost = 10;
  $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), "+", ".");
  $salt = sprintf("$2a$%02d$", $cost) . $salt;
  $hash = crypt($password, $salt);
  return $hash;
}

function encrypt($decrypted, $password, $salt='.1hFY%4xOc^cgASRy^NW') {
// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
$key = hash('SHA256', $salt . $password, true);
// Build $iv and $iv_base64.  We use a block size of 128 bits (AES compliant) and CBC mode.  (Note: ECB mode is inadequate as IV is not used.)
srand(); $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC), MCRYPT_RAND);
if (strlen($iv_base64 = rtrim(base64_encode($iv), '=')) != 22) return false;
// Encrypt $decrypted and an MD5 of $decrypted using $key.  MD5 is fine to use here because it's just to verify successful decryption.
$encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $decrypted . md5($decrypted), MCRYPT_MODE_CBC, $iv));
// We're done!
return $iv_base64 . $encrypted;
}

function decrypt($encrypted, $password, $salt='.1hFY%4xOc^cgASRy^NW') {
// Build a 256-bit $key which is a SHA256 hash of $salt and $password.
$key = hash('SHA256', $salt . $password, true);
// Retrieve $iv which is the first 22 characters plus ==, base64_decoded.
$iv = base64_decode(substr($encrypted, 0, 22) . '==');
// Remove $iv from $encrypted.
$encrypted = substr($encrypted, 22);
// Decrypt the data.  rtrim won't corrupt the data because the last 32 characters are the md5 hash; thus any \0 character has to be padding.
$decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, base64_decode($encrypted), MCRYPT_MODE_CBC, $iv), "\0\4");
// Retrieve $hash which is the last 32 characters of $decrypted.
$hash = substr($decrypted, -32);
// Remove the last 32 characters from $decrypted.
$decrypted = substr($decrypted, 0, -32);
// Integrity check.  If this fails, either the data is corrupted, or the password/salt was incorrect.
if (md5($decrypted) != $hash) return false;
// Yay!
return $decrypted;
}

function moveElement(&$array, $a, $b) {
    $p1 = array_splice($array, $a, 1);
    $p2 = array_splice($array, 0, $b);
    $array = array_merge($p2,$p1,$array);
}

function special_characters_keyboard($field) {
  echo "<div class=\"specials\">";
  $specials = array("Alpha", "Beta", "Gamma", "Delta", "Epsilon", "Zeta", "Eta", "Theta", "Iota", "Kappa", "Lambda", "Mu", "Nu", "Xi", "Omicron", "Pi", "Rho", "Sigma", "Tau", "Upsilon", "Phi", "Chi", "Psi", "Omega");
  foreach($specials as $special){
    echo "<button type=\"button\" class=\"button special\" onclick=\"javascript:lbc('$field', '', '&".$special.";');\" onmouseover=\"javascript:showToolTip(event,'&".$special.";',2)\" onmouseout=\"hideToolTip()\">&".$special.";</button>\n";
  }
  echo "</div>";
  echo "<div class=\"specials\">";
  $specials = array("alpha", "beta", "gamma", "delta", "epsilon", "zeta", "eta", "theta", "iota", "kappa", "lambda", "mu", "nu", "xi", "omicron", "pi", "rho", "sigma", "tau", "upsilon", "phi", "chi", "psi", "omega");
  foreach($specials as $special){
    echo "<button type=\"button\" class=\"button special\" onclick=\"javascript:lbc('$field', '', '&".$special.";');\" onmouseover=\"javascript:showToolTip(event,'&".$special.";',2)\" onmouseout=\"hideToolTip()\">&".$special.";</button>\n";
  }
  echo "</div>";
  echo "<div class=\"specials\">";
  $specials = array("deg", "permil", "radic", "plusmn", "times", "divide", "infin", "larr", "lArr", "rarr", "rArr", "darr", "dArr", "uarr", "uArr", "harr", "hArr", "int", "part", "nabla", "prod", "sum", "forall", "exist");
  foreach($specials as $special){
    echo "<button type=\"button\" class=\"button special\" onclick=\"javascript:lbc('$field', '', '&".$special.";');\" onmouseover=\"javascript:showToolTip(event,'&".$special.";',2)\" onmouseout=\"hideToolTip()\">&".$special.";</button>\n";
  }
  echo "</div>";
  echo "<div class=\"specials\">";
  $specials = array("frac12", "frac14", "frac34", "le", "ge", "cong", "asymp", "ne", "equiv", "prop", "and", "or", "cap", "cup", "isin", "notin", "sub", "nsub", "sube", "empty", "sdot", "image", "real", "alefsym");
  foreach($specials as $special){
    echo "<button type=\"button\" class=\"button special\" onclick=\"javascript:lbc('$field', '', '&".$special.";');\" onmouseover=\"javascript:showToolTip(event,'&".$special.";',2)\" onmouseout=\"hideToolTip()\">&".$special.";</button>\n";
  }
  echo "</div>";
}
?>