
<form enctype="multipart/form-data" action="<?=$SCRIPT_NAME?>" method="post">
  <input type="hidden" name="MAX_FILE_SIZE" value="<?=$zen->settings["attachment_max_size"]?>">
  <input type="hidden" name="id" value="<?=$id?>">
  <input type="hidden" name="logID" value="<?=strip_tags($logID)?>">
  <input type="hidden" name="actionComplete" value="1">

<ul>
<table width="450" cellpadding="4" cellspacing="1" border="0">
<tr>
 <td>
   <span class="bigBold">UPLOAD ATTACHMENT</span>
   <br>
   <span class="small">(create an attachment for this ticket)</span>
 </td>
</tr>
<tr>
 <td class="titleCell">
   Select a file to upload
 </td>
</tr>
<tr>
 <td>
   <input type="file" name="userfile" size="40">
 </td>			     
</tr>
<tr>
  <td class="titleCell">
     Description of Attachment <span class="small">(optional)</span>
  </td>
</tr>
<tr>
  <td>
    <textarea cols="50" rows="4" name="comments"><?=
      strip_tags(stripslashes($comments))?></textarea>
  </td>
</tr>
<tr>
  <td class="titleCell">
    Click button to upload file and attach to ticket
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value=" ATTACH " class="submit">
  </td>
</tr>
<tr>
</table>
</ul>

</form>			     
