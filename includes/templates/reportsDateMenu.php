<!-- DATE MENU -->
<?
  // validate data
  if( $date_value ) {
    $date_value = $zen->checkNum($date_value);
  }
  if( $date_start ) {
    $date_low = $zen->dateParse($date_start);
  }
  if( $date_low ) {
    $date_start = strftime($zen->date_fmt_short,$date_low);
  } else if( !$date_selector ) {
    $date_selector = "range";
  }
  if( $date_range ) {
    $date_range = $zen->checkAlphaNum($date_range);  // just chars
  }
  // set a toggle for date info entered
  $tf_date = ($date_value&&$date_range
	      &&($date_selector=="range"||$date_low > 0));


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
 
<form method='post' action='<?=$rootUrl?>/reports/custom.php' name='reportDateForm'>
<input type='hidden' name='report_type' value='<?=$zen->ffv($report_type)?>'>
<? 
  for($i=0; $i<count($data_set); $i++) {
     print "<input type='hidden' name='data_set[$i]' value='".$zen->ffv($data_set[$i])."'>\n";
  } 
?>
<tr>
  <td class="bars">
    Range    
  </td>
  <td class="bars">
    <select name='date_value'>
    <?
      for($i=1; $i<21; $i++) {
	$sel = ($date_value == $i)? " selected" : "";
	print "\t<option$sel>$i</option>\n";
      }
    ?>
    </select>
    &nbsp;
    <select name='date_range'>
       <option value='hours'<?=($date_range == "hours")?" selected":""?>>Hours</option>
       <option value='days'<?=($date_range == "days")?" selected":""?>>Days</option>
       <option value='weeks'<?=($date_range == "weeks")?" selected":""?>>Weeks</option>
       <option value='months'<?=($date_range == "months")?" selected":""?>>Months</option>
       <option value='years'<?=($date_range == "years")?" selected":""?>>Years</option>
    </select>
  </td>
  <td rowspan='3' class='bars'>
   <? if( $tf_date ) { ?>
    <input type='submit' value=' Change '>
   <? } else { ?>
    <input type='submit' class='submit' value=' Set '>
   <? } ?>
  </td>
</tr>
<tr>
  <td class="bars" colspan='2'>
    <? $chkd = (!strlen($date_selector)||$date_selector == "range")? " checked" : ""; ?>
    <input type='radio' name='date_selector' value='range'<?=$chkd?>>&nbsp; Most Current
  </td>
</tr>
<tr>
  <td class="bars">
    <? $chkd = ($date_selector == "value")? " checked" : ""; ?>
    <input type='radio' name='date_selector' value='value'<?=$chkd?>>&nbsp;Start From Date
  </td>
  <td class="bars">
    <input type='text' onFocus="moveReportSelector()" name='date_start' maxlength='12' size='14' value='<?=$zen->ffv($date_start)?>'>
    <span class='note'>&nbsp;mm/dd/yyyy hh:mm (time optional)</note>
  </td>
</tr>
</form>

<script language='javascript'>
  function moveReportSelector() {
     document.reportDateForm.date_selector[1].checked = true;
  }
</script>

<? } ?>









