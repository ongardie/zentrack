<? if( !ZT_DEFINED ) { die("Illegal Access"); } ?>
<html>
  <head>
  <title><?=$page_prefix.$page_title?></title>
  <LINK HREF="<?=$rootUrl?>/styles.php" REL="STYLESHEET" TYPE="text/css">
  <script language="javascript">
    var imageUrl = "<?=$imageUrl?>";
  </script>

  <script language="javascript" src="<?=$rootUrl?>/javascript.js"></script>
  <script language="javascript" src="<?=$rootUrl?>/popcalendar.js"></script>
  <?
  for($i=0; $i<count($onLoad); $i++) {
    $s = $onLoad[$i];
    print "<script language='javascript' src='$rootUrl/$s'></script>\n";
  }
  ?>

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
        rowspan="4"><img src="<?=$imageUrl?>/empty.gif" width="15" height="2"></td>
  <td width="645" height="25" class="titleCell">
    <form action="<?=$rootUrl?>/ticket.php">
    <table width="600" align="center" cellpadding="0" cellspacing="0">
    <tr>
     <td width="400" class="page_section" align="center">
      <?=(isset($page_section))? strip_tags($page_section):"&nbsp;";?>
     </td>
     <td align="right" width="200">
      <span class="small"><?=tr("Ticket ID")?>:</span>&nbsp;
      <input class="searchbox" type="text" name="id" 
        size="6" maxlength="12" title="<?=tr("Enter a ticket ID and press enter")?>">
     </td>
    </tr>
    </table>
    </form>
  </td>
  </tr>
  <tr>
  <td valign="top" height="400" class='mainContent'>
  
  <? 
    // print out any system messages
    // which are queued up for display
    if( $msg && !is_array($msg) ) {
       $msg = array($msg);
    }
    if( is_array($msg) && count($msg) ) { 
       print "&nbsp;<p><b>\n";
       foreach($msg as $m) {
          print "$m<br>";   
       }
       print "</b></p>\n";
       $msg = array();
    }
  ?>
  
  <!-- END OF NAVIGATION -->
  
  
  
