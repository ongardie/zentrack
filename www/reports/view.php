<?
  /*
  **  REPORTS INDEX PAGE
  **  
  **  Shows menus for report generation
  **
  */
  
  include("./reports_header.php");
  $page_tile = "Admin Section";
  include_once("$libDir/nav.php");

// if we have a qry=xxxxx variable
// then retrieve the report template from 
// the database and show
// otherwise, parse the viewing options and display
  
if( is_array($_POST) ) {
  extract($_POST);
}

$zen->cleanInput($report_params);
foreach($required_report_params as $k) {
  if( !isset($$k) || (is_array($$k)&&!count($$k)) || (!is_array($$k) && $$k == "") ) {
    $errs[] = "$k: ".$report_params["$k"]." required... processing error";
  }
}
if( !is_array($errs) ) {
  $params = array();
  foreach(array_keys($report_params) as $k) {
    if( is_array($$k) ) {
      $params["$k"] = join(",",$$k);
    } else if( strlen($$k) ) {
      $params["$k"] = $$k;
    }
  }
  $tempid = $zen->addTempReport( $params );

?>
<table width='640'>
<tr>
<form method='post' action='save.php' name='viewForm'>
<input type='hidden' name='tempid' value='<?=$zen->ffv($tempid)?>'>
  <td align='center' class='subTitle'><input 
   type='submit' class='submit' value='Save Report'></td>
</form>
<form method='post' action='index.php' name='viewForm'>
<input type='hidden' name='tempid' value='<?=$zen->ffv($tempid)?>'>
  <td align='center' class='subTitle'><input 
   type='submit' class='submit' value='Modify Report'></td>
</form>
<form method='post' action='index.php' name='viewForm'>
  <td align='center' class='subTitle'><input 
   type='submit' class='submit' value='New Report'></td>
</form>
</tr>
<tr>
  <td class='bars' colspan='3'>
<? 
 if( $zen->debug && $debug_output > 0 ) {
   include("./view_text.php");
 } else {
?>
  <img 
	src='view_image.php?tempid=<?=$tempid?>' 
	width='<?=$zen->reportImageWidth?>' 
	height='<?=$zen->reportImageHeight?>' alt='generated chart'>
<? } ?>
  </td>
</tr>
</table>
<?

  } else {
    $zen->printErrors($errs);
  }

  include("$libDir/footer.php");
?>
