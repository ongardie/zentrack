<?
  /*
  **  REPORTS SAVE TEMPLATE PAGE
  **  
  **  Saves templates to be viewed later
  **
  */
  
  
  include("./reports_header.php");
  $page_tile = "Save Template";
  include("$libDir/nav.php");

  // get bins this user can access, then all templates available
  $userBins = $zen->getUsersBins($login_id,"level_view");  
  $templates = $zen->getReportTemplates($userBins,$login_id);

if( $tempid ) {
  // fetch the template so we have some params to use
  $template = $zen->getTempReport($repid)
}

// make sure we are valid
if( !$tempid || !is_array($template)) {
  print "<span class='error'>Processing error: template not found.";
} else {
  $title = $template["report_name"];
?>
<table width='300'>
<tr>
  <td class='titleCell' colspan='2' align='center'>Save Report</td>
</tr>
<? if( is_array($templates) && count($templates) ) { ?>
<tr>
  <td class='bars'>
    <input type='radio' name='save_method' value='overwrite'>
    &nbsp;Overwrite Existing Report
  </td>
  <td class='bars'>
    <select name='report_id'>
<?
   foreach($templates as $t) {
     print "\t<option value='{$t['id']}'>{$t['name']}</option>\n";
   }
?>	    
    </select>
  </td>
</tr>
<? } ?>
<tr>
  <td class='bars'>
    <input type='radio' name='save_method' value='new'>
    &nbsp;Create New Report Template
  </td>
  <td class='bars'>
    <input type='text' name='report_name' value='$
  </td>
</tr>
</table>
<?
} // end else

  include("$libDir/footer.php");

?>
