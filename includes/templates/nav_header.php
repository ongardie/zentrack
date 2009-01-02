<? if( !ZT_DEFINED ) { die("Illegal Access"); }
 /**
  * Header content for page top (navigation), suitable for use in pages
  * which do not show the navigation.
  *
  * Requirements:
  *   $imageUrl - (String)http url to access images directory
  *   $rootUrl - (String)http url for the root ZT directory
  *   $id - (integer)ticket id, if applicable
  *   $zen - (zenTrack instance)
  *   $onLoad - (array)javascripts to load with this page
  *   $Debug_Mode - (integer) debug output level to utilize
  */
  
  // used to prevent javascript caching problems in browsers by insuring 
  // that whenever an upgrade is performed, the javascript files will all be reloaded
  $jsv = urlencode($zen->getSetting('version_xx'));
?>
  <script language="javascript">
    var imageUrl = <?=$zen->fixJsVal($imageUrl)?>;
    var rootUrl = <?=$zen->fixJsVal($rootUrl)?>;
    var id = <?=$zen->fixJsVal(id)?>;
    var hotkeyHelpDelay = <?=$zen->fixJsVal($zen->getSetting('hotkeys_help_delay'))?>;
    var hotkeyHintDelay = <?=$zen->fixJsVal($zen->getSetting('hotkeys_hint_delay'))?>;
    var loaded = false;
    var isIE = navigator.appName.indexOf('Microsoft') >= 0;
    var debugOn = <?=$Debug_Mode > 0? 'true' : 'false'?>;
    window.onload = function() { loaded=true; } //generic load method, can be overridden
  </script>
  <script language="javascript" src="<?=$rootUrl?>/javascript.js?v=<?=$jsv?>"></script>
  <script language="javascript" src="<?=$rootUrl?>/keyevent.js?v=<?=$jsv?>"></script>
  <script language="javascript" src="<?=$rootUrl?>/popcalendar.js?v=<?=$jsv?>"></script>
  <?
  for($i=0; $i<count($onLoad); $i++) {
    $s = $onLoad[$i];
    if( strpos($s, "http://") !== 0 ) {
      if( strpos($s, '?') > 0 ) { $s .= "&v=$jsv"; }
      else { $s .= "?v=$jsv"; }
      $s = "$rootUrl/$s";
    }
    print "<script language='javascript' src='$s'></script>\n";
  }
  ?>

  <LINK HREF="<?=$rootUrl?>/styles.php?v=<?=$jsv?>" REL="STYLESHEET" TYPE="text/css">
	<link rel="stylesheet" href="<?=$rootUrl?>/js_color_picker_v2.php?v=<?=$jsv?>" type="text/css" media="screen">
  <link rel="stylesheet" type="text/css" href="<?=$rootUrl?>/css/yui/folder/tree.css">
  <script type='text/javascript'>
    var focusField = false;
    
    function loadRenderKeys() {} //dummy method (populated in footer of page)
    
    function setHotKeys() {
      loadRenderKeys();
      if( isIE ) {
        window.document.onkeydown = KeyEvent.getKey;
        window.document.onkeyup = KeyEvent.cancelKey;
      }
      else {
        window.document.onkeydown = KeyEvent.checkKey;
        window.document.onkeypress = KeyEvent.keyPress;
        window.document.onkeyup = KeyEvent.cancelKey;
      }
      if( focusField ) { placeFocus(focusField); }
    }

    addToOnload(setHotKeys);
    
    /**
     * Set the focal point that will recieve cursor focus when the page finishes
     * loading.  If the focal point is already set, calls to this method are ignored
     *
     * There are three ways this method can be called.  By passing an object in
     * the variable o, by passing a string id in o (used with getElementById()),
     * or by passing a form name as o and a field name as f.
     *
     * @param mixed o -- an object or a string (see above)
     * @param string f -- a field name (see above)
     * @return void
     */
    function setFocalPoint( o, f ) {
      if( focusField ) { return; }
      var s = o;
      if( f ) { o = window.document.forms[o].elements[f]; }
      else if( typeof(o) == "string" ) { o = window.document.getElementById(o); }
      focusField = o;
    }
  </script>