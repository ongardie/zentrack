<? 
if( $TODO == 'SAVED' ) {
  $zen->print_errors($errs); 
  if( $save_message ) {
    print "<p class='bold'>".tr($save_message)."</p>";
  }
}

  $editMode = $zen->checkAccess($login_id, $bin_id, 'varfield_edit');

  if( $editMode ) {
?><form name="ticket_customForm" action="<?=$rootUrl?>/actions/editCustomSubmit.php" method='POST'><?
  }
?>
  <table width="600" align="center" cellpadding="2" cellspacing="2">
<?
  $cfd=$zen->getCustomFields(0,$page_type,"C");
  $rc = 0;
  if( $editMode ) { 
    foreach($cfd as $f) {
      $k = $f['field_name'];
      $v = $varfields["$k"];
      if( $v == 'NULL' ) { $v = ''; }
?>
  <tr>
    <td class='bars'><?=tr($f['field_label'])?></td>
    <td class='bars'>
    <?= genVarfield('ticket_customForm', $f, $v) ?>
    </td>
  </tr>
<?   
     }
  } 
  else {
    foreach($cfd as $f) {
      $k = $f['field_name'];
      $v = $varfields["$k"];
      if( $v == 'NULL' || $v == '' ) { $v = 'n/a'; }
?>
  <tr>
     <td class='smallTitleCell'><?=tr($f['field_label'])?></td>
  </tr>
  <tr>
     <td><?=$v?></td>
  </tr>
<?
    }
  }

  if( $editMode ) {
?>
    <tr>
         <td align="right">
         <input type="hidden" name="id" value="<?=strip_tags($id)?>">
   <?
    $button = "submit";
    $color = $zen->settings["color_highlight"];
   ?>
   <input type="<?=$button?>" value=" <?=uptr("Save")?> " class="actionButton" style="width:125;color:<?=$color?>">
         </td>
     </tr>
<? 
  } 

  print "</table>\n";
  if( $editMode ) { 
?>
 <script language='Javascript' type='text/javascript'>

 function validateCustomForm() {
   var errs = new Array();   
<?
 if( is_array($cfd) && count($cfd) ) {
    foreach($cfd as $v) {
      $k = $v['field_name'];
      $l = $v['field_label'];
      if( $v['js_validation'] ) {
	print preg_replace('/\{form\}/', 'document.ticket_customForm', $v['js_validation']);
      }
      else {
	$f = "document.ticket_customForm.{$k}";
	$e = 'errs[ errs.length ]';
	switch( getVarfieldDataType($k) ) {
	case "menu":
	  // if the value of the menu selection is '', then
	  // the required status is significant
	  if( $v['is_required'] ) {
	    print "if( {$f}.options[ {$f}.selectedIndex ].value == '' )"
	      . " { {$e} = '{$l} is required'; }\n";
	  }
	case "boolean":
	  // no validation for checkboxes
	  break;
	case "number":
	  // make sure it is a valid number
	  print "if( {$f}.value.match( /[^0-9.]/ ) ) { {$e} = '"
	    .tr('? is not a valid number',array(tr($l)))."'; }\n";
	default:
	  // nothing to do for dates or strings, just
	  // check the required status
	  // numbers fall through to here also
	  if( $v['is_required'] ) {
	    print "if( !{$f}.value ) { {$e} = '"
	      .tr('? is required',array(tr($l)))."'; }\n";
	  }
	}
      }
   }
 }
?>
   if( errs.length > 0 ) {
     var str = "<?=tr("Please correct the following errors:")?>\n----------\n";
     for( var i=0; i < errs.length; i++ ) {
       str += errs[i]+"\n";
     }
     alert(str);
     return false;
   }
   return true;
 }
  </script>

  </form>
<?
  }

?>
