<a name='top'></a>
<ul>
  <table bgcolor='#EEEEEE' width=600>
  <tr>
    <td colspan=4 class=titleCell>
       Pick a Script to Analyze
    </td>
  </tr>
  <tr>
   <td><b>Script:</b></td>
   <form method=post action='<?=$PHP_SELF?>'>
   <td colspan=3><?=$rootDir?>&nbsp;<input type=text name='file' size=50 maxlength=500 value='<?=$file?>'></td>
  </tr>
  <tr>
    <td><b>Type:</b></td>
    <td colspan=3>
       <select name=type>
<?
  foreach($script_types_supported as $s) {
     print ($type == $s)? "<option SELECTED>$s</option>":"<option>$s</option>";
  }
?>
       </select>
    </td>
  </tr>
  <tr>
   <td>
     Show:
   </td>
   <td>
     <input type=checkbox name=s_d <?=($s_d)? "CHECKED":""?>>&nbsp;Details
     <br>
     <input type=checkbox name=s_s <?=($s_s)? "CHECKED":""?>>&nbsp;Sessions
     <br>
     <input type=checkbox name=s_g <?=($s_g)? "CHECKED":""?>>&nbsp;Globals
   </td>
   <td valign=top>
     <input type=checkbox name=s_i <?=($s_i)? "CHECKED":""?>>&nbsp;Includes
     <br>
     <input type=checkbox name=s_f <?=($s_f)? "CHECKED":""?>>&nbsp;Functions
   </td>
   <td valign=top>
     <input type=checkbox name=s_sys <?=($s_sys)? "CHECKED":""?>>&nbsp;Syscalls
     <br>
     <input type=checkbox name=s_v <?=($s_v)? "CHECKED":""?>>&nbsp;Vars
   </td>
  </tr>
  <tr>
    <td colspan=4 class='titleCell'><input type=submit value='View'></td>
  </tr>
  </form>
  </table>
  <a href='<?=$SCRIPT_NAME?>?hlp=1&file=<?=$SCRIPT_NAME?>'>Help</a>&nbsp;&nbsp;<a href='<?=$PHP_SELF?>'>Reset</a>
</ul>
