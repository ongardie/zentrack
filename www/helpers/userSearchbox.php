<?
  include("../header.php");
  $table_width = '350';
  if( is_array($search_bins) && count($search_bins)==1 && $search_bins[0] == "" )
     unset($search_bins);
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

<? if( !isset($dosearch) || !is_array($search_param) ) { ?>
<form method='post' action='<?=$rootUrl?>/helpers/userSearchbox.php'>
<input type='hidden' name='return_form' value='<?=$zen->ffv($return_form)?>'>
<input type='hidden' name='return_field' value='<?=$zen->ffv($return_field)?>'>
<table width='<?=$table_width?>' align='center'>
<tr><td class='titleCell' align='center' colspan='2'>Search Users</td></tr>
<tr>
  <td class='bars'>User ID</td>
  <td class='bars'><input type='text' name='search_param[user_id]' size='12' 
	maxlength='10' value='<?=$zen->ffv($search_param["user_id"])?>'></td>
</tr>
<tr>
  <td class='bars'>Last Name</td>
  <td class='bars'><input type='text' name='search_param[lname]' 
	size='22' maxlength='20' value='<?=$zen->ffv($search_param["lname"])?>'><td>
</tr>
<tr>
  <td class='bars'>First Name</td>
  <td class='bars'><input type='text' name='search_param[fname]' 
	size='22' maxlength='20' value='<?=$zen->ffv($search_param["fname"])?>'></td>
</tr>
<tr>
  <td class='bars'>Home Bin</td>
  <td class='bars'>
    <select name="search_bins[]" size='5' multiple>
<?
   $userBins = $zen->getUsersBins($login_id);
   if( is_array($userBins) ) {
     foreach($userBins as $k=>$v) {
       if( $k ) {
         $check = (is_array($search_bins)&&in_array($k,$search_bins) )? 
	   "selected" : "";
         $n = $zen->bins["$k"];
         print "<option $check value='$k'>$n</option>\n";
          }
     }
   } else {
     print "<option value=''>--no bins--</option>\n";
   }
?>
    </select>
    <div class='note'>Select more than one by using control or shift</div>
  </td>
</tr>
<tr>
  <td class='bars' colspan='2'>
    <div align='center'><input type='submit' class='submit' name='dosearch'
	 value='Search'></div>
    <span class='note'>You may use * for a wildcard in any field but 
	the id.. i.e. J* would match anything starting with J</span>
  </td>
</table>

<? 
  } else { 
    
  $params = array();
  foreach($search_param as $k=>$v) {
    if( (is_array($v) && !count($v)) || (!is_array($v)&&!strlen(trim($v))) )
	continue; 
    if( $k == "homebin" ) {
      $params["homebin"] = array($k,"IN",preg_replace("@[^0-9,]@", "",join(",",$v)));
      $params["homebin"][2] = preg_replace("@[^0-9]+@", ",", $params["homebin"][2]);
    } else {
      $v = strip_tags(trim($v));
      $v = preg_replace("@[*]@", "%", $v);
      $k = $zen->checkAlphaNum($k);
      if( !strlen($v) )
	continue;
      if( $k == "user_id" ) {
	$params = array();
	$results = array($zen->get_user($v));
	break;
      } else {
	$params["$k"] = (strpos($v,"%")>-1)? array($k,"LIKE",$v) : array($k,"=",$v);
      }
    }
  }
  if( count($params)>0 ) {
    $results = $zen->search_users($params);    
  }

?>
<script language='javascript'>
   var curcheck = false;
   function checkAll() {
     var i;
     for(i=0; i<document.helperForm.elements.length; i++) {
       element = document.helperForm.elements[i];
       if( element.type == "checkbox" ) {
	 if( curcheck == false ) {
	   element.checked = true;
	 }
	 else {
	   element.checked = false;
	 }
       }     
     }
     curcheck = (curcheck == false)? true : false;
   }

   function saveValues() {
     var i;
     var val = "";
     for(i=0; i<document.helperForm.elements.length; i++) {
       element = document.helperForm.elements[i];
       if( element.type == "checkbox" && element.checked == true && element.value != "skip" ) {
	 if( val == "" )
	   val = element.value;
	 else
	   val += ","+element.value;
       } 
     }
     opener.document.<?=$return_form?>.<?=$return_field?>.value = val;
     window.self.close();
     return false;
   }
</script>

<form action='<?=$rootUrl?>/helpers/userSearchbox.php' method='post' 
    name='helperForm'>
<?
  $zen->hiddenField("return_form",$return_form);
  $zen->hiddenField("return_field",$return_field);

  foreach($search_param as $k=>$v) {
    if( $k == "homebin" )
       $k = "search_bins";
    else
       $k = "search_param[$k]";
    $zen->hiddenField($k,$v);
  }
?>
<table width='<?=$table_width?>' align='center'>
<tr>
  <td class='titleCell' align='center' colspan='4'>Select Users</td>
</tr>
<tr>
  <td class='bars' colspan='4' align='center'>
     <input type='button' 
      class='submit' value='Select' <?=(is_array($results))?
	"onClick='return saveValues()'":""?>>
   &nbsp;&nbsp;&nbsp;&nbsp;
    <input type='submit' class='submit' value='Modify Search'>
  </td>
</tr>
<?
 if( is_array($results) && count($results) ) {
?>
<tr>
  <td class='subTitle'>
    <input type='checkbox' name='allcheck' value='skip' onClick='checkAll()' class='searchbox'>
  </td>
  <td class='subTitle'>
    ID
  </td>
  <td class='subTitle'>
    Name
  </td>
  <td class='subTitle'>
    Bin
  </td>
<?
   $i=0;
   foreach($results as $r) {
     $row = ($row == "cell")? "bars" : "cell";
     print "<tr>\n";
     print "\t<td class='$row'><input type='checkbox' name='values[$i]' "
       ." value='{$r['user_id']}'></td>\n";
     print "\t<td class='$row'>{$r['user_id']}</td>\n";
     print "\t<td class='$row'>".$zen->formatName($r,1)."</td>\n";
     print "\t<td class='$row'>".$zen->getBinName($r['homebin'])."</td>\n";
     print "</tr>\n";
     $i++;
   }
 } else {
?>
<tr>
<td colspan='4' class='bars'>There were no results for your search</td>
</tr>
<?
 }
?>
<tr>
<td>

</table>
</form>

<? } ?>

