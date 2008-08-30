<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */

  /** 
   * Render a generic searchbox which can be used to search for entries
   * that will later be put back into a form field.  This script is intended
   * to be used from a popup/div rather than directly accessed.
   *
   * REQUIREMENTS:
   *   The following fields must appear in the POST or GET params:
   *    mode - the page mode (corresponding to 'type' in includes/templates/searchbox_type.php)
   *    type - if the page_mode is "datatype", then this must contain a valid data type to use
   *    form - the form in window.opener to return values to
   *    field - the field in window.opener to return values to
   *    multi - true if multiple values are allowed (false if only one value can be selected)
   */

  include("../header.php");
  include_once("$libDir/ZenSearch.php");
  include_once("$libDir/ZenSearchBox.php");
  $hotkeys->loadSection('searchbox');
  
  /**
   * Show the searchbox form, extracted for easy duplication
   */
  function showForm($sb, $form, $field, $hidden = false, $text = false) {
    $vals = array('form'=>$form, 'field'=>$field, 'multi'=>$sb->multi(), 
                  'mode'=>$sb->mode(), 'type' => $sb->type(), 'hidden'=>$hidden);
    if( $text ) { 
      $vals['search_text'] = $text;
    }
    else {
      $vals['search_text'] = $hidden? tr("Modify Search") : tr("Search");
    }
    $vals['content'] = $sb->renderFormFields($form, $_POST, $hidden);
    $f = $GLOBALS['templateDir']."/searchbox_form.template";
    $t = new zenTemplate($f);
    $t->values( $vals );
    $txt = $t->process();
    $fp = $sb->getFocalPoint();
    if( $fp ) { $txt .= "<script>setFocalPoint(window.document.searchboxForm.$fp);</script>\n"; }
    print $txt;
  }   
  
  if( $_POST ) {
    $searchbox_mode  = preg_replace('@[^0-9a-zA-Z_]@', '', $_POST['mode']);
    $searchbox_form  = preg_replace('@[^0-9a-zA-Z_]@', '', $_POST['form']);
    $searchbox_field = preg_replace('@[^0-9a-zA-Z_[]]@', '', $_POST['field']);
    $searchbox_type  = array_key_exists('type', $_POST)? 
      preg_replace('@[^0-9a-zA-Z_]@', '', $_POST['type']) : null;
    $searchbox_multi = array_key_exists('multi', $_POST) && $_POST['multi']? true : false;
    $searchbox_req   = empty($_POST['searchbox_req'])? 0 : 1;
  }
  else {
    $searchbox_mode  = preg_replace('@[^0-9a-zA-Z_]@', '', $_GET['mode']);
    $searchbox_form  = preg_replace('@[^0-9a-zA-Z_]@', '', $_GET['form']);
    $searchbox_field = preg_replace('@[^0-9a-zA-Z_[]]@', '', $_GET['field']);
    $searchbox_req   = empty($_GET['req'])? 0 : 1;
    $searchbox_type  = array_key_exists('type', $_GET)? 
      preg_replace('@[^0-9a-zA-Z_]@', '', $_GET['type']) : null;
    $searchbox_multi = array_key_exists('multi', $_GET) && $_GET['multi']? true : false;
  }
  
  $sb =& ZenSearchBox::getInstance($templateDir, $searchbox_mode, $searchbox_multi, $searchbox_type);
  if( !$sb ) { die("Invalid search mode"); }
  
  $title = $zen->ffv($sb->getPageTitle());
  
  print "<html><head>\n";
  print "<title>Searchbox: $title</title>";
  include("$templateDir/nav_header.php");
  print "</head><body>\n";
  
  print "<div class='subTitle'>$title</div><br>";
  
  if( !$sb->showSearchForm() || (count($_POST) && empty($_POST['repost'])) ) {
    include("$templateDir/searchbox_results.php");
    if( $sb->showSearchForm() ) {
      showForm($sb, $searchbox_form, $searchbox_field, $searchbox_results);
    }
  }
  else {
    showForm($sb, $searchbox_form, $searchbox_field);
  }
?>

<br clear="all">
<? $hotkeys->renderAccessKeys(); ?>
<script type='text/javascript'>
  <?=$hotkeys->renderFunctions()?>
  function loadRenderKeys() {
    <?=$hotkeys->renderKeys()?>
  }
</script>  

<? if( $Debug_Mode ) { ?>
<p>&nbsp;</p>
<table width='90%' align='center'>
<tr><td class='headerCell'>Debug Output</td></tr>
<tr><td>
<? $zen->printDebugMessages(); ?>
</td></tr></table>
<? } ?>

<script type='text/javascript'>
var form = <?=$zen->fixJsVal($searchbox_form)?>;
var field = <?=$zen->fixJsVal($searchbox_field)?>;
var multi = <?=$zen->fixJsVal($searchbox_multi)?>;
var required = <?=$searchbox_req?>;
function closeWindow() {
  //window.opener.setSearchboxVals(form, field, pickedVals);
  window.close();
}

function toggleAll( c ) {
  var f = window.document.searchboxForm;
  var i;
  for(i=0; i < f.elements.length; i++) {
    var e = f.elements[i];
    if( e.type == 'checkbox' && e.checked != c.checked ) { pickRow(e.id); }
  }
}

function pickRow(id, event, row) {
  var kv = getRowVals(id);
  var key = kv[0];
  if( pickedVals[key] ) { 
    pickedVals[key] = false;
    newStyle = 'bars';
    window.opener.delSearchboxVal(form, field, key);
  }
  else {
    pickedVals[key] = kv[1];
    newStyle = 'invalidBars';
    window.opener.addSearchboxVal(form, field, key, kv[1], multi, required);
  }
  if( !row ) {
    var f = window.document.getElementById(id);
    row = f.parentNode? f.parentNode.parentNode : false;
  }
  if( row && row.nodeName == "TR" ) { setClassX(row, newStyle); }
  if( !multi ) {
    closeWindow();
  }
}

function getRowVals( id ) {
  var x = window.document.getElementById(id);
  var y = window.document.getElementById(id+"_label");
  var key = x.value;
  var label = y.value;
  return [key, label];
}

function pickPage(id, offset) {
  var form = window.document.forms['searchboxForm'];
  form.offset.value = offset;
  form.repost.value = 0;
  form.submit();
}

var pickedVals = new Object();
</script>

</body>
</html>