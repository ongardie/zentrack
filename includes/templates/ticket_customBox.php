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
  if( $editMode ) { print "</form>\n"; }

?>
