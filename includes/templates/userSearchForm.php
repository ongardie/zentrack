
<form action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="TODO" value="SEARCH">
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
    Search For Users
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    By Text
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
  <td class="bars">
     In any of these
  </td>
  <td class="bars">
  <?
   $sfl = ((is_array($search_fields) && in_array("lname",$search_fields)) 
	     || 
           !is_array($search_fields));
   $sff = (is_array($search_fields) && in_array("fname",$search_fields));
   $sfn = (is_array($search_fields) && in_array("notes",$search_fields));
   $sfi = (is_array($search_fields) && in_array("initials",$search_fields));
  ?>
  <input type="checkbox" name="search_fields[lname]" value="lname"<?=($sfl)?" checked":""?>>
   &nbsp;Last Name
  <br>
  <input type="checkbox" name="search_fields[fname]" value="fname"<?=($sff)?" checked":""?>>
   &nbsp;First Name
  <br>
  <input type="checkbox" name="search_fields[initials]" value="initials"<?=($sfi)?" checked":""?>>
   &nbsp;Initials
  <br>
  <input type="checkbox" name="search_fields[notes]" value="notes"<?=($sfn)?" checked":""?>>
   &nbsp;Role
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    By Parameters
  </td>
</tr>

<tr>
  <td class="bars">
    user ID
  </td>
  <td class="bars">
    <input type="text" name="search_params[userID]" value="<?=strip_tags($search_params["userID"])?>" size="12" maxlength="12">
  </td>
</tr>
<tr>
  <td class="bars">
    Home Bin
  </td>
  <td class="bars">
    <select name="search_params[homebin]">
       <option value="">----</option>
<?
   $userBins = $zen->getUsersBins($login_id);
   if( is_array($userBins) ) {
     foreach($userBins as $k=>$v) {
       if( $k ) {
	 $check = ( $k == $search_params["homebin"] )? "selected" : "";
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
  <td class="bars">
    Status
  </td>
  <td class="bars">
    <select name="search_params[active]">
       <option value="">----</option>
       <option value="1" <?=($search_params["active"] == 1)?"selected":""?>>Active</option>
       <option value="0" <?=
	 (strlen($search_params["active"]) && $search_params["active"] == 0)?"selected":"";
	 ?>>Disabled</option>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    Default Access Level
  </td>
  <td class="bars">
    <select name="search_access_method">
      <option value="gt"<?=($search_access_method=="gt")?" selected":""?>">Greater Than</option>
      <option value="lt"<?=($search_access_method=="lt")?" selected":""?>">Less Than</option>
      <option value="eq"<?=($search_access_method=="eq")?" selected":""?>">Equals</option>
    </select>&nbsp;
    <input type="text" name="search_params[accessLevel]" 
	value="<?=strip_tags($search_params["accessLevel"])?>"
	size="2" maxlength="2">&nbsp;<span class="small">(enter a number)</span>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    Click 'Search' to execute the search
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
     <input type="submit" class="submit" value="Search">
  </td>
</tr>

</table>
  
</form>
