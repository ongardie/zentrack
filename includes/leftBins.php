
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
      foreach($zen->bins as $k=>$v) {
	 $zen->getAccess($login_id);
	 if( (isset($zen->access["$k"]) && $zen->access["$k"] >= $zen->settings["level_view"])
	       ||
	     (!isset($zen->access["$k"]) && $login_level >= $zen->settings["level_view"])
	    ) {
	    if( $v > 18 )
	      $v = substr($v,0,15)."...";
	    print ($k == $login_bin)? 
	      "<option selected value='$k'>$v</option>" 
	      : "<option value='$k'>$v</option>\n";
	 }
      }
    ?>
    </select>
  </td>
  </form>
  </tr>
