<pre>
<?
  /** 
   * @package Devtools 
   * 
   * This utility is used to print php predefined arrays. 
   *
   * It can be included in another script or called directly
   */


  $vals = array( '_SERVER', '_ENV', '_COOKIE', '_SESSION', 'GLOBALS' );

  foreach($vals as $v) {
    print "<p><b>$v</b>:<br>\n";
    print_r($$v);
    print "</p>\n";
  }

?>
</pre>
