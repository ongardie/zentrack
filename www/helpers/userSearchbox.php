<?
  include("./reports_header.php");
  $table_width = '350';
  if( $search_bins ) {
    $search_param["homebin"] = $search_bins;
  }
?><html>
<head>
  <title>Search Users</title>
  <LINK HREF="<?=$rootUrl?>/styles.php" REL="STYLESHEET" TYPE="text/css">
  <script language="javascript" src="<?=$rootUrl?>/javascript.js"></script>
</head>
<body>

<? if( !$isset($dosearch) || !is_array($search_param) ) { ?>
<form method='post' action='<?=$rootUrl?>/reports/userSearchBox.php'>
<input type='hidden' name='return_form' value='<?=$zen->ffv($return_form)?>'>
<input type='hidden' name='return_field' value='<?=$zen->ffv($return_field)?>'>
<table width='<?=$table_width?>'>
<tr><td class='titleCell' align='center' colspan='2'>Search Users</td></tr>
<tr>
  <td class='cell'>User ID</td>
  <td class='cell'><input type='text' name='search_param[id]' size='12' 
	maxlength='10' value='<?=$zen->ffv($search_param["id"])?>'></td>
</tr>
<tr>
  <td class='cell'>Last Name</td>
  <td class='cell'><input type='text' name='search_param[lname]' 
	size='22' maxlength='20' value='<?=$zen->ffv($search_param["lname"])?>'><td>
</tr>
<tr>
  <td class='cell'>First Name</td>
  <td class='cell'><input type='text' name='search_param[fname]' 
	size='22' maxlength='20' value='<?=$zen->ffv($search_param["fname"])?>'></td>
</tr>
<tr>
  <td class='cell'>Home Bin</td>
  <td class='cell'>
    <select name="search_bins[]" size='5' multiple>
       <option value="">----</option>
<?
   $userBins = $zen->getUsersBins($login_id);
   if( is_array($userBins) ) {
     foreach($userBins as $k=>$v) {
       if( $k ) {
         $check = ( in_array($k,$search_bins) )? "selected" : "";
         $n = $zen->bins["$k"];
         print "<option $check value='$k'>$n</option>\n";
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
  <td class='cell' colspan='2'>
    <span class='note'>You may use * for a wildcard.. i.e. "J*" 
		 would match anything starting with J</span>
    <div align='center'><input type='submit' value='Search'></div>
  </td>
</table>

<? 
  } else { 
    
  $params = array();
  foreach($search_param as $k=>$v) {
    $v = strip_tags($v);
    $v = preg_replace("@[*]@", "%", $v);
    $k = $zen->checkAlphaNum($k);
    if( $k == "homebin" ) {
      $params["homebin"] = array("=",$v);
    } else if( $k == "user_id" ) {
      $params = array();
      $results = array($zen->get_user($v));
      break;
    } else {
      $params["$k"] = (str_pos("%",$v)>-1)? array("LIKE",$v) : array("=",$v);
    }
  }
  if( count($params)>0 ) {
    $results = $zen->search_users($params);    
  }

?>
<form action='<?=$rootUrl?>/helpers/userSearchbox.php' method='post' name='helperForm'>
<table width='<?=$table_width?>'>
<tr>
  <td class='titleCell' align='center' colspan='4'>Select Users</td>
</tr>
<tr>
  <td class='cell' colspan='2' align='center'>
     <input type='<?=(is_array($results))?"submit":"button"?>' 
      class='submit' value='Select' onClick='return saveValues()'>
  </td>
  <td class='cell' colspan='2' align='center'>
    <input type='submit' class='submit' name='dosearch' value='Modify Search'>
  </td>
</tr>
<?
 if( is_array($results) && count($results) ) {
?>
<tr>
  <td class='cell'>
    &nbsp;
  </td>
  <td class='cell'>
    ID
  </td>
  <td class='cell'>
    Name
  </td>
  <td class='cell'>
    Bin
  </td>
<?
   $i=0;
   foreach($results as $r) {
     $row = ($row == "cell")? "bars" : "cell";
     print "<tr>\n";
     $sel = (in_array($r["user_id"],$searchvals))? " checked":"";
     print "\t<td class='$row'><input type='checkbox' name='values[$i]' "
       ." value='{$r['user_id']}'$sel></td>\n";
     print "\t<td class='$row'>{$r['user_id']}</td>\n";
     print "\t<td class='$row'>".$zen->formatName($r,1)."</td>\n";
     print "\t<td class='$row'>".$zen->getBinName($r['homebin'])."</td>\n";
     print "<\tr>\n";
     $i++;
   }
 } else {
?>
<tr>
<td colspan='4' class='cell'>There were no results for your search</td>
</tr>
<?
 }
?>
<tr>
<td>

<? } ?>
</table>
</form>
<script name=javascript>
<!--
function setVals(newvalue) {
  opener.document.addForm.pic.value = newvalue;
  window.self.close();
}
//-->
</script>
<script language='javascript'>
   function saveValues() {
     var i;
     var val = "";
     for(i=0; i<document.helperForm.elements.length; i++) {
       element = document.helperForm.elements[i];
       if( element.type == "checkbox" && element.checked == true ) {
	 if( val == "" )
	   val = element.value;
	 else
	   val += ","+element.value;
       } 
       else {
	 alert("element type: "+element.type);
       }
     }
     opener.document.<?=$return_form?>.<?=$return_field?>.value = val;
     window.self.close();
     return false;
   }
</script>

<? } ?>








