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
  if( isset($chart_add_ttl) ) {
    $chart_add_ttl = $zen->checkNum($chart_add_ttl);
  }
  if( isset($chart_add_avg) ) {
    $chart_add_avg = $zen->checkNum($chart_add_avg);
  }
  // set a toggle
  $tf_options = (isset($chart_type) && strlen($chart_type) 
	&& count($chart_options)>0 && $buttonPressed != "" 
	&& strlen($chart_title) && strlen($text_output));
?>
<tr>
  <td colspan="3" class="<?=($tf_date && !$tf_options)? "titleCell":"subTitle"?>">
     Chart Options
  </td>
</tr>
<?
  // set hidden fields
  if( $tf_data ) {
    print "<form method='post' action='$rootUrl/reports/index.php' name='reportOptionForm'>\n";
    $zen->hiddenField("report_type",$report_type);
    for($i=0; $i<count($data_set); $i++) {
      $zen->hiddenField("data_set[$i]",$data_set[$i]);
   } 
   if( $date_selector == "value" ) {
     $zen->hiddenField("date_low",$date_low);
   }
    $zen->hiddenField("date_selector",$date_selector);
    $zen->hiddenField("date_value",$date_value);
    $zen->hiddenField("date_range",$date_range);

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
?>
<tr>
  <td class='bars'>
    View Format
  </td>
  <td class='bars'>
   <input type='radio' name='text_output' 
	value='0'<?=(!strlen($text_output)||$text_output==0)?" CHECKED":""?>>
	&nbsp;Show Graph (Image)
   <br><input type='radio' name='text_output' 
	value='1'<?=(isset($text_output)&&$text_output==1)?" CHECKED":""?>>
	&nbsp;Show Tables (Text)
   <br><input type='radio' name='text_output' 
	value='2'<?=(isset($text_output)&&$text_output==2)?" CHECKED":""?>>
	&nbsp;Show Both
  </td>
  <td class="bars" rowspan='6'>
   <? if( $tf_options ) { ?>
    <input type='submit' name='buttonPressed' value=' Change '>
   <? } else { ?>
    <input type='submit' name='buttonPressed' class='submit' value=' Set '>
   <? } ?>
  </td>
</tr> 
<tr>
  <td class="bars">
    Image Type
  </td>
  <td class="bars">
    <select name='chart_type'>
<!-- onChange='document.reportOptionForm.submit()'> -->
      <option<?=($chart_type=="Bar Chart")?" SELECTED":""?>>Bar Chart</option>
      <option<?=($chart_type=="Line Chart")?" SELECTED":""?>>Line Chart</option>
<!--  <option<?=($chart_type=="Pie Chart")?" SELECTED":""?>>Pie Chart</option>  -->
    </select>
    <br><span class='note'>A large number of elements will appear better in a line chart, bar charts tend to be more pleasing with smaller numbers.</span>
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
<? if(count($data_set)>1) { ?>
    <input type='checkbox' name='chart_add_ttl' value='1'<?=($chart_add_ttl)?" CHECKED":""?>>
     &nbsp;Add a total figure
    <br><input type='checkbox' name='chart_add_avg' value='1'<?=($chart_add_avg)?" CHECKED":""?>>
     &nbsp;Add an average figure
    <br><input type='checkbox' name='chart_combine' 
	value='1'<?=($chart_combine>0)?" CHECKED":""?>>
	&nbsp;Combine selected <?=strip_tags($report_type)?>s
    <br><span class='note'>Try using <i>Combine Selected</i> with a very large number of elements, if you intend to view a graphical image.</span>
<? } else { 
  $zen->hiddenField("chart_add_ttl",0); 
  $zen->hiddenField("chart_add_avg",0); 
  $zen->hiddenField("chart_combine",0); 
  print "These options aren't useful when only graphing one element.";

} ?>
  </td>
</tr>
<? } ?>
<tr>
  <td class="bars">
    What to Graph
  </td>
  <td class="bars">
<?
    foreach($option_names as $k=>$v) {
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




