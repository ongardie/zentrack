<? if( !ZT_DEFINED ) { die("Illegal Access"); }

  function renderNavTab( $name, $page ) {
    global $keyRegisterEvents;
    global $nav_rollover_text;
    global $hotkeys;
    global $rootUrl;
    global $imageUrl;
    $keyRegisterEvents[] = array($name, $page);

    $key = $hotkeys->find($name);
    $title = $hotkeys->tooltip($key);

    $txt = "<td height='25' title='$title' valign='middle'";
    if( getZtSection() == strtolower($name) ) {
      $class = "navTab navOn";
    }
    else {
      $class = "navTab navOff";
      $txt .= " $nav_rollover_text ";
    }
    $txt .= "class='$class'>";
    $txt .= "<a class='$class' href='$rootUrl/$page'>".$hotkeys->label($key)."</a>\n";
    $txt .= "</td><td width='4'><img src='{$imageUrl}/empty.gif' width='1' height='1' border='0'></td>\n";
    return $txt;

  }

  // number of columns in nav table
  $nav_col_span = 4;

  // height of the separator between nav tabs and main content
  $nav_bar_height = 12;

  $nav_tabs =  renderNavTab('Projects', 'projects.php');
  $nav_tabs .= renderNavTab('Tickets', 'index.php');
  if ($login_level != 'first_login' &&
    $login_level >= $zen->getSetting("level_contacts") &&
    $zen->settingOn('allow_contacts') ) {
    $nav_tabs .= renderNavTab('Contacts','contacts.php');
  }
  if( $login_id ) {
    $nav_tabs .= renderNavTab('Options','options.php');
  }
  $nav_tabs .= renderNavTab('Help','help/index.php');
  if( $zen->checkNum($login_level) >= $zen->getSetting("level_settings") ) {
    $nav_tabs .= renderNavTab('Admin', 'admin/index.php');
  }

  // load hot key selections
  $sect = getZtSection();
  $load_section = $sect != 'undefined' && file_exists("$templateDir/nav_$sect.php");
  if( $load_section ) { $hotkeys->loadSection($sect); }


?>
<html>
  <head>
  <title><?=$page_prefix.$page_title?></title>
  <LINK HREF="<?=$rootUrl?>/styles.php" REL="STYLESHEET" TYPE="text/css">
  <script language="javascript">
    var imageUrl = "<?=$imageUrl?>";
  </script>

  <script language="javascript" src="<?=$rootUrl?>/javascript.js"></script>
  <script language="javascript" src="<?=$rootUrl?>/keyevent.js"></script>
  <script language="javascript" src="<?=$rootUrl?>/popcalendar.js"></script>
  <?
  for($i=0; $i<count($onLoad); $i++) {
    $s = $onLoad[$i];
    print "<script language='javascript' src='$rootUrl/$s'></script>\n";
  }
  ?>
  <script type='text/javascript'>
    var isIE = navigator.appName.indexOf('Microsoft') >= 0;
    var debugOn = <?=$Debug_Mode > 0? 'true' : 'false'?>;
    window.onload = function() {
      <?=$hotkeys->renderKeys()?>
      if( isIE ) {
        window.document.onkeydown = KeyEvent.getKey;
        window.document.onkeyup = KeyEvent.cancelKey;
      }
      else {
        window.document.onkeydown = KeyEvent.checkKey;
        window.document.onkeypress = KeyEvent.keyPress;
        window.document.onkeyup = KeyEvent.cancelKey;
      }
    }
  </script>

  </head>

<body>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr>
  <td valign="bottom" width="140" height="30">
<a href="<?=$rootUrl?>"><img
  src="<?=$imageUrl?>/zenTrack_logo.jpg"
  border="0" width="140" height="30" alt="logo"></a>
  </td>
  <td valign='bottom' align='left'><table cellpadding='0' cellspacing='0' border='0'>
    <tr><?= $nav_tabs ?></tr></table></td>
  <td align='right'>
     <form action="<?=$rootUrl?>/ticket.php" name='quickIdForm'>
      <?=$hotkeys->ll("Ticket ID")?>:</span>&nbsp;
      <input class="searchbox" type="text" name="id"
        size="6" maxlength="12" title="<?=$hotkeys->tt("Ticket ID")?>">
        &nbsp;&nbsp;&nbsp;
    </form>
  </td>
  <td>
    <div class='small' align='center'><b><?=$zen->showLongDate()?></b></div>
    <div class='small' align='center'><?=tr("version")?>
      <?=$zen->getSetting("version_xx")?>
      <? if( $zen->demo_mode == 'on' ) { print "<div class='small' align='center'>(demo mode)</div>"; } ?>
    </div>
  </td>
  </tr>
  <tr>
    <td width='100%' colspan='<?=$nav_col_span?>' class='titleCell' height='<?=$nav_bar_height?>' align='right'><img
      src='<?=$imageUrl?>/empty.gif' width='1' height='1'></td>
  </tr>
  <tr>
  <td valign="top" height="400" colspan='<?=$nav_col_span?>' class='mainContent'>

  <?
    // include left nav menu if one is appropriate
    print "<table width='100%' cellpadding='0' cellspacing='0' class='navpad'><tr>\n";
    if( $load_section ) {
      ?>

      <!-- ********* \LEFT NAV MENU\ ********* -->

      <td height='400' width='110' valign='top' align='center' class='titleCell'>
      <table width='106' height='100%' cellpadding='3' cellspacing='3'>
      <?
      include("$templateDir/nav_$sect.php");
      print "</table>\n";
      print "</td>\n";
      print "\n      <!-- ********* /LEFT NAV MENU/ ********* -->\n\n";
    }

    print "<td valign='top' height='400' class='padded'>\n";

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
<<<<<<< nav.php
 
=======
>>>>>>> 1.16
