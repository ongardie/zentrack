<?php
/* 
V1.81 22 March 2002 (c) 2000-2002 John Lim (jlim@natsoft.com.my). All rights reserved.
  Released under both BSD license and Lesser GPL library license. 
  Whenever there is any discrepancy between the two licenses, 
  the BSD license will take precedence. 
  Set tabs to 4 for best viewing.
    
  Latest version is available at http://php.weblogs.com/
*/
include('../adodb.inc.php');
include('../tohtml.inc.php');

$db = NewADOConnection('pear');
$db->databaseDriver = 'mysql';
$db->debug = true;
$db->Connect('localhost','root','','xphplens');
$rs = $db->Execute('select * from products');
rs2html($rs);

print "<h3>Test Errors</h3>";
$rs = $db->Execute('select * from productz');
if ($rs) print "Recordset returned - wrong!<br>";

$db->Connect('localhost','root','','nodb_xphplens');
?>