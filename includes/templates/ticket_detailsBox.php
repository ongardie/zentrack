
  <table width="600" align="center" cellpadding="2" cellspacing="2">
   <tr>  
   <? if( $projectID ) { 
       $project = $zen->get_ticket($projectID); 
   ?>
    <td colspan="3" class='titleCell'>PROJECT</td>
   <? } else { ?>
    <td colspan="3" rowspan="2"><span class="bigBold"><?=
	strtoupper($zen->systems["$systemID"]." ".$zen->types["$typeID"]);
	?></span></td>
   <? } ?>
    <td width="30">&nbsp;</td>
    <td class="smallTitleCell">START DATE</td>
  </tr>
  <tr style='background:<?=$zen->settings["color_background"]?>'>
   <? if( $projectID ) { ?>  
    <td colspan='3' <?=$rollover_text?>><a 
	href='<?=$rootUrl?>/project.php?id=<?=$projectID?>&setmode=Tasks' 
	class='rowLink'><?=$projectID?> -  
    	<?=stripslashes($project["title"])?></a></td>
    <? } ?>
    <td class='altCellInv'>&nbsp;</td>
    <td class='altCellInv'><?=($start_date)?$zen->showDate($start_date):"n/a"?></td>  
  </tr>
  <? if( $projectID ) { ?>
  <tr>
    <td colspan='5' height='10'>&nbsp;</td>
  </tr>
  <? } ?>
  <tr>
    <td class="smallTitleCell" width="140" height="<?=$height_num?>">BIN</td>
    <td class="smallTitleCell" width="140">TYPE</td>
    <td class="smallTitleCell" width="140">SYSTEM</td>
    <td>&nbsp;</td>
    <td class="smallTitleCell">ESTIMATED HOURS</td>
  </tr>
   <tr>
    <td><?=($binID)?$zen->bins["$binID"]:"none"?></td>
    <td><?=($typeID)?$zen->types["$typeID"]:"n/a"?></td>
    <td><?=($systemID)?$zen->systems["$systemID"]:"none"?></td>
    <td>&nbsp;</td>  
    <?
         $set = ($page_browser == 'ns')? 
            "  SET  " : str_pad("SET",18," ",STR_PAD_RIGHT);
         if( $typeID == $zen->projectTypeID() ) {
	    list($est_hours,$wkd_hours) = $zen->getProjectHours($id);
	    if( $est_hours <= 0 )
	      $est_hours = "n/a";
	    print "<td>$est_hours</td>\n";
	 } else if($est_hours > 0) {
            print "<td>$est_hours</td>\n";
	 } else if( $userID == $login_id ) {
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
    <td class="smallTitleCell" height="<?=$height_num?>">CLOSED</td>
    <td class="smallTitleCell">TESTING</td>
    <td class="smallTitleCell">APPROVAL</td>
    <td>&nbsp;</td>    
    <td class="smallTitleCell">WORKED HOURS</td>  
  </tr>
   <tr>
    <td><?=($ctime)?$zen->showDate($ctime):"n/a"?></td>    
    <td><? 
      switch($tested){
        case 1: 
	 print "<b>required</b>";
	 break; 
	case 2:
	 print "completed";
	 break; 
	default:
	 print "n/a";
      } 
     ?></td>
    <td><? 
      switch($approved){
        case 1: 
	 print "<b>required</b>";
	 break; 
	case 2:
	 print "completed";
	 break; 
	default:
	 print "n/a";
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
   <tr>
    <td colspan="5" class="smallTitleCell" height="<?=$height_num?>">DESCRIPTION</td>
   </tr>
   <tr>
    <td colspan="5" class="outlined">
   <?= nl2br(stripslashes(htmlentities($description))); ?>
    </td>
   </tr>  
   </table>

