<?
  /*
  **  REPORTS SHOW PAGE
  **  
  **  Displays saved reports
  */
  
  include("reports_header.php");
  $page_tile = tr("Show Report");
  include_once("$libDir/nav.php");

//security
$repid = $zen->checkNum($repid);
$tempid = $zen->checkNum($tempid);

// check for contents
if( !$repid ) {
  print "<span class='error'>" . tr("Processing Error: Report ID Missing") . "</span>\n";
} else {
  // retrieve the params of the report
  include_once("$libDir/reportDataParser.php");  
?>
<table width='640'>
<tr>
  <td class='bars' colspan='3'>
<? 
 if( $params["text_output"] > 0 ) {
   include("view_text.php");
 }
 if( $params["text_output"] != 1 ) {
?>
  <img 
	src='view_image.php?repid=<?=$repid?>&tempid=<?=$tempid?>' 
	width='<?=$zen->reportImageWidth?>' 
	height='<?=$zen->reportImageHeight?>' alt='generated chart'>
  </td>
</tr>
<? } ?>
</table>
<?

}

  include("$libDir/footer.php");
?>

