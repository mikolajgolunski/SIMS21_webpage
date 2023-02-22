<?php
require "./extras/always_require.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $_SESSION["newsletter"]["subject"] = $_POST["subject"];
  $_SESSION["newsletter"]["body"] = $_POST["body"];
}
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <link type="text/css" rel="stylesheet" href="./css/db_check.css">
    
      <script src="./extras/ckeditor/ckeditor.js"></script>

      <title>SIMS21, Poland 2017</title>
  </head>

  <body>
    <div id="main">
      <?php
      require("./includes/menu.php");
      ?>

        <div id="content">
          <h1>Moderator view - send newsletter</h1>
          
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <label for="subject">Subject</label>
            <input id="subject" name="subject" type="text" placeholder="Newsletter's subject"<?php echo isset($_SESSION["newsletter"]["subject"]) ? " value=\"".$_SESSION["newsletter"]["subject"]."\"" : ""; ?> required style="width: 50em;">
            <label for="body">Body</label>
            <textarea name="body" id="body" rows="10" cols="80">
                <?php echo isset($_SESSION["newsletter"]["body"]) ? $_SESSION["newsletter"]["body"] : "Insert the newsletter content in here."; ?>
            </textarea>
            <script>
              CKEDITOR.config.height = '40em';
              CKEDITOR.replace( 'body' );
            </script>
            
            <?php if($_SERVER['REQUEST_METHOD'] == 'POST'):?>
            
            <p>If you changed something click the &quot;Update&quot; button to confirm changes.</p>
            <input class="button" name="submit" value="Update" type="submit">
            <p>If you finished working on the text click the &quot;Send&quot; button.</p>
            <a href="mod_newsletter_confirm.php" class="button">Send</a>
            
            <?php else:?>
            
            <input class="button" name="submit" value="Submit" type="submit">
            
            <?php endif;?>
          </form>
        </div>
    </div>

  </body>

  </html>