
   

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
  if( $zen->debug > 0 ) {
     print "<span color='#666666'>\n";
     print "<p>&nbsp;------DEBUG OVERVIEW-------&nbsp;</p>\n";
     print "<p>".$zen->settings["attachment_types_allowed"]."</p>\n";
     print "<a href='$rootUrl/phpinfo.php'>phpinfo</a><br>\n";
     print "$HTTP_USER_AGENT<br>\n";
     print "page_browser: $page_browser<br>\n";
     print "bid: $bid<br>\n";
     print "id: $id<br>\n";
     print "uid: $uid<br>\n";
     print "databaseConnection: ".$zen->db_link."<br>\n";
     print "settings count: ".count($zen->settings)."<br>\n";
     print "bins: ".join(",",$zen->bins)."<br>\n";
     print "types: ".join(",",$zen->types)."<br>\n";
     print "priorities: ".join(",",$zen->priorities)."<br>\n";
     print "systems: ".join(",",$zen->systems)."<br>\n";
     if( $login_id ) {
	print "login_id: $login_id<br>\n";
	print "login_level: $login_level<br>\n";
	print "login_name: $login_name<br>\n";
	print "login_bin: $login_bin<br>\n";     
	print "userBins: ".join(",",$zen->getUsersBins($login_id))."<br>\n";
     }
     print "<p>&nbsp;------DEBUG OVERVIEW-------&nbsp;</p>\n";
     print "</span>\n";
     $zen->printDebugMessages();
  }
?>

</body>
</html>
