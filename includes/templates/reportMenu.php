<table width='300'>
<tr>
  <td class='titleCell' align='center'>View Reports</td>
</tr>
<tr>
  <td class='bars' height='40' valign='top'>
   <form action='<?=$rootUrl?>/reports/view.php' method='get'>
   <select name='repid'>
<?
   $usersBins = $zen->getUsersBins($login_id);
   $reps = $zen->getReportTemplates($usersBins,$login_id);
   if( is_array($reps) && count($reps) ) {
     foreach($reps as $r) {
       print "<option value='$r'>".$zen->getBinName($r)."</option>\n";
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
  <td class='titleCell' align='center'>Modify Reports</td>
</tr>
<tr>
  <td class='bars' height='40' valign='top'>
    <form method='get' action='list.php'>
      <select name='repid'>
<?
   if( is_array($reps) && count($reps) ) {
     foreach($reps as $r) {
       print "<option value='$r'>".$zen->getBinName($r)."</option>\n";
     }
   } else {
     print "<option value=''>--none available--</option>\n";
   } 
?>
     </select>
     &nbsp; <input type='submit' class='submit' value='Modify'>
    </form>
  </td>
</tr>
<tr>
  <td class='titleCell' align='center'>New Report</td>
</tr>
<tr>
  <td class='bars'>
    <form method='get' action='custom.php'>
      <input type='submit' class='submit' value='Create'>
    </form>
  </td>
</tr>
</table>