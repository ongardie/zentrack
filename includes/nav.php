<html>
  <head>
  <title><?=$page_prefix.$page_title?></title>
  <LINK HREF="<?=$rootUrl?>/styles.php" REL="STYLESHEET" TYPE="text/css">
  <script language="javascript" src="<?=$rootUrl?>/javascript.js"></script>
  </head>
  
<body>
<table width="800" cellpadding="2" cellspacing="1">
  <tr>
  <td valign="top" width="140" rowspan="3">
<a href="<?=$rootUrl?>"><img 
  src="<?=$imageUrl?>/zenTrack_logo.jpg" 
  border="0" width="140" height="30" alt="logo"></a>

  <? include("$libDir/leftMain.php"); ?>
  
  </td>
  <td class="titleCell" width="15"
        rowspan="3"><img src="<?=$imageUrl?>/empty.gif" width="15" height="2"></td>
  <form action="<?=$rootUrl?>/ticket.php">
  <td width="645" height="25" class="titleCell">
    <table width="600" align="center" cellpadding="0" cellspacing="0">
    <tr>
     <td width="400" class="page_section" align="center">
      <?=(isset($page_section))? strip_tags($page_section):"&nbsp;";?>
     </td>
     <td align="right" width="200">
      <span class="small">Ticket ID:</span>&nbsp;
      <input class="searchbox" type="text" name="id" 
        size="6" maxlength="12" title="Enter a ticket ID and press enter to jump to that ticket">
     </td>
    </tr>
    </table>
  </td>
  </form>
  </tr>
  <tr>
  <td valign="top" height="400" style="background:<?=$zen->settings["color_bars"]?>;">
  
  <? if( $msg ) { print "&nbsp;<p><b>$msg</b></p>"; unset($msg); } ?>
  
  <!-- END OF NAVIGATION -->
  
  
  