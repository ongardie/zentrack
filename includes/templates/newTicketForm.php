<?  
  unset($users);
  $td = ($TODO == 'EDIT');
  if( $td ) {
    $userBins = $zen->getUsersBins($login_id,"level_edit");  
  }
  else {
    $userBins = $zen->getUsersBins($login_id,"level_create");
  }
  if( is_array($userBins) && count($userBins) ) {
    $users = $zen->get_users( $userBins, "level_user" );
  } else {
    print "<span class='error'>";
    if( $td ) {
      print tr("You do not have permission to edit tickets.");
    }
    else {
      print tr("You do not have permission to create tickets.");
    }
    print "</span>\n";
    include("$libDir/footer.php");
    exit;
  }
  if( !$deadline && !$td )
     $deadline = $zen->getDefaultValue("default_deadline");
  if( !$start_date && !$td )
     $start_date = $zen->getDefaultValue("default_start_date");
?>     

<form method="post" name="ticketForm" action="<?=($td)? "editTicketSubmit.php" : "$rootUrl/addSubmit.php"?>" onSubmit='return validateTicketForm()'>
<input type="hidden" name="id" value="<?=strip_tags($id)?>">

  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
     <?=tr("Ticket Information")?>
  </td>
</tr>
  
<tr>
  <td colspan="2" class="subTitle">
    <?=tr("Details")?>
  </td>
</tr>
  
<tr>
  <td class="bars">
    <?=tr("Project")?>
  </td>
  <td class="bars">
    <select name="project_id">
    <option value=''>--<?=tr("none")?>--</option>
    <?
    $bins = $zen->getUsersBins($login_id);
    if( is_array($bins) ) {
      $params = array("bin_id" => $bins, "status" => "OPEN");
      $projects = $zen->get_projects($params,'title');
    } 
    if( is_array($projects) ) {
      foreach($projects as $p) {
        $sel = ($p["id"] == $project_id)? " selected" : "";
        print "<option value='$p[id]'$sel>"
        .stripslashes($p["title"])."</option>\n";
      }
    }
    ?>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Title")?>
  </td>
  <td class="bars">
    <input type="text" name="title" size="30" maxlength="255"
      value="<?=strip_tags($title)?>">
  </td>
</tr>            
  
<tr>
  <td class="bars">
    <?=tr("Type")?>
  </td>
  <td class="bars">
    <select name="type_id">
