<?php
/*exec("mysqldump sims --password=fgra0234\!6 --user=sims --result-file=/var/www/vhosts/sims/backup.dump", $output);

$backuptxt = implode("\n", $output);*/

echo "created";

/*require("../extras/PHPMailer/PHPMailerAutoload.php");
require('../extras/mail_connect.php');

echo "connected";

$mail->addAddress("mikolaj.golunski@gmail.com", "SIMS21");
$mail->Subject = "Database backup ".date("y_m_d_G:i");
$mail->Body = "Below is the SIMS21 database backup.\n\n==============================\n\n".$backuptxt;

if(!$mail->send()) {
  echo "Mailer error: " . $mail->ErrorInfo;
}
$mail = null;
echo "sent";*/

$filename = "backup-".date("Y-m-d").".sql";
$mime = "text/html";

header("Content-Type: ".$mime."; charset=utf-8");
header("Content-Disposition: attachment; filename=\"".$filename."\"");

$cmd = "mysqldump dbname --password=password --user=user --default-character-set=utf8";

passthru($cmd);

echo "saved";

exit(0);



/*$convert_queries = [];

require("../database/db_connect.php");

$alltables = $conn->query("SHOW TABLES", PDO::FETCH_NUM);
while($table = $alltables->fetch()){
  $convert_query = "UPDATE ".$table[0]." SET ";
  $sql = "SELECT * FROM " . $table[0];
  $rows = $conn->query($sql);
  $col_number = $rows->columnCount();
  for($i = 0; $i < $col_number; $i++){
    $col = $rows->getColumnMeta($i);
    $convert_query = $convert_query.$col["name"]."=CONVERT(CAST(CONVERT(".$col["name"]." USING lastin1) AS binary) USING utf8), ";
  }
  $convert_query = mb_substr($convert_query, 0, -2);
  $convert_query = $convert_query.";";
  $convert_queries[] = $convert_query;
}
$convert_query = null;

foreach($convert_queries as $convert_query){
  $conn->query($convert_query);
}*/

?>