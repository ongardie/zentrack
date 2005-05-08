<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>

  <table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
   <? if( $project_id ) { 
       $project = $zen->get_ticket($project_id); 
   ?>
    <td colspan="3" class='titleCell'><?=uptr("Project")?></td>
   <? } else { ?>
    <td colspan="3" rowspan="2"><span class="bigBold"><?=
    strtoupper($zen->systems["$system_id"]." ".$zen->types["$type_id"]);
    ?></span></td>
   <? } ?>
    <td width="30">&nbsp;</td>
    <td class="smallTitleCell"><?=uptr("Start Date")?></td>
  </tr>
  <tr style='background:<?=$zen->settings["color_background"]?>'>
   <? if( $project_id ) { ?>  
    <td colspan='3' <?=$rollover_text?>><a 
	href='<?=$rootUrl?>/project.php?id=<?=$project_id?>' 
	class='rowLink'><?=$project_id?> -  
    	<?=$zen->ffv($project["title"])?></a></td>
    <? } ?>
    <td class='altCellInv'>&nbsp;</td>
    <td class='altCellInv'><?=($start_date)?$zen->showDateTime($start_date):"n/a"?></td>  
  </tr>
  <? if( $project_id ) { ?>
  <tr>
    <td colspan='5' height='10'>&nbsp;</td>
  </tr>
  <? } ?>
  <tr>
    <td class="smallTitleCell" width="140" height="<?=$height_num?>"><?=uptr("Bin")?></td>
    <td class="smallTitleCell" width="140"><?=uptr("Type")?></td>
    <td class="smallTitleCell" width="140"><?=uptr("System")?></td>
    <td>&nbsp;</td>
    <td class="smallTitleCell"><?=uptr("Estimated Hours")?></td>
  </tr>
   <tr>
    <td><?=($bin_id)?$zen->bins["$bin_id"]:tr("n/a")?></td>
    <td><?=($type_id)?$zen->types["$type_id"]:tr("n/a")?></td>
    <td><?=($system_id)?$zen->systems["$system_id"]:tr("n/a")?></td>
    <td>&nbsp;</td>  
    <?
    $set = ($page_browser == 'ns')? 
    "  ".uptr("Set")."  " : str_pad(uptr("Set"),18," ",STR_PAD_RIGHT);
    if( $type_id == $zen->projectTypeID() ) {
	    list($est_hours,$wkd_hours) = $zen->getProjectHours($id);
	    if( $est_hours <= 0 )
      $est_hours = tr("n/a");
	    print "<td>$est_hours</td>\n";
    } else if($est_hours > 0) {
      print "<td>$est_hours</td>\n";
    } else if( $user_id == $login_id ) {
	    echo('
      <form method="post" action="'.$rootUrl.'/actions/estimate.php">
		  <input type="hidden" name="id" value="'.$id.'">
		  <td><input type="submit" class="actionButton" value="'.$set.'"></td>
      </form>');
    } else {
	    echo('
      <form method="post" action="'.$rootUrl.'/actions/estimate.php">
		  <input type="hidden" name="id" value="'.$id.'">
		  <td><input type="button" class="actionButton"
      style="color:'.$zen->settings["color_alt_background"].'"
      value="'.$set.'"></td>
      </form>');
    }
    ?>
  </tr>
  <tr>
    <td class="smallTitleCell" height="<?=$height_num?>"><?=uptr("Closed")?></td>
    <td class="smallTitleCell"><?=uptr("Testing")?></td>
    <td class="smallTitleCell"><?=uptr("Approval")?></td>
    <td>&nbsp;</td>    
    <td class="smallTitleCell"><?=uptr("Hours Worked")?></td>  
  </tr>
   <tr>
    <td><?=($ctime)?$zen->showDateTime($ctime):tr("n/a")?></td>    
    <td><? 
      switch($tested){
        case 1: 
         print "<b>".tr("required")."</b>";
         break; 
        case 2:
         print tr("completed");
         break; 
        default:
         print tr("n/a");
      } 
     ?></td>
    <td><? 
      switch($approved){
        case 1: 
         print "<b>".tr("required")."</b>";
         break; 
        case 2:
         print tr("completed");
         break; 
        default:
         print tr("n/a");
      } 
     ?></td>  
    <td>&nbsp;</td>    
    <td><?
      print ($wkd_hours > 0)? $wkd_hours : "0";
      if( $est_hours > 0 )
        print " (".$zen->percentWorked($est_hours,$wkd_hours)."%)";
      ?></td>
    <td>&nbsp;</td>    
  </tr>
   <tr colspan="5" height="5">
    <td><img src="<?=$rootUrl?>/images/empty.gif" width="2" height="5"></td>  
   </tr>

<?
  $cfd=$zen->getCustomFields(1,$page_type,"D");
  foreach($cfd as $k => $v) {
    $varfield_type=ereg_replace("[^a-z_]", "", $k);
    switch($varfield_type) {
      case "custom_number":
        $cfv = strlen($varfields["$k"])? $varfields["$k"] : '&nbsp;';
        break;
      case "custom_date":
        $cfv = $varfields["$k"]? $zen->showDateTime($varfields["$k"]) : "&nbsp;";
        break;
      case "custom_text":
        $cfv = strlen($varfields["$k"])? $zen->ffvText($varfields["$k"]) : "&nbsp;";
        break;
      default:
        $cfv = $varfields["$k"]? $zen->ffv($varfields["$k"]) : '&nbsp;';
        break;
    }
?>
   <tr>
    <td colspan="3" class="smallTitleCell" height="<?=$height_num?>"><?=$v?></td>
    <td colspan='2'>&nbsp;</td>
   </tr>
   <tr>
      <td colspan="3"<?= $varfield_type == 'custom_text'? " class='outlined'" : '' ?>>
      <?= $cfv ?>
    </td>
    <td colspan='2'>&nbsp;</td>
   </tr>
<?
  }
?>

   <tr colspan="5" height="5">
    <td><img src="<?=$rootUrl?>/images/empty.gif" width="2" height="5"></td>  
   </tr>
   <tr>
    <td colspan="5" class="smallTitleCell" height="<?=$height_num?>"><?=uptr("Description")?></td>
   </tr>
   <tr>
    <td colspan="5" class="outlined">
   <?= $zen->ffvText($description) ?>
    </td>
   </tr>  

   </table>
