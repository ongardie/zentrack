<?{
  /**
   * creates a form for adding entries to the
   * ticket notify list
   */
}?>
<form method='post' action='<?=$zen->ffv($SCRIPT_NAME)?>' name='notifyAddForm'>
<input type='hidden' name='id' value='<?=$zen->ffv($id)?>'>
<input type='hidden' name='actionComplete' value='1'>

<table width="550" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold">Add Notify Recipient</span>
   <br>
   <span class="small">Add recipients to the notify list for this ticket</span>
 </td>
</tr>
<tr>
  <td class="titleCell">
     Enter registered users
  </td>
</tr>
<tr>
  <td>
<?
  // make a user textarea and search button
  print "<textarea cols='20' rows='4' name='user_accts'>\n";
  print (isset($user_accts))? $zen->ffv($user_accts) : "";
  print "</textarea>\n";
  $onclick = "onClick='return popupWindowScrolls"
    ."(\"$rootUrl/helpers/userSearchbox.php?return_form=notifyAddForm"
    ."&return_field=user_accts\",\"popupHelper\",375,400)'";
  print "&nbsp;<input type='button' class='searchbox' "
    ." value=' ... ' $onclick>\n";
  print "<br><span class='note'>Type ids separated by "
  ."commas, or click on the button.</span>\n";
?>
  </td>
</tr>
<tr>
  <td class="titleCell">
     Or add an unregistered user
  </td>
</tr>
<tr>
  <td class='subTitle'>
    Name
  </td>
</tr>
<tr>
  <td>
    <input type='text' name='unreg_name' size='20' maxlength='255' 
           value='<?=$zen->ffv($unreg_name)?>'>
  </td>
</tr>
<tr>
  <td class='subTitle'>
    Email
  </td>
</tr>
<tr>
  <td>
    <input type='text' name='unreg_email' size='20' maxlength='255' 
           value='<?=$zen->ffv($unreg_email)?>'>
  </td>
</tr>
<tr>
  <td class="titleCell">
    Click button to add recipients
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" Add " class="submit">
  </td>
</tr>
<tr>
</table>



</form>
