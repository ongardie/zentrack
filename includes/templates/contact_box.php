<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

<table width="100%" cellspacing='1' class='formtable'>
<?
if( $overview == 'company' ) {
  include("$templateDir/listContactsHeading.php");
}
else {
  include("$templateDir/listContacts2Heading.php");
}

  /*
  ** DETERMINE WHICH SCREEN TO SHOW AND SHOW IT
  */
  if( $page_mode == 'other' ) {
    // WARNING: Changing $display_range will likely break code in the loop below.
    $display_range = '!0123456789';
  }
  else {
    $display_range = $page_mode;
  } 
  // We are going to display the contacts by stepping through each char in
  // $display_range and calling get_contacts to display the contacts that
  // begin with that char.
  for($i=0; $i<strlen($display_range); $i++) {
    $l = substr($display_range,$i,1);
    $letter = strtoupper($l);
    $sort = $title." asc";

    // List all contacts beginning with a symbol first.  The '!' is used to
    // denote when we should display the symbols section.
    if( $l == "!" ) {
      $letter = "Symbols"; // Give the symbol list a nicer title
      // List of chars we will use to find symbols
      // WARNING: Changing the value of $symbols will likely break things.
      // If you do add chars to $symbols, you must add a pair of chars that will
      // be searched between.
      $symbols = chr(31)."09AZaz".chr(127);  // This list covers all common ascii symbols
      // Add contacts that begin with a char between $s and $s+1
      for($j=0; $j<strlen($symbols); $j++) {
        $s = substr($symbols,$j++,1);
        $parms = array();
	$parms[] = array($title, ">", $s);
	$s = substr($symbols,$j,1);
	$parms[] = array($title, "<", $s);
        if( $overview != 'company' ) {
	  $parms[] = array("inextern", "=", $ie);
	}
	if($tickets) {
	  $moretickets = $zen->get_contacts($parms,$tabel,$sort);
	  if($moretickets) { $tickets = array_merge($tickets, $moretickets); }
	}
	else {
	  $tickets = $zen->get_contacts($parms,$tabel,$sort);
        }
      }
    }
    else {
      // Add contact beginning with letter $l
      $parms = array();
      $parms[] = array($title, "like", $l.'%');
      if( $overview != 'company' ) {
        $parms[] = array("inextern", "=", $ie);
      }
      $tickets = $zen->get_contacts($parms,$tabel,$sort);
    }

    if( $overview == 'company' ) {
      $tickets = $hotkeys->activateList($tickets, 'title', 'title', "KeyEvent.loadUrl('$rootUrl/contact.php?cid={company_id}')");
    }
    else {
      $tickets = $hotkeys->activateList($tickets, 'lname', 'lname', "KeyEvent.loadUrl('$rootUrl/contact.php?pid={person_id}')");
    }
    ?>
      <tr>
       <td class='headerCell' align="center" colspan='5'>
         <?=$letter?>
       </td>
      </tr>
    <?
    if( is_array($tickets) ) {
      $link  = "$rootUrl/contact.php";
      $td_ttl = "title='".tr("Click here to view the Contact")."'";

     foreach($tickets as $t) {
       if( $overview == 'company' ) {
         include("$templateDir/listContacts.php");
       }
       else {
         include("$templateDir/listContacts2.php");
       }
     }
    } else {
      print "<tr><td class='bars note' colspan='5'>".tr('No contacts for section ?', $letter)."</td></tr>";
    }
  }

?>
</table>
