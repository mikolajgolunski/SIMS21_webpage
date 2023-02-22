<?php
require "./extras/always_require.php";

//check if logged in, if not send to login page and terminate the script
if(empty($_SESSION["login"])) {
  $_SESSION["last_site"] = "abstract_upload2";
  header("Location:login.php");
  exit;
}

//check if comes from proper page, if not send to first page of the module and terminate the script
/*if(
  $_SESSION["last_site"] == "abstract_upload2" or
  (
    (
      $_SESSION["last_site"] == "abstract_upload1" or
      $_SESSION["last_site"] == "abstract_upload3"
    ) and
    $_SESSION["next"]
  )
) {
} else {
  require('./database/db_connect.php');
  log_save($conn, "abstract_upload2", "Redirect from abstract_upload2 to abstract_upload1 (user_id: ".$_SESSION["user_id"].", person_id: ".$_SESSION["person_id"].", session_id: ".session_id().", last site: ".$_SESSION["last_site"].", next: ".$_SESSION["next"]."). SESSION: ".var_dump($_SESSION).".");
  $conn = null;
  $_SESSION["last_site"] = "error";
  $_SESSION["last_site"] = "error";
  header("Location:abstract_upload1.php");
  exit;
}*/

unset($_SESSION["next"]);

$required_check = true;

if($_SERVER["REQUEST_METHOD"] == "POST") {
  
  if(!empty($_POST["abstract_title_text"]) or !empty($_POST["abstract_text_text"])) {
    $_SESSION["abstract"]["title"] = test_input($_POST["abstract_title_text"]);
    $_SESSION["abstract"]["text"] = test_input($_POST["abstract_text_text"]);
  }
  
  if(isset($_POST["back"])) {
    $_SESSION["next"] = true;
    $_SESSION["last_site"] = "abstract_upload2";
    header("Location: abstract_upload1.php");
    exit;
  }
  
  $required_fields = array("title" => "\"Abstract's title\"", "text" => "\"Abstract's text\"");
  foreach($required_fields as $field => $field_name) {
    if(empty($_SESSION["abstract"][$field])) {
      $required_check = false;
      $errors[] = "Fill in the ".$field_name." field.";
    }
  }
  
  if($required_check) {
    $_SESSION["next"] = true;
    $_SESSION["last_site"] = "abstract_upload2";
    header("Location: abstract_upload3.php");
    exit;
  }
  
}

