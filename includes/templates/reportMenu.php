<table width='300'>
<tr>
  <td class='titleCell' align='center'>View Reports</td>
</tr>
<tr>
  <td class='bars' height='40' valign='top'>
   <form action='<?=$rootUrl?>/reports/show.php' method='get'>
   <select name='repid'>
<?
   $usersBins = $zen->getUsersBins($login_id);
   $reps = $zen->getReportTemplates($usersBins,$login_id);
   if( is_array($reps) && count($reps) ) {
     foreach($reps as $r) {
       print "<option value='{$r['report_id']}'>".$r["report_name"]."</option>\n";
     }
   } else {
     print "<option value=''>--none available--</option>\n";
   } 
?>
   </select>
   &nbsp;<input class='submit' type='submit' value='View'>
       	</form>
  </td>
</tr>
<tr>
  <td class='titleCell' align='center'>Manage Reports</td>
</tr>
<tr>
  <td class='subTitle' align='center'>Modify Reports</td>
</tr>
<tr>
  <td class='bars' height='40' valign='top'>
    <form method='get' action='custom.php'>
      <select name='repid'><?
   if( is_array($reps) && count($reps) ) {
     foreach($reps as $r) {
       print "<option value='{$r['report_id']}'>{$r['report_name']}</option>\n";
     }
   } else {
     print "<option value=''>--none available--</option>\n";
   } 
?></select>&nbsp;<input type='submit' class='submit' value='Modify'>
    </form>
  </td>
</tr>
<tr>
  <td class='subTitle'>Delete Reports</td>
</tr>
<tr>
  <td class='bars'>
    <form method='get' action='drop.php'>
      <select name='repid'>
<?
   if( is_array($reps) && count($reps) ) {
     foreach($reps as $r) {
       print "<option value='{$r['report_id']}'>{$r['report_name']}</option>\n";
     }
   } else {
     print "<option value=''>--none available--</option>\n";
   } 
?>
     </select>
     &nbsp; <input type='submit' class='submit' value='Delete' onClick='return confirm("Are you sure you want to PERMANENTLY delete this template?")'>
    </form>
  </td>
</tr>
<tr>
  <td class='subTitle'>Create Reports</td>
</tr>
<tr>
  <td class='bars'>
    <form method='get' action='custom.php'>
      <input type='submit' class='submit' value='New Report'>
    </form>
  </td>
</tr>
</table>






