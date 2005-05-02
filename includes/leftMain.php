<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<div class="small" align="center"><b><?=$zen->showLongDate()?></b></div>
<div class="small" align='center'><?=tr("version")?> <?=$zen->settings["version_xx"]?></div>
  
<?
  $num = 0;
  $num = $zen->getTicketCount('OPEN');
  print "<p align='center' class='small'>";
  print $zen->ptrans("? open tickets in ? bins",array($num,count($zen->bins)));
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
  <b><?=tr("Tracker")?></b>
  </td>
  </tr>
  <? include("$libDir/leftTickets.php"); ?>
  <? include("$libDir/leftSearch.php"); ?>
  <?

  if ($login_level=="first_login" ) $err = 1;
	  
  if ($login_level != 'first_login' &&
      $login_level >= $zen->settings["level_contacts"] &&
      $zen->settings['allow_contacts'] == 'on' ) {
  ?>
    <tr>
      <td class="altCell" align=center>
        <b><?=tr("Contacts")?></b>
      </td>
    </tr>
  <? 
    include("$libDir/leftContacts.php"); 
  }
  ?>
  <tr>
  <td class="altCell" align=center>
  <b><?=tr("System")?></b>
  </td>
  </tr>  
<? if( $login_id ) { ?>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='menuLink' 
     href="<?=$rootUrl?>/index.php?logoff=1"
     onClick='return confirm("<?=tr("Really log out of zenTrack?")?>")'><?=tr("Log Off")?></a>
  </td>
  </tr>       
<? } else { ?>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/index.php"><?=tr("Log On")?></a>
  </td>
  </tr>                
<? } ?>
<? include("$libDir/leftHelp.php"); ?>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/options.php"><?=tr("Options")?></a>
  </td>
  </tr>  
  <? 
//we check also if login_level is a number because in first login it will be 'first_login' what would give access to all.
     if( $zen->checkNum($login_level) >= $zen->settings["level_reports"] ) {
   include("$libDir/leftReports.php");
      } 
  ?>
  <? 
     if( $zen->checkNum($login_level) >= $zen->settings["level_settings"] ) {
   include("$libDir/leftAdmin.php");
      } 
  ?>
</table>

