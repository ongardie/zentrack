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
  if( $load_section ) {
    $hotkeys->loadSection($sect);
    $GLOBALS['zt_hotkeys'] = $hotkeys;
  }

?>
<html>
  <head>
  <title><?=$page_prefix.$page_title?></title>
  <LINK HREF="<?=$rootUrl?>/styles.php" REL="STYLESHEET" TYPE="text/css">
  <script language="javascript">
    var imageUrl = <?=$zen->fixJsVal($imageUrl)?>;
    var rootUrl = <?=$zen->fixJsVal($rootUrl)?>;
    var id = <?=$zen->fixJsVal(id)?>;
    var hotkeyHelpDelay = <?=$zen->fixJsVal($zen->getSetting('hotkeys_help_delay'))?>;
    var hotkeyHintDelay = <?=$zen->fixJsVal($zen->getSetting('hotkeys_hint_delay'))?>;
    var loaded = false;
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
      loaded = true;
      loadRenderKeys();
      window.onblur = function() {
        if( KeyEvent.hideHelp ) { KeyEvent.hideHelp(); }
      }
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
  <td class='indent' valign='bottom' align='left'><table cellpadding='0' cellspacing='0' border='0'>
    <tr><?= $nav_tabs ?></tr></table></td>
  <td align='right'>
     <form action="<?=$rootUrl?>/quickSearch.php" name='quickIdForm'>
      <?=$hotkeys->ll("Search")?>:</span>&nbsp;
      <input class="searchbox" type="text" name="idText"
        size="15" maxlength="255" onfocus='openHelpBox(window.document.getElementById("searchBoxHelp"),this)' title="<?=$hotkeys->tt("Search")?>">
        &nbsp;(<a class='small' href='<?=$rootUrl?>/search.php' title='<?=$hotkeys->tt('Advanced Search')?>'>
          <?=$hotkeys->ll('Advanced Search', 'Advanced')?></a>)&nbsp;&nbsp;
       <div id='searchBoxHelp' style='width:110px;height:75px;display:none;' class='helpBox'>
       <?=tr("Enter a ticket ID or text to search for")?></div>
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
  <td valign="top" height="400" colspan='<?=$nav_col_span?>' class='mainContent navpad'>

  <?
    // include left nav menu if one is appropriate
    print "<table width='100%' cellpadding='0' cellspacing='0'><tr>\n";
    if( $load_section ) {
      ?>

      <!-- ********* \LEFT NAV MENU\ ********* -->

      <td height='400' width='110' valign='top' align='center' class='navCell'>
      <table width='110' height='100%' class='slimPad'>
      <?
      include("$templateDir/nav_$sect.php");
      print "</table>\n";
      print "</td>\n";
      print "\n      <!-- ********* /LEFT NAV MENU/ ********* -->\n\n";
    }

    print "<td valign='top' height='400' class='gutter'>\n";

    // print out any system messages
    // which are queued up for display
    if( $msg && !is_array($msg) ) {
       $msg = array($msg);
    }
    if( is_array($msg) && count($msg) ) {
       foreach($msg as $m) {
          print "<div class='highlight indent'>".$zen->ffv($m)."</div>";
       }
       $msg = array();
    }
  ?>

  <!-- END OF NAVIGATION -->
