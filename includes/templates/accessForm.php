<?

  // determine what bins we are working with
  // and create a list of bins and their
  // access levels
  if( $TODO == 'MORE' || $TODO == 'LESS' ) {
    $n = ($more < 4)? 2 : 4;
    $more += ($TODO == 'MORE')? $n : -$n;
    unset($bins);
    if( is_array($binLevels) ) {
      ksort($binLevels);
      foreach($binLevels as $k=>$v) {
	if( strlen($v) && $k ) {
	  $bins["$k"] = $v;
	}
      }
    }
    for( $i=0; $i<count($newFields); $i++ ) {
      $k = $newFields[$i];
      if( strlen($newVals[$i]) && $k )
	$bins["$k"] = $newVals[$i];
    }
  } else {
    $bins = $zen->get_access($uid);
  }

  if( $TODO == 'Reset' )
     $more = 0;

  // fetch a list of bins for new bins
  $userBins = $zen->getUsersBins($login_id);

  // set up the more links
  if( $more >= 12 )
    $more = 12;
  if( $more < 0 )
    $more = 0;

  function opts( $selected = '' ) {
    print "<option value=''>---</option>\n";
    for( $i=0; $i<6; $i++ ) {
      print (strlen($selected) && $i==$selected)? 
	"<option selected>$i</option>\n" :
	"<option>$i</option>\n";
    }
  }

?>

<form method="post" action="<?=$SCRIPT_NAME?>">
<input type="hidden" name="more" value="<?= strip_tags($more) ?>">
<input type="hidden" name="uid" value="<?= strip_tags($uid) ?>">
<blockquote>
<table width="300" cellpadding="5">
<tr>
  <td colspan="2" class="titleCell" align="center" height="20">
    <b>Set Access for <?=$zen->formatName($uid)?></b>
  </td>
</tr>

<?
  if( is_array($bins) && count($bins) ) {
    foreach($bins as $k=>$v) {
      print "<tr><td><b>".$zen->bins["$k"]."</b></td>";
      print "<td><select name='binLevels[$k]'>\n";
      opts($v);
      print "</select></td></tr>\n";
    }
  }
  for( $i=0; $i<$more; $i++ ) {
    print "<tr><td><select name='newFields[]'>\n";
    print "<option value=''>-------</option>\n";
    foreach($userBins as $v) {
      print "<option value='$v'>".$zen->bins["$v"]."</option>\n";
    }
    print "</select></td>\n";
    print "<td><select name='newVals[]'>\n";
    opts();
    print "</select></td></tr>\n";
  }
?>

<tr>
  <td class="titleCell" colspan="2">
    Press MORE to add more custom fields
    <br>
    Press LESS to remove blank fields
    <br>
    Press Update to save changes
    <br>
    Press Reset to return to users existing values
  </td>
</tr>
<tr>
  <td class="bars" colspan="2">
    <input type="submit" name="TODO" value="MORE">
   &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="TODO" value="LESS">
   &nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="TODO" value="Update" class="submit">
    &nbsp;&nbsp;&nbsp;&nbsp;
   <input type="submit" name="TODO" value="Reset" class="submit">
  </td>
</tr>
</table>
</blockquote>

</form>
