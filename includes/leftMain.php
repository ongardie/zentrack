  <div class="alttext" align="center"><b><?=strftime("%b %d, %Y ")?></b></div>
  
<?
  $num = 0;
  $num = $zen->getTicketCount('OPEN');
  print "<p align='center' class='small'>";
  print "$num open tickets in ".count($zen->bins)." bins";
  print "</p>\n";
  
  if( $login_id ) {
     if( ereg("/help/",$SCRIPT_NAME) ) {
	$expand_help = 1;
     } else if( ereg("/admin/",$SCRIPT_NAME) ) {
	$expand_admin = 1;;
     }
  } else {
     if( ereg("/help/",$SCRIPT_NAME) ) {
	$expand_help = 1;
     }
  }

?>
  
  
<table width="100%" border=1 cellspacing=0 cellpadding=2 bgcolor='<?=$zen->settings["color_title_background"]?>'>
  <? if( $login_id ) { include("$libDir/leftBins.php"); } ?>
  <tr>
  <td class="altCell" align=center>
  <b><?=$zen->prn("Tracker")?></b>
  </td>
  </tr>
  <? include("$libDir/leftTickets.php"); ?>
  <? include("$libDir/leftSearch.php"); ?>
  <tr>
  <td class="altCell" align=center>
  <b><?=$zen->prn("System")?></b>
  </td>
  </tr>  
<? if( $login_id ) { ?>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='menuLink' 
     href="<?=$rootUrl?>/index.php?logoff=1"
     onClick='return confirm("Really log out of zenTrack?")'><?=$zen->prn("Log Off")?></a>
  </td>
  </tr>       
<? } else { ?>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/index.php"><?=$zen->prn("Log On")?></a>
  </td>
  </tr>                
<? } ?>
<? include("$libDir/leftHelp.php"); ?>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/options.php"><?=$zen->prn("Options")?></a>
  </td>
  </tr>  
  <? 
     if( $login_level >= $zen->settings["level_settings"] ) {
	include("$libDir/leftAdmin.php");
      } 
  ?>
</table>
