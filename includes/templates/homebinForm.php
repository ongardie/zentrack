
<form method="post" action="<?=$SCRIPT_NAME?>">

<blockquote>
<table width="300" cellpadding="5">
<tr>
  <td colspan="2" class="titleCell" align="center" height="20">
    <b><?=tr("Change Your Default Bin")?></b>
  </td>
</tr>
<tr>
  <td class="bars">
    <b><?=tr("New Default Bin")?></b>
  </td>
  <td class="bars">
    <select name="homebin">
<?
  $userBins = $zen->getUsersBins($login_id);
  $user = $zen->getUser($login_id);
  $homebin= $user["homebin"];
  $check = ($homebin == -1)?"selected":"";
  
  //print "<option $check value='all'>-All-</option>\n";
  if( is_array($userBins) ) {
    foreach($userBins as $k=>$v) {
      if( $v ) {
        $check = ( $v == $homebin )? "selected" : "";
        $n = $zen->bins["$v"];
        print "<option $check value='$v'>$n</option>\n";
      }
    }
  }
?>
    </select>
  </td>
</tr>
<tr>
  <td class="titleCell" colspan="2">
    <?=tr("Click 'Update' to change your default bin")?>
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
    <input type="submit" value="<?=tr("Update")?>" class="submit">
  </td>
</tr>
</table>
</blockquote>

<input type="hidden" name="TODO" value="BIN">
</form>


