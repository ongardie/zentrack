<?{
if( !ZT_DEFINED ) { die("Illegal Access"); }

  /**
   * creates a form for adding entries to the
   * ticket notify list
   */
}?>
<script type="text/javascript">
function printpopup(variable)
{
  location.href ="<?=$zen->ffv($SCRIPT_NAME)."?id=".$id ?>&company_id="+variable+"&setmode=<?=$zen->ffv($page_mode)?>";
}
</script>

<form method='post' action='<?=$zen->ffv($SCRIPT_NAME)?>' name='notifyAddForm'>
<input type='hidden' name='id' value='<?=$zen->ffv($id)?>'>
<input type='hidden' name='actionComplete' value='1'>
<input type='hidden' name='setmode' value='<?=$zen->ffv($page_mode)?>'>

<table width="600" class='formtable' cellpadding="4" cellspacing="1" border="0">
<tr>
 <td class='subTitle' colspan='2'>
   <?=tr("Add Notify Recipients")?>
 </td>
</tr>
<tr>
  <td class="bars bold">
     <?=$hotkeys->ll("Enter Registered Users")?>
  </td>
</tr>
<tr>
  <td class='bars'>
<?
  $templateVars = array(
    'field_name'   => 'user_accts',
    'field_cols'   => '20',
    'field_max'    => '9999',
    'search_mode'  => 'user',
    'search_type'  => '',
    'form_name'    => 'notifyAddForm',
    'search_multi' => '1',
    'search_text'  => ''
  );
  $template = new ZenTemplate("$templateDir/fields/searchbox.template");
  $template->values( $templateVars );
  print $template->process();
  if( $user_accts ) {
    $vals = explode(',', $user_accts);
    print "<script>";
    foreach($vals as $v) {
      $uname = $zen->formatName($v);
      print "addSearchboxVal('notifyAddForm', 'user_accts', '$v', '$uname', true, false);\n";
    }
    print "</script";
  }
?>
  </td>
</tr>
<tr>
  <td class="bars bold">
     <?=$hotkeys->ll("Add an Unregistered User")?>
  </td>
</tr>
<tr>
  <td class='bars'>
    <table>
    <tr>
      <td class='bars'>
        <?=tr("Name")?>
      </td>
      <td class='bars'>
        <input type='text' name='unreg_name' size='20' maxlength='255' 
               value='<?=$zen->ffv($unreg_name)?>'>
      </td>
      <td class='bars'>
        <?=tr("Email")?>
      </td>
      <td class='bars'>
        <input type='text' name='unreg_email' size='20' maxlength='255' 
               value='<?=$zen->ffv($unreg_email)?>'>
      </td>
    </tr>
    </table>
  </td>
</tr>
  <? if( $zen->settingOn('allow_contacts') ) { ?>
<tr>
  <td class="bars bold">
     <?=$hotkeys->ll("Add a Contact")?>
  </td>
</tr>
<tr>
<td class='bars'>
<br>
<?
  $company = $zen->get_contact_all();
  if (is_array($company)||count($company)) {
    print tr("Company:");
?>

  <select name="company_id" onChange="printpopup(document.forms['notifyAddForm'].company_id.value)">
    <option value=''>--<?=tr("none")?>--</option>
<?
   foreach($company as $p) {
      $sel = ($p["company_id"] == $company_id)? " selected" : "";
      $val =($p['office'])? strtoupper($p['title']) . " ," 
            . $p['office'] : strtoupper($p['title']);
      print "<option value='$p[company_id]' $sel>".$zen->ffv($val)."</option>\n";
    }
?>
  </select>
<?
  }
  if (empty($company_id)) {
    $parms = array(array("company_id", "=", "0"));
  } else {
    $parms = array(array("company_id", "=", $company_id));
  }
	
  $sort = "lname asc";
  $employee = $zen->get_contacts($parms,"ZENTRACK_EMPLOYEE",$sort);
	
  if (is_array($employee)||count($employee)) {
    echo "&nbsp;". tr("Or Person:");
?>
    <select name="person_id">
      <option value=''>--<?=tr("none")?>--</option>
	<?
	  foreach($employee as $p) {
            $val =($p['fname'])?ucfirst($p[lname])." ,".ucfirst($p[fname]):ucfirst($p[lname]);
	    print "<option value='$p[person_id]' >".$zen->ffv($val)."</option>\n";
          }
	?>
    </select>
    <br><br>
<?
  } //if( is_array($company).. )
  
  if( !$employee && !$company ) {
    print tr("No contacts found");
  }
  
  
  } //if( $zen->getSetting('allow_contacts')... )
?>
	
</td>
</tr>
<tr>
  <td class="subTitle">
  <? renderDivButtonFind('Add Recipients'); ?>
  </td>
</tr>
<tr>
</table>



</form>
