<!-- OPTIONS MENU -->
<?
  // validation
  if( $chart_options && !is_array($chart_options) ) {
    $chart_options = array($chart_options);
  }
  if( is_array($chart_options) ) {
    foreach($chart_options as $k=>$v) {
      if( $v == "" )
	unset($chart_options["$k"]);
    }
  }
  if( isset($chart_type) ) {
    $chart_type = $zen->checkAlphaNum($chart_type,' ');
  }
  else { 
    $chart_type = "";
  }
  // set a toggle
  $tf_options = (isset($chart_type) && strlen($chart_type) 
	&& $buttonPressed != "" && strlen($chart_title));
?>
<tr>
  <td colspan="3" class="<?=($tf_date && !$tf_options)? "titleCell":"subTitle"?>">
     Chart Options
  </td>
</tr>
<?
  // set hidden fields
  if( $tf_date ) {
    print "<form method='post' action='$rootUrl/reports/index.php' name='reportOptionForm'>\n";
    print "<input type='hidden' name='report_type' value='".$zen->ffv($report_type)."'>\n";
    for($i=0; $i<count($data_set); $i++) {
      print "<input type='hidden' name='data_set[$i]' value='"
            .$zen->ffv($data_set[$i])."'>\n";
   } 
   if( $date_selector == "range" ) {
     print "<input type='hidden' name='date_selector' value='range'>\n";
     print "<input type='hidden' name='date_value' value='".$zen->ffv($date_value)."'>\n";
     print "<input type='hidden' name='date_range' value='".$zen->ffv($date_range)."'>\n";
   } else {
     print "<input type='hidden' name='date_selector' value='value'>\n";
     print "<input type='hidden' name='date_low' value='".$zen->ffv($date_low)."'>\n";
     print "<input type='hidden' name='date_high' value='".$zen->ffv($date_high)."'>\n";
   }

   // make a title
   if( !isset($chart_title) || $chart_title == "" ) {
     $n = (count($data_set)>1)? $report_type."s" : $report_type;
     if( count($data_set) == 1 ) {
       $x = $data_set[0];
       $chart_title .= (preg_match("@ID@", $report_type))? 
	 "Report: $report_type $x" : $type_list["$x"]." Report";
     } else {
       $chart_title = "$n Report";     
     }
     $chart_subtitle = "(created ".strftime($zen->date_and_time).")";
   }

   // set up a couple params for form generation
   if( $chart_type == "Pie Chart" ) {
     $opttype = "radio";
   } else {
     $opttype = "checkbox";
   }
    $optfields = array( "activity"         => "Activity",        // any
			"count"            => "Ticket Count",    // not by ticket id
			"hours_actual"     => "Hours Worked",    // by id only
			"hours_estimated"  => "Estimated Hours", // by id only
			"time"             => "Elapsed Time"    // if by id, then each bin
			);

?>
<tr>
  <td class="bars">
    Chart Type
  </td>
  <td class="bars">
    <select name='chart_type' onChange='document.reportOptionForm.submit()'>
      <option<?=($chart_type=="Bar Chart")?" SELECTED":""?>>Bar Chart</option>
      <option<?=($chart_type=="Line Chart")?" SELECTED":""?>>Line Chart</option>
<!--  <option<?=($chart_type=="Pie Chart")?" SELECTED":""?>>Pie Chart</option>  -->
    </select>
  </td>
  <td class="bars" rowspan='5'>
   <? if( $tf_options ) { ?>
    <input type='submit' name='buttonPressed' value=' Change '>
   <? } else { ?>
    <input type='submit' name='buttonPressed' class='submit' value=' Set '>
   <? } ?>
  </td>
</tr>
<tr>
  <td class="bars">
    Title
  </td>
  <td class="bars">
   <input type='text' name='chart_title' value='<?=$zen->ffv($chart_title)?>' size='30' maxlength='255'>
  </td>
</tr>
<tr>
  <td class="bars">
    Subtitle
  </td>
  <td class="bars">
   <input type='text' name='chart_subtitle' value='<?=$zen->ffv($chart_subtitle)?>' size='30' maxlength='255'>
  </td>
</tr>
<? if( $chart_type != "Pie Chart" ) { ?>
<tr>
  <td class="bars">
    Data Options
  </td>
  <td class="bars">
    <input type='checkbox' name='chart_add_ttl' value='1'<?=($chart_add_ttl)?" CHECKED":""?>>
     &nbsp;Add a total figure
    <br><input type='checkbox' name='chart_add_avg' value='1'<?=($chart_add_avg)?" CHECKED":""?>>
     &nbsp;Add an average figure
  </td>
</tr>
<? } ?>
<tr>
  <td class="bars">
    What to Graph
  </td>
  <td class="bars">
<?
    foreach($optfields as $k=>$v) {
      $sel = (is_array($chart_options)&&in_array($k,$chart_options))?" checked":"";
      $optname = ($opttype=="radio")? "chart_options":"chart_options[]";
      print "<input type='$opttype' name='$optname' value='$k'$sel>&nbsp;$v<br>\n";
    }
?>
</td>
</tr>
</form>
<?   
  } else {
    // show the default screen
?>
 <tr>
  <td class='bars' colspan='3'>&nbsp;</td>
</tr>

<? } ?>




