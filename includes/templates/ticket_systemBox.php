<?
  
  if( $action ) {   
     
     if( $actionComplete == 1 ) {
	print_system_messages(1);
     }
     
     // if there is an action, include the appropriate window
     // so that the user can input the action data and commit
     
     include("$templateDir/actions/$action.php");
  
     print "<p>&nbsp;</p>\n";
  }
     
?>
       
  <table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
    <td height="250" valign="top">
      <? print_system_messages(); ?>
    </td>
   </tr>  
   </table>

