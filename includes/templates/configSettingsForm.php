      <br>
      <p class='error'>Changing these settings can have a severe impact on the system.  Please consider this before making modifications.</p>
      <p>All entries must contain a value.</p>

      <form name='binForm' action='<?=$SCRIPT_NAME?>' method='post' onSubmit='return confirm("Save system settings?")'>
      <table width="600" cellpadding="2" cellspacing="1" class='plainCell'>
	 <tr>
	 <td class='titleCell' align='center' colspan='4'>
	   <b>Edit <?=$zen->settings["system_name"]?> Settings</b>
	 </td>
	 </tr>
	 <tr>
	 <td width="30" class='cell' align='center'><b>ID</b></td>
	 <td width="45" class='cell' align='center'><b>Name</b></td>
	 <td class='cell' align='center'><b>Value</b></td>
	 <td class='cell' align='center'><b>Description</b></td>
	 </tr>
    <? 

    foreach($settings as $s) {
      if( preg_match("#^url_#",$s["name"]) ) {
	$s["value"] = preg_replace("#^$rootUrl/?#i", "", $s["value"]);
      }
      $k = $s["setting_id"];
      $class = ($class == "bars")? "cell" : "bars";
      $n = preg_replace("@_xx$@", "", $s["name"]);
      print "<tr><td class='$class'>$k</td>\n";
      print "<td class='$class'>$n</td>\n";
      print "<td class='$class'>";
      if( preg_match("@_xx$@", $s["name"]) ) {
	print $s["value"]." [permanent]";
      } else if( $s["value"] == "on" || $s["value"] == "off" ) {
	print "<select name='newSettings[$k]'>";
	print ($s["value"] == "on")? 
	  "<option selected value='on'>On</option>" : "<option value='on'>On</option>\n";
	print ($s["value"] == "off")?
	  "<option selected value='off'>Off</option>" : "<option value='off'>Off</option>\n";
	print "</select>\n";
      } else {
	print "<input type='text' style='font-size:"
	   .$zen->settings["font_size_small"]."px' name='newSettings[$k]' "
	   ." size='20' maxlength='100' value='".htmlentities($s["value"])."'>";
      }
      print "</td>";
      print "<td class='$class'>$s[description]</td>\n";
      print "</tr>\n";
    }

    ?>
<tr>
  <td class="titleCell" colspan="4">
    Press 'Save' when you are sure that the values are correct.
    <br>Press 'Reset' to restore the original values
  </td>
</tr>
      <tr>
	 <td class='cell' colspan='4'>
	 <input type='submit' class='submit' name='TODO' value='Save'>
	 &nbsp;
	 <input type='submit' class='submitPlain' name='TODO' value='Reset'>
         </td>
      </tr>
      </table>

      </form>






