
   

   <!--- BEGIN FOOTER --->
  
  
  
  </td>
  </tr>
  <tr>
    <td class="titleCell" height="25"><img src="<?=$imageUrl?>/empty.gif" width="2" height="25"></td>
</tr>
</table>

<br clear="all">
  
<p>&nbsp;</p>
<p align="left">
   <A href="http://sourceforge.net" target="_new">
      <IMG src="http://sourceforge.net/sflogo.php?group_id=22428" 
         width="88" height="31" border="0" alt="SourceForge Logo">
   </A>
</p>

<?

  include_once("$libDir/session_save.php");

  /*
  **  This is the debugging section... please keep this intact, as
  **  we use it extensively for support questions
  */
  if( $Debug_Overview ) {
     print "<span class='note'>\n";
     print "<p>&nbsp;------DEBUG OVERVIEW-------&nbsp;</p>\n";
     print "<i>To disable this output, set $Debug_Overview in header.php to 0.</i><br>\n";
     print "<a href='$rootUrl/phpinfo.php'>click here to view phpinfo</a><br>\n";
     print "HTTP_USER_AGENT: $HTTP_USER_AGENT<br>\n";
     print "SCRIPT_NAME: $SCRIPT_NAME<br>\n";
     print "HTTP_HOST: $HTTP_HOST<br>\n";
     print "HTTP_COOKIE: $HTTP_COOKIE<br>\n";
     print "SERVER_SOFTWARE: {$_SERVER['SERVER_SOFTWARE']}<br>\n";
     print "SERVER_NAME: $SERVER_NAME<br>\n";
     print "PHP Version: ".phpversion()."<br>\n";
     print "zenTrack Version: ".$zen->settings["version_xx"]."<br>\n";
     print "rootUrl: $rootUrl<br>\n";
     print "database: ".$zen->database_type."/".$zen->database_host."<br>\n";
     print "settings count: ".count($zen->settings)."<br>\n";
     print "bins: ".join(",",$zen->bins)."<br>\n";
     print "types: ".join(",",$zen->types)."<br>\n";
     print "priorities: ".join(",",$zen->priorities)."<br>\n";
     print "systems: ".join(",",$zen->systems)."<br>\n";
     print "login_language: $login_language<br>\n";
     if( $login_id ) {
       print "login_id: $login_id<br>\n";
       print "login_level: $login_level<br>\n";
       print "login_name: $login_name<br>\n";
       print "login_bin: $login_bin<br>\n";     
       print "userBins: ".join(",",$zen->getUsersBins($login_id))."<br>\n";
     } else {
       print "Not logged in<br>\n";
     }
     print "GD Info:\n";
     if( function_exists("gd_info") ) {
       print "<ul>\n";
       foreach(gd_info() as $k=>$v) {
	 print "<li>$k: $v</li>\n";
       }
       print "</ul>\n";
     }
     else {
       print "gd_info not available<br>\n";
     }
     print "<p>&nbsp;------/DEBUG OVERVIEW-------&nbsp;</p>\n";
     print "</span>\n";
  }
  if( $zen->debug ) {
     print "<span class='note'>\n";
     $zen->printDebugMessages();
     print "</span>\n";
  }
?>

</body>
</html>



