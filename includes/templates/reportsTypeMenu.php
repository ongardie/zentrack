<?
  // set a toggle
  if( $report_type )
     $report_type = $zen->checkAlphaNum($report_type);
  $tf_type = (isset($report_type) && $report_type != "");
?>
<form method='post' action='<?=$rootUrl?>/reports/index.php'>
<tr>
  <td colspan="3" width="640" class="<?=(!$tf_type)?"titleCell":"subTitle"?>">
     Report Type
  </td>
</tr>
<tr>
  <td class="bars" width='150'>
    Pick a type
  </td>
  <td class="bars" width='390'>
    <select name='report_type'>
       <option<?=($report_type=="Bin")?" selected":""?>>Bin</option>
       <option<?=($report_type=="Project ID")?" selected":""?>>Project ID</option>
       <option<?=($report_type=="System")?" selected":""?>>System</option>
       <option<?=($report_type=="Ticket ID")?" selected":""?>>Ticket ID</option>
       <option<?=($report_type=="Type")?" selected":""?>>Type</option>
       <option<?=($report_type=="User ID")?" selected":""?>>User ID</option>
    </select>
  </td>
  <td class='bars' width='100'>
    <input type='hidden' name='action' value='set_report'>
   <? if( $tf_type ) { ?>
    <input type='submit' value=' Change '>
   <? } else { ?>
    <input type='submit' class='submit' value=' Set '>
   <? } ?>
  </td>
</tr>
</form>
