<?
 /**
  * Print out all the predefined php globals and their contents
  *
  * @subpackage Devtools
  */
  $vals = array( '_SERVER', '_ENV', '_COOKIE', '_SESSION', 'GLOBALS' );

  foreach($vals as $v) {
    print "<p><b>$v</b>:<br>\n";
    print "<PRE>\n";
    print_r($$v);
    print "</PRE>\n";
    print "</p>\n";
  }

?>
