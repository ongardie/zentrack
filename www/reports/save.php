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
  $template = $zen->getTempReport($tempid);
}

// make sure we are valid
if( !$tempid || !is_array($template)) {
  print "<span class='error'>Processing error: template not found.";
} else {
  $title = $template["chart_title"];
?>
<form method='post' action='<?=$rootUrl?>/reports/saveSubmit.php' name='saveTemplateForm'>
<?=$zen->hiddenField("tempid",$tempid);?>
<table width='500' class='cell'>
<tr>
  <td class='titleCell' colspan='2' align='center'>Save Report</td>
</tr>
<? if( is_array($templates) && count($templates) ) { ?>
<tr>
  <td class='bars'>
    <input type='radio' name='save_method' value='overwrite'>
    &nbsp;Modify Existing
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
    <input type='radio' name='save_method' value='new' checked>
    &nbsp;New Template
  </td>
  <td class='bars'>
    <input type='text' name='report_name' value='<?=$zen->ffv($title)?>'>
  </td>
</tr>
<tr>
  <td class='subtitle' colspan='2' align='center'>
    Make Visible To
  </td>
</tr>
<tr>
  <td class='bars'>
    Bin(s)
  </td>
  <td class='bars'>
    <select name="select_bins[]" size='5' multiple>
<?
   $userBins = $zen->getUsersBins($login_id,"level_view");
   if( is_array($userBins) ) {
     foreach($userBins as $k=>$v) {
       if( $k ) {
         $check = (is_array($set_bins)&&in_array($k,$set_bins) )?
           "selected" : "";
         $n = $zen->bins["$k"];
         print "<option $check value='$k'>$n</option>\n";
       }
     }
   } else {
     print "<option value=''>--no bins--</option>\n";
   }
?>
    </select>
    <br><span class='note'>Use control or shift to select multiples</span>
  </td>
</tr>
<tr>
  <td class='bars'>
    User(s)
  </td>
  <td class='bars'>
<?
     print "<textarea cols='20' rows='4' name='select_users'>\n";
     print (is_array($data_set))? join(",",$data_set) : "";
     print "</textarea>\n";
     $onclick = "onClick='return popupWindowScrolls"
	."(\"/helpers/userSearchbox.php?return_form=saveTemplateForm"
	."&return_field=select_users\",\"popupHelper\",375,400)'";
     print "&nbsp;<input type='button' class='searchbox' value=' ... ' $onclick>\n";
     print "<br><span class='note'>Type ids separated by "
	."commas, or press 'search'</span>\n";
?>
    <br><span class='note'>You do not need to select yourself</span>
  </td>
</tr>
<tr>
  <td class='subtitle' colspan='2' align='center'>
    <input type='submit' class='submit' value='Save'>
  </td>
</tr>
<?
 foreach($template as $k=>$v) {
   if( $k == "report_id" || $k == "created" || $k == "report_name" ) {
     continue;
   }
   if( $k == "text_output" ) {
     switch($v) {
       case 0:
       $v = "Image Only";
       break;
       case 1:
       $v = "Text Only";
       break;
       case 2:
       $v = "Both";
     }
   }     
   else if( $k == "show_data_vals" || $k == "chart_combine" 
	    || $k == "chart_add_ttl" || $k == "chart_add_avg" ) {
     $v = ($v==1)? "Yes" : "No";
   }
   else if( $k == "chart_combine" ) {
     $v = ($v==1)? "Yes" : "No";
   }

   $k = ucwords(str_replace("_"," ",$k));
   print "<tr><td class='bars' colspan='2'>$k: "
     .((is_array($v))?join(",",$v):$v)
     ."</td></tr>\n";
 }
?>
</table>
<?
} // end else

  include("$libDir/footer.php");

?>
