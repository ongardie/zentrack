<?
  // create a default date
  if( !$search_date )
    $search_date = 30;

  // create a list of possible actions
  $query = "SELECT DISTINCT action FROM ".$zen->table_logs." ORDER BY action";
  $actions = array();
  $actions = $zen->db_list($query);
?>
<form action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="TODO" value="SEARCH">
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
     Search For Logs
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    By Text Match
  </td>
</tr>
<tr>
  <td class="bars">
     Containing
  </td>
  <td class="bars">
   <input type="text" name="search_text" 
      value="<?=htmlentities($search_text)?>" size="25" maxlength="50">
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    By Date
  </td>
</tr>
<tr>
  <td class="bars">
     Maximum Age
  </td>
  <td class="bars">
   <input type="text" name="search_date" 
      value="<?=strip_tags($search_date)?>" size="4" maxlength="4">
    &nbsp;<span class='small'>(in days, use zero to disable)</span>
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    By Parameters
  </td>
</tr>

<tr>
  <td class="bars">
    Action
  </td>
  <td class="bars">
    <select name="search_params[action]">
       <option value="">----</option>
<?
    foreach( $actions as $a ) {
       print ($a == $search_params["action"])?
	 "<option selected value='$a'>".ucwords(strtolower($a))."</option>\n" :
         "<option value='$a'>".ucwords(strtolower($a))."</opton>\n";
    }  
?>
    </select>
  </td>
</tr>

<tr>
  <td class="bars">
     User
  </td>
  <td class="bars">
     <select name="search_params[userID]">
       <option value="">----</option>
<?
   $userBins = $zen->getUsersBins($login_id);
   if( is_array($userBins) && $zen->settings["allow_assign"] == "on" ) {
     $users = $zen->get_users($userBins);
     if( is_array($users) ) {
       asort($users);
       foreach($users as $k=>$v) {
	 $check = ( $search_params["userID"] && $v["uid"] == $search_params["userID"] )? 
	   "selected" : "";
	 print "<option $check value='$v[uid]'>$v[lname], $v[fname]</option>\n";
       }
     }
   }
?>
     </select>
  </td>
</tr>

<tr>
  <td class="bars">
    Bin
  </td>
  <td class="bars">
    <select name="search_params[binID]">
       <option value="">----</option>
<?
    if( is_array($userBins) ) {
    	foreach($userBins as $k=>$v) {
	  if( $k ) {
	    $check = ( $k == $search_params["binID"] )? "selected" : "";
	    $n = $zen->bins["$k"];
	    print "<option $check value='$k'>$n</option>\n";
	  }
	}
    } else {
      print "<option value=''>--no bins--</option>\n";
    }
?>
    </select>
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    Click 'Search' to execute the log search
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
     <input type="submit" class="submit" value="Search">
  </td>
</tr>

</table>
  
</form>