$_SESSION["abstract"]["last_step"] = 2;
$_SESSION["last_site"] = "abstract_upload2";
?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php
  require('./includes/head.html');
  ?>

      <style type="text/css">
        textarea {
          float: left;
        }
        
        button {
          display: block;
          float: left;
        }
        
        #buttons {
          float: left;
        }
        
        .button {
          width: auto;
          margin: 0 auto;
          text-align: center;
        }
        
        .supsub {
          width: 7em;
          float: none;
        }
        
        .special {
          width: 2em;
          height: 2em;
          float: left;
          padding: 0;
          text-align: center;
        }
        
        .specials {
          display: block;
          float: left;
          clear: both;
        }
        
        .main_part {
          clear: both;
        }
        
        hr {
          clear: both;
          margin-top: 1em;
          height: 2px;
          border-width: 0;
          background-color: gray;
          color: gray;
        }
      </style>

      <script type="text/javascript">
        // insert tag a before and i after, for the DOM object h, TextArea, Edit

        function lbc(h, a, i) { // helloacm.com
          var g = document.getElementById(h);
          g.focus();
          if (g.setSelectionRange) {
            var c = g.scrollTop;
            var e = g.selectionStart;
            var f = g.selectionEnd;
            g.value = g.value.substring(0, g.selectionStart) + a + g.value.substring(g.selectionStart, g.selectionEnd) + i + g.value.substring(g.selectionEnd, g.value.length);
            //g.selectionStart = e;
            if (a == "") {
              g.selectionStart = f + a.length + i.length;
              g.selectionEnd = f + a.length + i.length;
            } else {
              g.selectionStart = f + a.length;
              g.selectionEnd = f + a.length;
            }
            g.scrollTop = c;
          } else {
            if (document.selection && document.selection.createRange) {
              g.focus();
              var b = document.selection.createRange();
              if (b.text != "") {
                b.text = a + b.text + i;
              } else {
                b.text = a + "REPLACE" + i;
              }
              g.focus();
            }
          }
        } // helloacm.com

        function no_required() {
          a = document.getElementById("abstract_title");
          b = document.getElementById("abstract_text");
          c = document.getElementById("abstract_main");
          d = document.getElementById("back");

          a.required = false;
          b.required = false;
          d.disabled = false;
          c.submit();
        }
      </script>

      <title>SIMS21, Poland 2017 - Abstract submission</title>
  </head>

  <body>
    <div id="wrapper">
      <?php
    require('./includes/header.html');
    ?>

        <div id="main">
          <?php
        require("./includes/menu.php");
        ?>

            <div id="content">
              <table id="bubble_tooltip">
                <tr class="bubble_middle">
                  <td>
                    <div id="bubble_tooltip_content"></div>
                  </td>
                </tr>
              </table>

              <table id="bubble_tooltip2">
                <tr class="bubble_middle2">
                  <td>
                    <div id="bubble_tooltip_content2"></div>
                  </td>
                </tr>
              </table>


              <h1>Abstract submission - Title and text - step 2 of 4</h1>
              
              <?php
              if(!$required_check) {
                echo "<p class=\"important\">Please resolve the following issues:</p>\n";
                echo "<ul class=\"important\">\n";
                foreach($errors as $error){
                  echo "<li>".$error."</li>\n";
                }
                echo "</ul>\n";
              }
              ?>
              
              <p>Copy-and-paste approach can be used. Make sure that special characters, superscripts and subscripts are properly entered.</p>
              <form id="abstract_main" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div id="abstract_title">
                  <h2>Abstract title<sup class="required_info">*</sup></h2>
                  <p>Please enter title of your abstract (<span id="title_counter">255</span> characters left):</p>
                  <textarea id="abstract_title_text" rows="4" cols="50" maxlength="255" name="abstract_title_text" placeholder="Abstract's title..." required onInput="textCounter(this,'title_counter',255)"><?php if(!empty($_SESSION["abstract"]["title"])){echo $_SESSION["abstract"]["title"];}?></textarea>
                  <div id="buttons">
                    <button type="button" class="button supsub" onclick="javascript:lbc('abstract_title_text', '<sup>', '</sup>');" onmouseover="javascript:showToolTip(event,text1,1)" onmouseout="hideToolTip()">Superscript</button>
                    <button type="button" class="button supsub" onclick="javascript:lbc('abstract_title_text', '<sub>', '</sub>')" onmouseover="showToolTip(event,text2,1)" onmouseout="hideToolTip()">Subscript</button>
                  </div>
                  <?php special_characters_keyboard("abstract_title_text");?>
                </div>

                <hr>

                <div id="abstract_text">
                  <h2>Abstract text<sup class="required_info">*</sup></h2>
                  <p>Please enter ONLY text of your abstract. (<span id="text_counter">3700</span> characters left):<br><font color="red">Do not include pictures!</font> File with a full abstract will be uploaded in the next step.</p>
                  <textarea id="abstract_text_text" rows="10" cols="50" maxlength="3700" name="abstract_text_text" placeholder="Abstract's text..." onInput="textCounter(this,'text_counter',3700)" required><?php if(!empty($_SESSION["abstract"]["text"])){echo $_SESSION["abstract"]["text"];}?></textarea>
                  <div id="buttons">
                    <button type="button" class="button supsub" onclick="javascript:lbc('abstract_text_text', '<sup>', '</sup>');" onmouseover="javascript:showToolTip(event,text1,1)" onmouseout="hideToolTip()">Superscript</button>
                    <button type="button" class="button supsub" onclick="javascript:lbc('abstract_text_text', '<sub>', '</sub>');" onmouseover="showToolTip(event,text2,1)" onmouseout="hideToolTip()">Subscript</button>
                  </div>
                  <?php special_characters_keyboard("abstract_text_text");?>
                </div>

                <hr>
                <input type="hidden" name="back" id="back" value="back" disabled>
                <input type="button" value="Back" name="back_button" onclick="javascript:no_required();">
                <input type="submit" value="Next step" name="next">
              </form>
              
              <p class="required_info"><sup>*</sup>) Required field</p>
            </div>

            <?php
          require("./includes/side.html");
          ?>

        </div>
    </div>
    <?php
  require("./includes/footer.html");
  ?>

  </body>

  </html>
