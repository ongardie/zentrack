<?
  include("{$libDir}/prepareSearchVarfields.php");
?>
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
  ?>
  <input type="checkbox" name="search_fields[title]" value="title"<?=($sft)?" checked":""?>>
   &nbsp;<?=tr("Title")?>
  <br>
  <input type="checkbox" name="search_fields[description]" value="description"<?=($sfd)?" checked":""?>>
   &nbsp;<?=tr("Description")?>
  <?
   foreach($varfieldsText as $key=>$label) {
     $sel = $search_fields[$key]? ' checked' : '';
  ?>
     <br>
     <input type="checkbox" 
            name="search_fields[<?=$key?>]" 
            value="<?=$key?>"
            <?=$sel?>>
      &nbsp;<?=tr($label)?>
  <?
   }
  ?>
  </td>
</tr>


<?  
//#####################################################
// between date field
//#####################################################
?>
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("By Date")?>
  </td>
</tr>

<tr>
  <td class="bars">
    <?=tr("Opened")?>
  </td>
  <td class="bars">
    <span class='note'><?= tr("between") ?>
    <input type="text" name="otime_begin" size="12" maxlength="10" 
      value="<?
        if (!empty($search_dates['otime_begin'])) {
          echo $zen->showDate($search_dates['otime_begin']);
        }?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
  onClick="popUpCalendar(this,document.searchForm.otime_begin, '<?=$zen->popupDateFormat()?>')"
  alt="Select a Date">
    &nbsp;<?=tr("and")?>&nbsp;
    <input type="text" name="otime_end" size="12" maxlength="10"
      value="<?= empty($search_dates['otime_end'])? "+1 day" : $zen->showDate($search_dates['otime_end']) ?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
      onClick="popUpCalendar(this,document.searchForm.otime_end, '<?=$zen->popupDateFormat()?>')"
      alt="Select a Date">
    </span>
  </td>
</tr>

<tr>
  <td class="bars">
    <?=tr("Closed")?>
  </td>
  <td class="bars">
    <span class='note'><?= tr("between") ?>
    <input type="text" name="ctime_begin" size="12" maxlength="10" 
      value="<?
        if (!empty($search_dates['ctime_begin'])) {
          echo $zen->showDate($search_dates['ctime_begin']);
        }?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
  onClick="popUpCalendar(this,document.searchForm.ctime_begin, '<?=$zen->popupDateFormat()?>')"
  alt="Select a Date">
    &nbsp;<?=tr("and")?>&nbsp;
    <input type="text" name="ctime_end" size="12" maxlength="10"
      value="<?= empty($search_dates['ctime_end'])? "+1 day" : $zen->showDate($search_dates['ctime_end']) ?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
      onClick="popUpCalendar(this,document.searchForm.ctime_end, '<?=$zen->popupDateFormat()?>')"
      alt="Select a Date">
    </span>
  </td>
</tr>

<?
//#####################################################
// variable field dates
//#####################################################
    foreach( $varfieldsDates as $key=>$label ) {
     $keyb = "{$key}_begin";
     $keye = "{$key}_end";
?>
<tr>
  <td class="bars">
    <?=tr("$label")?>
  </td>
  <td class="bars">
    <span class='note'><?= tr("between") ?>
    <input type="text" name="dates_<?=$keyb?>" size="12" maxlength="10" 
      value="<?
        if (!empty($search_dates[$keyb])) {
          echo $zen->showDate($search_dates[$keyb]);
        }?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
        onClick="popUpCalendar(this,document.searchForm.dates_<?=$keyb?>, '<?=$zen->popupDateFormat()?>')"
        title="Select a Date">
    &nbsp;<?=tr("and")?>&nbsp;
    <input type="text" name="dates_<?=$keye?>" size="12" maxlength="10"
      value="<?= empty($search_dates[$keye])? "+1 day" : $zen->showDate($search_dates[$keye]) ?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
      onClick="popUpCalendar(this,document.searchForm.dates_<?=$keye?>, '<?=$zen->popupDateFormat()?>')"
      title="Select a Date">
    </span>
  </td>
</tr>
<?
   }
?>

<?
//#####################################################
// Parameter Fields
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
	$check = ( $k == $search_params["bin_id"] )? " selected" : "";
	print "<option $check value='$k' $check>$v[name]</option>";
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
      $check = ( $k == $search_params["priority"] )? "selected" : "";
      print "<option $check value='$k'>$v</option>\n";
    }
  } else {
    print "<option value=''>--no priorities--</option>\n";
  }
?>
    </select>&nbsp;<span class='small'><?=tr("(or higher)")?></span>
  </td>
</tr>

<?
  foreach( $varfieldsParms as $key=>$val ) {
?>
<tr>
  <td class='bars'>
   <?=tr($val['field_label'])?>
  </td>
  <td class='bars'>
<?
  $type = getVarfieldDataType($key);
  if( $type == 'menu' ) {
    print "    <select name='search_params[{$key}]'>\n";
    print "        <option value=''>---</option>\n";
    foreach( genDataGroupChoices($val['field_value'], false) as $v ) {
      $t = $v['label'];
      $k = $v['field_value'];
      $sel = $k == $search_params[$key]? ' selected' : '';
      print "      <option value='$k'$sel>$t</option>\n";
    }
    print "    </select>\n";
  }
  else if( $type == 'boolean' ) {
?>
    <select name='search_params[<?=$key?>]'>
      <option value=''>---</option>
      <option value='1'>True</option> 
      <option value='0'>False</option>
    </select> 
<?
  }
  else {
    $zen->addDebug('searchForm', "Invalid parm type: $type, ignoring", 1);
  }
?> 
  </td>
</tr>
<?
  }
?>

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
