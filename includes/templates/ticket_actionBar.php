<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>


<!-- BEGIN ACTION BAR -->


<table width="80" cellpadding="0" cellspacing="0">
<?{
  // array of action buttons to create
  // if the value is set to 1, will display
  // as a greyed out button if not applicable
  // on the page, otherwise hidden if not applicable
  
  if( !is_array($actions) ) 
  $actions = array(
  "log"     => 1,
  "relate"  => 1,
  "move"    => 1,		     
  "close"   => 1,
  "test"    => 1,
  "approve" => 1
  );
  foreach($actions as $a=>$v) {
    $flag = 1;
    if( $zen->actionApplicable($ticket, $a, $login_id) ) {
      $style = "style='color:".$zen->settings["color_highlight"]."'";
      $button = "submit";
    } else {
      if( !$v )
      $flag = 0;
      $style = "style='color:".$zen->settings["color_alt_background"]."'";
      $button = "button";
    }
    if( $flag ) {
      $target = ($a == 'print')?
      " target='_blank'" : "";
      print "<tr>\n<form name='$aForm' action='$rootUrl/actions/$a.php'$target>\n";
      print "<td>\n";
      
      // Possible translations: (for the benefit of translation maintenance tools)
      //  tr("Test"); tr("Approve"); tr("Accept"); tr("Assign"); tr("Print"); tr("Edit");
      $a_name = ( $page_browser == 'ns' )?
      uptr(ucfirst($a)) : str_pad( uptr(ucfirst($a)) ,18," ",STR_PAD_RIGHT);
      print "<input type='$button' class='actionButton' $style value='$a_name'>\n";
      print "<input type='hidden' name='id' value='$id'>\n";
      print "<input type='hidden' name='setmode' value='$a'>\n";
      print "</td>\n</form>\n</tr>\n";
    }
  }
  
}?>
</table>


<!-- END ACTION BAR -->

