<?
  $b = dirname(__FILE__);
  $tutDir = "$b/tutorial";
  include("$b/user_header.php");
  
  $tutUrl = "$helpUrl/users/tutorial.php";
  $sections = array(
     'introduction'    => 'Introduction',
     'login'           => 'Logging In',
     'view_tickets'    => 'Viewing',
     'ownership'       => 'Ownership',
     'log_ticket'      => 'Log Entries',
     'bins'            => 'Bins',
     'close_ticket'    => 'Closing',
     'add_attachment'  => 'Attachments',
     'notify_list'     => 'Notifications',
     'relate_ticket'   => 'Related',
     'create_ticket'   => 'New Ticket',
     'create_project'  => 'New Project',
     'use_project'     => 'Projects',
     'contacts'        => 'Contacts',
     'advanced'        => 'Advanced'
  );
  
?>

<table width='100%'>
<tr>
  <td width='125' valign='top'>
    <?
    $linktext = '';
    $title = 'Introduction';
    $s = array_key_exists('s',$_GET)? $_GET['s'] : 'introduction';
    $s = $zen->checkAlphaNum($s);
    $save = null;
    foreach($sections as $k=>$v) {
      // if flagged, this is the next link
      if( $save === 0 ) { $save = $k; }
      if( $s == $k ) {
        // we are on the current page
        $title = $v;
        $linktext .= "<b>&gt; $v</b>"; 
        // flag for the next go around
        $save = 0;
      }
      else {
        // create a link
        $linktext .= "<a href='$tutUrl?s=$k'>$v</a>";        
      }
      $linktext .= "<br>\n";
    }
    
    print $linktext;
    ?>
  </td>
  <td class='content' valign='top'>
    <?
      if( file_exists("$tutDir/$s") ) {
        include("$tutDir/$s");
      }
      
      if( $save ) {
        print "<p align='right'><b><a href='$tutUrl?s=$save'>Next: ";
        print $sections[$save];
        print "&nbsp;&gt;&gt;</b></a></p>\n";
      }
    ?>
  </td>
</tr>
</table>

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
