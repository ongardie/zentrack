<!-- DATE MENU -->
<?
  // validate data
  if( $date_value ) {
    $date_value = $zen->checkNum($date_value);
  }
  if( $date_start ) {
    $date_low = $zen->dateParse($date_start);
  }
  if( $date_end ) {
    $date_high = $zen->dateParse($date_end);
  }
  if( $date_high < $date_low ) {
    $tmp = $date_low;
    $date_low = $date_high;
    $date_high = $tmp;
  }
  if( $date_high == $date_low ) {
    $date_high = $zen->dateAdjust(1,"day",$date_high);
  }
  if( $date_low ) {
    $date_start = strftime($zen->date_fmt_short,$date_low);
  }
  if( $date_high ) {
    $date_end = strftime($zen->date_fmt_short,$date_high);
  }
  if( $date_range ) {
    $date_range = $zen->checkAlphaNum($date_range);  // just chars
  }
  // set a toggle for date info entered
  $tf_date = (($date_selector=="range"
	       && $date_value && $date_range)
	      || ($date_selector=="value"&&strlen($date_low)&&strlen($date_high)));

?>
<tr>
  <td class='<?=($tf_data && !$tf_date)?"titleCell":"subTitle"?>' colspan='3'>
    Date Range
  </td>
</tr>

<? if( !$tf_data ) { ?>

<tr>
  <td class='bars' colspan='3'>&nbsp;</td>
</tr>

<? } else { ?>
 
<form method='post' action='<?=$rootUrl?>/reports/index.php' name='reportDateForm'>
<input type='hidden' name='report_type' value='<?=$zen->ffv($report_type)?>'>
<? 
  for($i=0; $i<count($data_set); $i++) {
     print "<input type='hidden' name='data_set[$i]' value='".$zen->ffv($data_set[$i])."'>\n";
  } 
?>
<tr>
  <td class="bars">
    <? $chkd = (!strlen($date_selector)||$date_selector == "range")? " checked" : ""; ?>
    <input type='radio' name='date_selector' value='range'<?=$chkd?>>&nbsp;By Range
  </td>
  <td class="bars">
    The last
    <input type='text' name='date_value' maxlength='3' size='4' value='<?=$zen->ffv($date_value)?>'>
    &nbsp;
    <select name='date_range'>
       <option value='hours'<?=($date_range == "hours")?" selected":""?>>Hours</option>
       <option value='days'<?=($date_range == "days")?" selected":""?>>Days</option>
       <option value='weeks'<?=($date_range == "weeks")?" selected":""?>>Weeks</option>
       <option value='months'<?=($date_range == "months")?" selected":""?>>Months</option>
       <option value='years'<?=($date_range == "years")?" selected":""?>>Years</option>
    </select>
  </td>
  <td rowspan='2' class='bars'>
   <? if( $tf_date ) { ?>
    <input type='submit' value=' Change '>
   <? } else { ?>
    <input type='submit' class='submit' value=' Set '>
   <? } ?>
  </td>
</tr>
<tr>
  <td class="bars">
    <? $chkd = ($date_selector == "value")? " checked" : ""; ?>
    <input type='radio' name='date_selector' value='value'<?=$chkd?>>&nbsp;Specify Dates
  </td>
  <td class="bars">
    <input type='text' name='date_start' maxlength='12' size='14' value='<?=$zen->ffv($date_start)?>'>
    &nbsp;Start Date
    <br>
    <input type='text' name='date_end' maxlength='12' size='14' value='<?=$zen->ffv($date_end)?>'>
    &nbsp;End Date
    <br><span class='note'>(dates should be in yyyy-mm-dd or mm/dd/yy format)</span>
  </td>
</tr>
</form>

<? } ?>
