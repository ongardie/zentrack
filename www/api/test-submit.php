<?php
  $m = empty($_POST['format'])? $_GET['format'] : $_POST['format'];
  print "<pre>";
  ob_start();
  include($m == 'xml'? "http-xml.php" : "http-json.php");
  $val = htmlentities(ob_get_contents());
  ob_clean();
  print $val;
  print "</pre>";
?>
