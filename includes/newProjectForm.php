<?	
  unset($userBins);
  unset($users);
  foreach($zen->bins as $k=>$v) {
     $zen->getAccess($login_id);
     if( (isset($zen->access["$k"]) && $zen->access["$k"] >= $zen->settings["level_view"])
	||
	(!isset($zen->access["$k"]) && $login_level >= $zen->settings["level_view"])
	) {
	$userBins["$k"] = $v;
    }
  }
  if( is_array($userBins) ) {
     foreach($userBins as $k=>$b) {
	$vars = $zen->get_users($k);
	for( $i=0;$i<count($vars);$i++ ) {
	   $n = $vars[$i]["user_id"];
	   $users["$n"] = $vars[$i];
	}
     }  
     asort($userBins);
     asort($users);
  }
?>     

<form method="post" action="<?=($TODO=='EDIT')? "$rootUrl/actions/editProjectSubmit.php" : "$rootUrl/addProjectSubmit.php"?>">
<input type="hidden" name="id" value="<?=strip_tags($id)?>">
  
<table width="640" align="left" cellpadding="2" cellspacing="2" bgcolor="<?=$zen->settings["color_background"]?>">
<tr>
  <td colspan="2" width="640" class="titleCell" align="center">
     Enter Project Information
  </td>
</tr>
  
<tr>
  <td colspan="2" class="subTitle">
    Details
  </td>
</tr>

  <tr>
  <td class="bars">
    Master Project
  </td>
  <td class="bars">
    <select name="project_id">
    <option value=''>--none--</option>
    <?
      $bins = $zen->getUsersBins($login_id);
      if( is_array($bins) ) {
	 $params["bin_id"] = $bins;
	 $params["status"] = "OPEN";
	 $projects = $zen->get_projects($params,title);
      } 
      if( is_array($projects) ) {
	 foreach($projects as $p) {
	    $sel = ($p["id"] == $project_id)? " selected" : "";
	    print "<option value='$p[id]'$sel>".stripslashes($p["title"])."</option>\n";
	 }
      }
    ?>
    </select>
  </td>
</tr>
 
<tr>
  <td class="bars">
    Title
  </td>
  <td class="bars">
    <input type="text" name="title" size="30" maxlength="255"
value="<?=strip_tags($title)?>">
  </td>
</tr>
<tr>
  <td class="bars">
    System
  </td>
  <td class="bars">
    <select name="system_id">
<?
    if( is_array($zen->systems) ) {
    	foreach($zen->getSystems(1) as $v) {
	   $k = $v["sid"];
	   $v = $v["name"];
	   $check = ( $k == $system_id )? "selected" : "";	   
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
  <td>
<tr>
  <td class="bars" width="125">
    Owner
  </td>
  <td class="bars" width="515">
    <select name="user_id">
      <option value=''>--not assigned--</option>
<?
    if( is_array($users) ) {
    	foreach($users as $k=>$v) {
	   $check = ( $k == $user_id )? "selected" : "";
	   print "<option $check value='$k'>$v[lname], $v[fname]</option>\n";
	}
    }
?>
    </select>&nbsp;(optional)
  </td>
</tr>				   
<tr>
  <td class="bars">
    Bin
  </td>
  <td class="bars">
    <select name="bin_id">
<?
    if( is_array($userBins) ) {
    	foreach($userBins as $k=>$v) {
	   $check = ( $k == $bin_id )? "selected" : "";
	   print "<option $check value='$k'>$v</option>\n";
	}
    } else {
      print "<option value=''>--no bins--</option>\n";
    }
?>
    </select>
  </td>
</tr>				   
<tr>
  <td colspan="2" class="subtitle">
    Requirements
  </td>
</tr>
<tr>
  <td class="bars">
    Priority
  </td>
  <td class="bars">
    <select name="priority">
<?
    if( is_array($zen->getPriorities(1)) ) {
    	foreach($zen->getPriorities(1) as $v) {
	   $k = $v["pid"];
	   $v = $v["name"];
	   $check = ( $k == $priority )? "selected" : "";
	   print "<option $check value='$k'>$v</option>\n";
	}
    } else {
      print "<option value=''>--no priorities--</option>\n";
    }
?>
    </select>
  </td>
</tr>
<tr>
  <td class="bars">
    Deadline
  </td>
  <td class="bars">
    <input type="text" name="deadline" size="12" maxlength="10"
value="<?=$zen->showDate(strip_tags($deadline))?>">&nbsp;(mm/dd/yyyy)
  </td>
</tr>				   
<tr>
  <td class="bars">
    Testing Required
  </td>
  <td class="bars">
    <input type="checkbox" name="tested" value="1" 
  <?
    if( $tested || (!strlen($tested) && $zen->settings["default_test_checked"] == "on") ) {
       print "checked";
    }
  ?>>
  </td>
</tr>				   
<tr>
  <td class="bars">
    Approval Required
  </td>
  <td class="bars">
    <input type="checkbox" name="approved" value="1" 
    <?
    if( $approved || (!strlen($approved) && $zen->settings["default_approve_checked"] == "on") ) {
       print "checked";
    }  
  ?>>
  </td>
</tr>
  
<tr>
  <td colspan="2" class="subtitle">
    Description
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
  Click button to <?=($TODO=='EDIT')? "save your changes":"create your ticket."?>
  </td>
</tr>
<tr>
  <td colspan="2" class="bars">
   <input type="submit" value=" <?=($TODO=='EDIT')?"Save":"Create"?> " class="submit">
  </td>
</tr>
</table>
