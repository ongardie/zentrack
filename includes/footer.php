
   

   <!--- BEGIN FOOTER --->
  
  
  
  </td>
  </tr>
  <tr>
    <td class="titleCell" height="25"><img src="<?=$imageUrl?>/empty.gif" width="2" height="25"></td>
</tr>
</table>

<br clear="all">

<!--
<p>&nbsp;</p>
<p align="left">
   <A href="http://sourceforge.net" target="_new">
      <IMG src="http://sourceforge.net/sflogo.php?group_id=22428" 
         width="88" height="31" border="0" alt="SourceForge Logo">
   </A>
</p>
-->

<?

  include_once("$libDir/session_save.php");

  $debug_text = "";
  /*
  **  This is the debugging section... please keep this intact, as
  **  we use it extensively for support questions
  */
  if( $Debug_Overview ) {
     $debug_text .= "<span class='note'>\n";
     $debug_text .= "<p>&nbsp;------DEBUG OVERVIEW-------&nbsp;</p>\n";
     $debug_text .= "<i>To disable this output, set \$Debug_Overview in header.php to 0.</i><br>\n";
     $debug_text .= "<a href='$rootUrl/phpinfo.php'>click here to view phpinfo</a><br>\n";
     $debug_text .= "<a href='$SCRIPT_NAME?clear_session_cache=1'>click here to clear session cache</a><br>\n";
     $debug_text .= "HTTP_USER_AGENT: $HTTP_USER_AGENT<br>\n";
     $debug_text .= "SCRIPT_NAME: $SCRIPT_NAME<br>\n";
     $debug_text .= "HTTP_HOST: $HTTP_HOST<br>\n";
     $debug_text .= "HTTP_COOKIE: $HTTP_COOKIE<br>\n";
     $debug_text .= "SERVER_SOFTWARE: {$_SERVER['SERVER_SOFTWARE']}<br>\n";
     $debug_text .= "SERVER_NAME: $SERVER_NAME<br>\n";
     $debug_text .= "PHP Version: ".phpversion()."<br>\n";
     $debug_text .= "zenTrack Version: ".$zen->settings["version_xx"]."<br>\n";
     $debug_text .= "rootUrl: $rootUrl<br>\n";
     $debug_text .= "database: ".$zen->database_type."/".$zen->database_host."<br>\n";
     $debug_text .= "settings count: ".count($zen->settings)."<br>\n";
     $debug_text .= "bins: ".join(",",$zen->bins)."<br>\n";
     $debug_text .= "types: ".join(",",$zen->types)."<br>\n";
     $debug_text .= "priorities: ".join(",",$zen->priorities)."<br>\n";
     $debug_text .= "systems: ".join(",",$zen->systems)."<br>\n";
     $debug_text .= "login_language: $login_language<br>\n";
     if( $login_id ) {
       $debug_text .= "login_id: $login_id<br>\n";
       $debug_text .= "login_level: $login_level<br>\n";
       $debug_text .= "login_name: $login_name<br>\n";
       $debug_text .= "login_bin: $login_bin<br>\n";     
       $debug_text .= "userBins: ".join(",",$zen->getUsersBins($login_id))."<br>\n";
     } else {
       $debug_text .= "Not logged in<br>\n";
     }
     $debug_text .= "GD Info:\n";
     if( function_exists("gd_info") ) {
       $debug_text .= "<ul>\n";
       foreach(gd_info() as $k=>$v) {
         $debug_text .= "<li>$k: $v</li>\n";
       }
       $debug_text .= "</ul>\n";
     }
     else {
       $debug_text .= "gd_info not available<br>\n";
     }
     $debug_text .= "<p>&nbsp;------/DEBUG OVERVIEW-------&nbsp;</p>\n";
     $debug_text .= "</span>\n";
  }
  
  if( $zen->debug ) {
     $debug_text .= "<span class='note'>\n";
     ob_start();
     $zen->printDebugMessages();
     $debug_text .= ob_get_contents();
     ob_clean();
     $debug_text .= "</span>\n";
  }
  
  if( $Debug_Overview ) {
    $user = $zen->getUser($login_id);
    ?>
    <form action='<?=$rootUrl?>/help/bugs.php' method='post'>
    <input type='submit' value='Report A Bug' name='reportButton' class='submit'>
    <input type='hidden' name='name' value='<?=$zen->ffv($login_name)?>'>
    <input type='hidden' name='email' value='<?=$zen->ffv($user['email'])?>'>
    <input type='hidden' name='debug_output' value='<?=urlencode($debug_text)?>'>
    <input type='hidden' name='user_info' value='<?=$zen->ffv($_SERVER['HTTP_USER_AGENT'])?>'>
    </form>
    <p>Please send us <a href='http://www.zentrack.net/feedback/?name=<?=$zen->ffv($login_name)?>&email=<?=$user['email']?>&subject=Feedback'>Feedback</a>!</p>
    <?
  }
  
  print $debug_text;

  if( $Debug_Mode ) { 
    // used by behavior_js.php
    print "<div id='behaviorDebugDiv'></div>\n";
  }
  
  //if( is_array($ticket) ) {
  //  Zen::printArray($ticket, "Ticket Contents");
  //}
?>

</body>
</html>



