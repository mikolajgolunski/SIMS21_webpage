<div class="specials">
  <?php
  $specials = array("Alpha", "Beta", "Gamma", "Delta", "Epsilon", "Zeta", "Eta", "Theta", "Iota", "Kappa", "Lambda", "Mu", "Nu", "Xi", "Omicron", "Pi", "Rho", "Sigma", "Tau", "Upsilon", "Phi", "Chi", "Psi", "Omega");
  foreach($specials as $special){
    echo "<button type=\"button\" class=\"button special\" onclick=\"javascript:lbc('abstract_title', '', '&".$special.";');\" onmouseover=\"javascript:showToolTip(event,'&".$special.";',2)\" onmouseout=\"hideToolTip()\">&".$special.";</button>\n";
  }
  ?>
</div>
<div class="specials">
  <?php
  $specials = array("alpha", "beta", "gamma", "delta", "epsilon", "zeta", "eta", "theta", "iota", "kappa", "lambda", "mu", "nu", "xi", "omicron", "pi", "rho", "sigma", "tau", "upsilon", "phi", "chi", "psi", "omega");
  foreach($specials as $special){
    echo "<button type=\"button\" class=\"button special\" onclick=\"javascript:lbc('abstract_title', '', '&".$special.";');\" onmouseover=\"javascript:showToolTip(event,'&".$special.";',2)\" onmouseout=\"hideToolTip()\">&".$special.";</button>\n";
  }
  ?>
</div>
<div class="specials">
  <?php
  $specials = array("deg", "permil", "radic", "plusmn", "times", "divide", "infin", "larr", "lArr", "rarr", "rArr", "darr", "dArr", "uarr", "uArr", "harr", "hArr", "int", "part", "nabla", "prod", "sum", "forall", "exist");
  foreach($specials as $special){
    echo "<button type=\"button\" class=\"button special\" onclick=\"javascript:lbc('abstract_title', '', '&".$special.";');\" onmouseover=\"javascript:showToolTip(event,'&".$special.";',2)\" onmouseout=\"hideToolTip()\">&".$special.";</button>\n";
  }
  ?>
</div>
<div class="specials">
  <?php
  $specials = array("frac12", "frac14", "frac34", "le", "ge", "cong", "asymp", "ne", "equiv", "prop", "and", "or", "cap", "cup", "isin", "notin", "sub", "nsub", "sube", "empty", "sdot", "image", "real", "alefsym");
  foreach($specials as $special){
    echo "<button type=\"button\" class=\"button special\" onclick=\"javascript:lbc('abstract_title', '', '&".$special.";');\" onmouseover=\"javascript:showToolTip(event,'&".$special.";',2)\" onmouseout=\"hideToolTip()\">&".$special.";</button>\n";
  }
  ?>
</div>
