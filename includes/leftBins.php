
  <tr>
  <td class="altCell" align=center>
  <b><?=$zen->prn("Current Bin")?></b>
  </td>
  </tr>
  <tr>
  <form name="newbin" action="<?=$SCRIPT_NAME?>">
  <td>
    <select name="newbin" onChange="document.newbin.submit()">
      <option value='all'>-All-</option>
    <?
      foreach($zen->getBins(1) as $v) {
	 $k = $v["bid"];
	 $zen->getAccess($login_id);
	 if( (isset($zen->access["$k"]) && $zen->access["$k"] >= $zen->settings["level_view"])
	       ||
	     (!isset($zen->access["$k"]) && $login_level >= $zen->settings["level_view"])
	    ) {
	    if( strlen($v["name"]) > 18 )
	      $v["name"] = substr($v["name"],0,16)."...";
	    print ($k == $login_bin)? 
	      "<option selected value='$k'>$v[name]</option>" 
	      : "<option value='$k'>$v[name]</option>\n";
	 }
      }
    ?>
    </select>
  </td>
  </form>
  </tr>
