<?php
  $filename = "backup-".date("Y-m-d").".sql";
  $mime = "text/plain";

  header("Content-Type: ".$mime."; charset=utf-8");
  header("Content-Disposition: attachment; filename=\"".$filename."\"");
  $cmd = "mysqldump name --password=password --user=user --default-character-set=utf8";
  passthru($cmd);

  require('./database/db_connect.php');
  $txt = "Database backup has been downloaded";
  log_save($conn, "download_backup", $txt);
  $conn = null;
?>