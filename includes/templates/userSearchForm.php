<? if( !ZT_DEFINED ) { die("Illegal Access"); } 
  $hotkeys->loadSection('user_search');
?>

<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->getSetting("color_background")?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
    <?=tr("Search For Users")?>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Show All Users")?>
  </td>
</tr>

<form action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="TODO" value="ALL">
<input type="hidden" name="return_field" value="<?=$zen->ffv($return_field)?>">

<tr>
  <td class="bars" colspan="2">
   <? renderDivButtonFind("List All Users"); ?>
  </td>
</tr>

</form>
<form action="<?=$SCRIPT_NAME?>" name='searchUsersForm'>
<input type="hidden" name="TODO" value="SEARCH">

<tr>
  <td colspan="2" class="subTitle">
    <?=tr("By Text")?>
  </td>
</tr>
<tr>
  <td class="bars">
     <?=("Containing")?>
  </td>
  <td class="bars">
   <input type="text" name="search_text" 
      value="<?=$zen->ffv($search_text)?>" size="25" maxlength="50">
  </td>
</tr>
<tr>
  <td class="bars">
     <?=("In any of these")?>
  </td>
  <td class="bars">
  <?
   $sfl = (is_array($search_fields) && in_array("lname",$search_fields)) || !is_array($search_fields);
   $sff = (is_array($search_fields) && in_array("fname",$search_fields)) || !is_array($search_fields);
   $sfe = (is_array($search_fields) && in_array("email",$search_fields)) || !is_array($search_fields);
   $sfi = is_array($search_fields) && in_array("initials",$search_fields);
   $sfn = (is_array($search_fields) && in_array("notes",$search_fields)) || !is_array($search_fields);
  ?>
  <input id="field_lname" type="checkbox" name="search_fields[lname]" value="lname"<?=($sfl)?" checked":""?>>
   &nbsp;<label for='field_lname'><?=tr("Last Name")?></label>
  <br>
  <input id="field_fname" type="checkbox" name="search_fields[fname]" value="fname"<?=($sff)?" checked":""?>>
   &nbsp;<label for='field_fname'><?=tr("First Name")?></label>
  <br>
  <input id="field_email" type="checkbox" name="search_fields[email]" value="email"<?=($sfe)?" checked":""?>>
   &nbsp;<label for='field_email'><?=tr("Email")?></label>
  <br>
  <input id="field_notes" type="checkbox" name="search_fields[notes]" value="notes"<?=($sfn)?" checked":""?>>
   &nbsp;<label for='field_notes'><?=tr("Notes")?></label>
  <br>
  <input id="field_initials" type="checkbox" name="search_fields[initials]" value="initials"<?=($sfi)?" checked":""?>>
   &nbsp;<label for='field_initials'><?=tr("Initials")?></label>
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    <?=tr("By Parameters")?>
  </td>
</tr>

<tr>
  <td class="bars">
    <?=$hotkeys->ll("User ID")?>
  </td>
  <td class="bars">
    <input type="text" name="search_params[user_id]" value="<?=strip_tags($search_params["user_id"])?>" size="12" maxlength="12">
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Home Bin")?>
  </td>
  <td class="bars">
    <select name="search_params[homebin]">
       <option value="">----</option>
<?
   $userBins = $zen->getUsersBins($login_id);
   if( is_array($userBins) ) {
     print "<option $check value='all'>-All-</option>\n";
     foreach($zen->getBins(1) as $v) {
       $k = $v["bid"];
       if(in_array($k, $userBins)) {
         $check = ( $k == $search_params["homebin"] )? "selected" : "";
         print "<option $check value='$k'>$v[name]</option>\n";
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
    <?=tr("Role")?>
  </td>
  <td class="bars">
    <select name="search_params[role]">
       <option value="">----</option>
       <option value="1" <?=($search_params["role"] == 1)?"selected":""?>><?=tr("Manager")?></option>
       <option value="2" <?=
	 (strlen($search_params["role"]) && $search_params["role"] == 2)?"selected":"";
	 ?>><?=tr("Tester")?></option>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Status")?>
  </td>
  <td class="bars">
    <select name="search_params[active]">
       <option value="">----</option>
       <option value="1" <?=($search_params["active"] == 1)?"selected":""?>><?=tr("Active")?></option>
       <option value="0" <?=
	 (strlen($search_params["active"]) && $search_params["active"] == 0)?"selected":"";
	 ?>><?=tr("Disabled")?></option>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Default Access Level")?>
  </td>
  <td class="bars">
    <select name="search_access_method">
      <option value="gt"<?=($search_access_method=="gt")?" selected":""?>><?=tr("Greater Than")?></option>
      <option value="lt"<?=($search_access_method=="lt")?" selected":""?>><?=tr("Less Than")?></option>
      <option value="eq"<?=($search_access_method=="eq")?" selected":""?>><?=tr("Equals")?></option>
    </select>&nbsp;
    <input type="text" name="search_params[access_level]" 
	value="<?=strip_tags($search_params["access_level"])?>"
	size="2" maxlength="2">&nbsp;<span class="small">(<?=tr("enter a number")?>)</span>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Click 'Find' to execute the search")?>
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
     <? renderDivButtonFind("Find"); ?>
  </td>
</tr>

</table>
  
</form>
<script> setFocalPoint('searchUsersForm', 'search_text'); </script>

