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
    } else {
}
  }
  $tempid = $zen->addTempReport( $params );

?>
<table width='640'>
<tr>
<form method='post' action='<?=$rootUrl?>/reports/save.php'>
<input type='hidden' name='tempid' value='<?=$zen->ffv($tempid)?>'>
  <td align='center' class='subTitle'><input 
   type='submit' class='submit' value='Save Report'></td>
</form>
<form method='post' action='<?=$rootUrl?>/reports/custom.php'>
<input type='hidden' name='tempid' value='<?=$zen->ffv($tempid)?>'>
  <td align='center' class='subTitle'><input 
   type='submit' class='submit' value='Modify Report'></td>
</form>
<form method='post' action='<?=$rootUrl?>/reports/custom.php'>
  <td align='center' class='subTitle'><input 
   type='submit' class='submit' value='New Report'></td>
</form>
</tr>
<tr>
  <td class='bars' colspan='3'>
<? 
 if( $text_output > 0 ) {
   include("./view_text.php");
 }
 if( $text_output != 1 ) {
?>
  <img 
	src='view_image.php?tempid=<?=$tempid?>' 
	width='<?=$zen->reportImageWidth?>' 
	height='<?=$zen->reportImageHeight?>' alt='generated chart'>
  </td>
</tr>
<? } ?>
</table>
<?

  } else if( is_array($errs) ) {
    $zen->printErrors($errs);
  }

  include("$libDir/footer.php");
?>