<?
    if( is_array($zen->types) ) {
      foreach($zen->getTypes(1) as $v) {
     $k = $v["type_id"];
     if( $k != $zen->projectTypeID() ) {
        // does not allow projects to be created here
        // user must use the "new project" link for this
        // task
        $check = ( $k == $type_id )? "selected" : "";
        print "<option $check value='$k'>$v[name]</option>\n";
     }
  }
    } else {
      print "<option value=''>--".tr("none")."--</option>\n";
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
    <select name="system_id">
<?
    $systems = $zen->getSystems(1);
    if( is_array($systems) ) {
      foreach($systems as $v) {
	$k = $v["sid"];
	$v = $v["name"];
	$sel = ( $k == $system_id )? " selected" : "";     
	print "<option value='$k'$sel>$v</option>\n";
      }
    } else {
      print "<option value=''>--".tr("none")."--</option>\n";
    }
?>
    </select>
  </td>
</tr>
<tr>
  <td class="bars" width="125">
    <?=tr("Owner")?>
  </td>
  <td class="bars" width="515">
    <select name="user_id">
      <option value=''>--<?=tr("n/a")?>--</option>
<?
   if( is_array($users) && $zen->settings["allow_assign"] == "on" ) {
     foreach($users as $v) {
       $check = ( $v["user_id"] == $user_id )? "selected" : "";
       print "<option $check value='$v[user_id]'>".$zen->formatName($v,1)
  ."</option>\n";
     }
   }
?>
    </select>&nbsp;(optional)
  </td>
</tr>          
<tr>
  <td class="bars">
    <?=tr("Bin")?>
  </td>
  <td class="bars">
    <select name="bin_id">
<?
   if( is_array($userBins) && count($userBins) ) {
      foreach($zen->getBins(1) as $v) {
         $k = $v["bid"];
         
         if(in_array($k, $userBins)) {
            $check = ($k == $bin_id || (!$bin_id && !$td && $k == $login_bin))? "selected" : "";
            print "<option $check value='$k'>$v[name]</option>";
         }
      }
   } else {
      print "<option value=''>--".tr("none")."--</option>\n";
   }
?>
    </select>
  </td>
</tr>          
<tr>
  <td class="bars">
    <?=tr("Related Tickets")?>
  </td>
  <td class="bars">
    <input type="text" name="relations" size="20" maxlength="255"
value="<?=strip_tags($relations)?>">
    &nbsp;<input type='button' class='searchbox' value=' ... ' 
	onClick='popupWindowScrolls("<?=$rootUrl?>/helpers/ticketSearchbox.php?return_form=ticketForm&return_field=relations","popupHelper",375,500)'>

  <br>(<?=tr("Enter multiple ids, separated by a comma")?>)
  </td>
</tr>          

<tr>
  <td colspan="2" class="subtitle">
    <?=tr("Requirements")?>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Priority")?>
  </td>
  <td class="bars">
    <select name="priority">
<?
    if( is_array($zen->priorities) ) {
      foreach($zen->getPriorities(1) as $v) {
     $k = $v["pid"];
     $v = $v["name"];
     $check = ( $k == $priority )? "selected" : "";
     print "<option $check value='$k'>$v</option>\n";
  }
    } else {
      print "<option value=''>--".tr("none")."--</option>\n";
    }
?>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Start Date")?>
  </td>
  <td class="bars">
    <input type="text" name="start_date" size="12" maxlength="10"
value="<?=($start_date)?$zen->showDate(strip_tags($start_date)):""?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
  onClick="popUpCalendar(this,document.ticketForm.start_date, '<?=$zen->popupDateFormat()?>')"
  alt="Select a Date">
    &nbsp;(<?=tr("optional")?>)
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Estimated Hours to Complete")?>
  </td>
  <td class="bars">
    <input type="text" name="est_hours" size="12" maxlength="10"
value="<?=strip_tags($est_hours)?>">&nbsp;(<?=tr("up to two decimal places, optional")?>)
  </td>
</tr>
<tr>
  <td class="bars">
    <?=tr("Deadline")?>
  </td>
  <td class="bars">
    <input type="text" name="deadline" size="12" maxlength="10"
value="<?=($deadline)?$zen->showDate(strip_tags($deadline)):""?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
  onClick="popUpCalendar(this, document.ticketForm.deadline, '<?=$zen->popupDateFormat()?>')"
  alt="Select a Date">
    &nbsp;(<?=tr("optional")?>)
  </td>
</tr>          

<tr>
  <td class="bars">
    <?=tr("Testing Required")?>
  </td>
  <td class="bars">
  <? if( $td ) { ?>
    <select name='tested'>
      <option value='0' <?=$ticket['tested'] == 0? ' selected':''?>><?=tr('n/a')?></option>
      <option value='1' <?=$ticket['tested'] == 1? ' selected':''?>><?=tr('Required')?></option>
      <option value='2' <?=$ticket['tested'] == 2? ' selected':''?>><?=tr('Completed')?></option>
    </select>
  <? } else { ?>
    <input type="checkbox" name="tested" value="1" 
    <?= $zen->getDefaultValue("default_test_checked") ?>>
  <? } ?>
  </td>
</tr>   
<tr>
  <td class="bars">
    <?=tr("Approval Required")?>
  </td>
  <td class="bars">
  <? if( $td ) { ?>
    <select name='approved'>
      <option value='0' <?=$ticket['approved'] == 0? ' selected':''?>><?=tr('n/a')?></option>
      <option value='1' <?=$ticket['approved'] == 1? ' selected':''?>><?=tr('Required')?></option>
      <option value='2' <?=$ticket['approved'] == 2? ' selected':''?>><?=tr('Completed')?></option>
    </select>
  <? } else { ?>
    <input type="checkbox" name="approved" value="1" 
    <?= $zen->getDefaultValue("default_aprv_checked") ?>>
  <? } ?>
  </td>
</tr>

<?
 $varfields = $zen->getCustomFields(0,'Ticket', 'New');
 if( is_array($varfields) && count($varfields) ) {
?>
<tr>
  <td colspan="2" class="subtitle">
    <?=tr($zen->settings['varfield_tab_name'])." ".tr("Fields")?>
  </td>
</tr>
<?
    foreach($varfields as $v) {
      $k = $v['field_name'];
      $val = isset($$k)? $$k : $v['field_value'];
?>
<tr>
  <td class="bars">
   <?=tr($v['field_label'])?>
  </td>
  <td class="bars">
   <?= genVarfield( 'ticketForm', $v, $val ) ?>
  </td>
</tr>
<?
   }
 }
?>

 
<tr>
  <td colspan="2" class="subtitle">
    <?=tr("Description")?>
  </td>
</tr>
  
<tr>
  <td colspan="2">
    <textarea cols="60" rows="10" name="description"><?= 
   ereg_replace("&","&amp;",stripslashes($description)); 
    ?></textarea>
  </td>
</tr>
<tr>
  <td class="titleCell" colspan="2" align="center">
  <?=tr("Click button to")?> <?=($td)? tr("save your changes"):tr("create your ticket")?>.
  </td>
</tr>
<tr>
  <td colspan="2" class="bars">
   <input type="submit" value=" <?=tr(($td)?"Save":"Create")?> " class="submit">
  </td>
</tr>
</table>

<script language='Javascript' type='text/javascript'>

 function validateTicketForm() {
   var errs = new Array();
   if( !document.ticketForm.title.value ) {
     errs[ errs.length ] = "<?=tr("? is required",array( tr("Title") ))?>";
   }
   
<?
$varfields = $zen->getCustomFields(0,'Ticket', 'New');
if( is_array($varfields) && count($varfields) ) {
  foreach($varfields as $v) {
    $k = $v['field_name'];
    $l = $v['field_label'];
    if( $v['js_validation'] ) {
      print preg_replace('/\{form\}/', 'document.ticketForm', $v['js_validation']);
    }
    else {
      $f = "document.ticketForm.{$k}";
      $e = 'errs[ errs.length ]';
      switch( getVarfieldDataType($k) ) {
        case "menu":
        // if the value of the menu selection is '', then
        // the required status is significant
        if( $v['is_required'] ) {
          print "if( {$f}.options[ {$f}.selectedIndex ].value == '' )"
          . " { {$e} = '{$l} is required'; }\n";
        }
        case "boolean":
        // no validation for checkboxes
        break;
        case "number":
        // make sure it is a valid number
        print "if( {$f}.value.match( /[^0-9.]/ ) ) { {$e} = '"
        .tr('? is not a valid number',array(tr($l)))."'; }\n";
        default:
        // nothing to do for dates or strings, just
        // check the required status
        // numbers fall through to here also
        if( $v['is_required'] ) {
          print "if( !{$f}.value ) { {$e} = '"
          .tr('? is required',array(tr($l)))."'; }\n";
        }
      }
    }
  }
}
?>
   if( errs.length > 0 ) {
     var str = "<?=tr("Please correct the following errors:")?>\n----------\n";
     for( var i=0; i < errs.length; i++ ) {
       str += errs[i]+"\n";
     }
     alert(str);
     return false;
   }
   return true;
 }

</script>