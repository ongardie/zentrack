
<form action="<?=$SCRIPT_NAME?>" name="searchForm">
<input type="hidden" name="TODO" value="SEARCH">
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
     <?=tr("Search For Tickets")?>
  </td>
</tr>

<tr>
  <td colspan="2" class="subTitle">
    <?=tr("By Text Match")?>
  </td>
</tr>
<tr>
  <td class="bars">
     <?=tr("Containing")?>
  </td>
  <td class="bars">
   <input type="text" name="search_text" 
      value="<?=htmlentities($search_text)?>" size="25" maxlength="50">
  </td>
</tr>
<tr>
  <td class="bars">
     <?=tr("In any of these")?>
  </td>
  <td class="bars">
  <?
   $sft = ((is_array($search_fields) && in_array("title",$search_fields)) 
	     || 
           !is_array($search_fields));
   //   $sfd = (is_array($search_fields) && in_array("description",$search_fields));
   //default checked
   $sfd = ((is_array($search_fields) && in_array("description",$search_fields))
	    || !is_array($search_fields)); 
   $cf = $zen->getCustomFields(1,"","S");
   foreach($cf as $k=>$v) {
     $sfCustom["$k"] = ((is_array($search_fields) && in_array("$k",$search_fields))
            || !is_array($search_fields));
   }
  ?>
  <input type="checkbox" name="search_fields[title]" value="title"<?=($sft)?" checked":""?>>
   &nbsp;<?=tr("Title")?>
  <br>
  <input type="checkbox" name="search_fields[description]" value="description"<?=($sfd)?" checked":""?>>
   &nbsp;<?=tr("Description")?>
  <?
   foreach($cf as $k=>$v) {
  ?>
     <br>
     <input type="checkbox" name="search_fields[<?=$k?>]" value="<?=$k?>"<?=($sfCustom["$k"])?" checked":""?>>
      &nbsp;<?=tr("$v")?>
  <?
   }
  ?>
  </td>
</tr>


<?
//#####################################################
//create Date field - Johan test
//#####################################################
?>

<tr>
  <td colspan="2" class="subTitle">
    <?=tr("By Date")?>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Date")?>
  </td>
  <td class="bars">
    <input type="text" name="date" size="12" maxlength="10"
value="<?if (!empty($search_params[otime])) {echo $zen->showDate($search_params[otime]);}?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
  onClick="popUpCalendar(this, document.searchForm.date, '<?=$zen->popupDateFormat()?>')"
  alt="Select a Date">
  </td>
</tr>   
<?  
//#####################################################
// between date field
//#####################################################
?>
<tr>
  <td class="bars">

    <?=tr("From")?>
  </td>
  <td class="bars">
    <input type="text" name="begin" size="12" maxlength="10" 
value="<?if (!empty($search_params[begin])) {echo $zen->showDate($search_params[begin]);}?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
  onClick="popUpCalendar(this,document.searchForm.begin, '<?=$zen->popupDateFormat()?>')"
  alt="Select a Date">
    &nbsp;(<?=tr("to")?>)&nbsp;
    <input type="text" name="end" size="12" maxlength="10"
value="<?if (!empty($search_params[end])) {echo $zen->showDate($search_params[end]);}?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
  onClick="popUpCalendar(this,document.searchForm.end, '<?=$zen->popupDateFormat()?>')"
  alt="Select a Date">
  </td>
</tr>
<?
//#####################################################
// end of from to field
//#####################################################
?>

<tr>
  <td colspan="2" class="subTitle">
    <?=tr("By Parameters")?>
  </td>
</tr>
<tr>
  <td class="bars">
     <?=tr("Status")?>
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
     <?=tr("Owner")?>
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
    <?=tr("Type")?>
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
    <?=tr("System")?>
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
    <?=tr("Bin")?>
  </td>
  <td class="bars">
    <select name="search_params[bin_id]">
       <option value="">----</option>
<?
   if( is_array($userBins) ) {
    	foreach($zen->getBins(1) as $v) {
         $k = $v["bid"];
         
         if (in_array($k, $userBins)) {
             $check = ( $v == $search_params["bin_id"] )? "selected" : "";
             print "<option $check value='$k'>$v[name]</option>";
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
    <?=tr("Priority")?>
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
    </select>&nbsp;<span class='small'><?=tr("(or higher)")?></span>
  </td>
</tr>
<tr>
  <td colspan="2" class="subTitle">
	<?=tr("Click 'Search' to execute the search")?>
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
     <input type="submit" class="submit" value="<?=tr("Search")?>">
  </td>
</tr>

</table>
  
</form>
