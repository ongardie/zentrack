
<form action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="TODO" value="SEARCH">
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
     Search For Tickets
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
  <td class="bars">
     In any of these
  </td>
  <td class="bars">
  <?
   $sft = ((is_array($search_fields) && in_array("title",$search_fields)) 
	     || 
           !is_array($search_fields));
   $sfd = (is_array($search_fields) && in_array("description",$search_fields));
  ?>
  <input type="checkbox" name="search_fields[title]" value="title"<?=($sft)?" checked":""?>>
   &nbsp;Title
  <br>
  <input type="checkbox" name="search_fields[description]" value="description"<?=($sfd)?" checked":""?>>
   &nbsp;Description
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    By Parameters
  </td>
</tr>
<tr>
  <td class="bars">
     Status
  </td>
  <td class="bars">
     <select name="search_params[status]">
      <option value=''>----</option>
      <option value='OPEN'  
         <?=($search_params["status"] == 'OPEN')? " selected" : ""?>
         >Open</option>
      <option value='PENDING'  
         <?=($search_params["status"] == 'PENDING')? " selected" : ""?>
         >Pending</option>
      <option value='CLOSED'  
         <?=($search_params["status"] == 'CLOSED')? " selected" : ""?>
         >Closed</option>  
     </select>
  </td>
</tr>
<tr>
  <td class="bars">
     Owner
  </td>
  <td class="bars">
     <select name="search_params[user_id]">
       <option value="">----</option>
<?
   $userBins = $zen->getUsersBins($login_id);
   if( is_array($userBins) && $zen->settings["allow_assign"] == "on" ) {
     $users = $zen->get_users($userBins,'level_view');
     if( is_array($users) ) {
       asort($users);
       foreach($users as $k=>$v) {
	 $check = ( $search_params["user_id"] && $v["user_id"] == $search_params["user_id"] )? 
	   "selected" : "";
	 print "<option $check value='$v[user_id]'>$v[lname], $v[fname]</option>\n";
       }
     }
   }
?>
     </select>
  </td>
</tr>
<tr>
  <td class="bars">
    Type
  </td>
  <td class="bars">
    <select name="search_params[type_id]">
       <option value="">----</option>
<?
    if( is_array($zen->types) ) {
    	foreach($zen->getTypes(1) as $v) {
	  $k = $v["type_id"];
	  $check = ( $search_params["type_id"] && $k == $search_params["type_id"] )? 
	     "selected" : "";
	  print "<option $check value='$k'>$v[name]</option>\n";
	}
    } else {
      print "<option value=''>--no types--</option>\n";
    }
?>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    System
  </td>
  <td class="bars">
    <select name="search_params[system_id]">
       <option value="">----</option>
<?
    if( is_array($zen->systems) ) {
    	foreach($zen->systems as $k=>$v) {
	   $check = ( $k == $search_params["system_id"] )? "selected" : "";	   
	   print "<option $check value='$k'>$v</option>\n";
	}
    } else {
      print "<option value=''>--no systems--</option>\n";
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
    <select name="search_params[bin_id]">
       <option value="">----</option>
<?
   if( is_array($userBins) ) {
      $allbins = $zen->getBins();
      
    	foreach($allbins as $k=>$v) {
         if (in_array($k, $userBins)) {
             $check = ( $v == $search_params["bin_id"] )? "selected" : "";
             print "<option $check value='$k'>$v</option>";
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
    Priority
  </td>
  <td class="bars">
    <select name="search_params[priority]">
       <option value="">----</option>
<?
    if( is_array($zen->priorities) ) {
    	foreach($zen->getPriorities(1) as $v) {
	   $k = $v["pid"];
	   $v = $v["name"];
	   $check = ( $k == $search_params[priority] )? "selected" : "";
	   print "<option $check value='$k'>$v</option>\n";
	}
    } else {
      print "<option value=''>--no priorities--</option>\n";
    }
?>
    </select>&nbsp;<span class='small'>(or higher)</span>
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
