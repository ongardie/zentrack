<!-- SUBMIT MENU -->
<tr>
  <td class='<?=($tf_options)? "titleCell" : "subTitle" ?>' colspan='3'>
    Submit Results
  </td>
</tr>
<?
  if( $tf_type && $tf_data && $tf_date && $tf_options ) {
    // show the submit form
    print "<form method='post' action='$rootUrl/reports/view.php' name='reportSubmitForm'>\n";
    $zen->hiddenField("report_type",$report_type);
    $zen->hiddenField("data_set",$data_set);
    if( $date_selector == "range" ) {
      $zen->hiddenField( array("date_selector" => "range",
			       "date_value"    => $date_value,
			       "date_range"    => $date_range) );
    } else {
      $zen->hiddenField( array("date_selector" => "range",
			       "date_low"      => $date_low,
			       "date_high"     => $date_high) );
    }
    $zen->hiddenField("chart_title", $chart_title);
    $zen->hiddenField("chart_subtitle", $chart_subtitle);
    $zen->hiddenField("chart_add_ttl", $chart_add_ttl );
    $zen->hiddenField("chart_add_avg", $chart_add_avg );
    if( $chart_type == "Pie Chart" ) {
      $zen->hiddenField("chart_type", "pie" );			     
    }
    else if( $chart_type == "Line Chart" ) {
      $zen->hiddenField("chart_type", "line");
    }
    else if( $chart_type == "Bar Chart" ) {
      $zen->hiddenField("chart_type", "column" );
    }
    if( is_array($chart_options) ) {
      $zen->hiddenField("chart_options",$chart_options);
    }
?>
<tr>
  <td class='bars' colspan='3'><input type='submit' class='submit' value=' View Chart '></td>
</tr>  
<? if( $zen->debug ) { ?>
<tr>
  <td class='bars' colspan='3'>
   <input type='checkbox' name='debug_output' value='1'>&nbsp;Show debug output
   <br><span class='small'>(to get rid of this box, disable debugging in configVars.php)</span>
  </td>
</tr>  
<? } ?>
</form>
<?
  } else {
    // show the default text
?>
<tr>
  <td class='bars' colspan='3'>&nbsp;</td>
</tr>
<?					 
  }
?>
