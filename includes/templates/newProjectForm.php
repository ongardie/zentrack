<?	
  unset($userBins);
  unset($users);
  $userBins = $zen->getUsersBins($login_id,"level_create");
  if( is_array($userBins) ) {
    $users = $zen->get_users( $userBins, "level_user" );
  } else {
    print "<span class='error'>You do not have permission to create projects.</span>\n";
    include("$libDir/footer.php");
    exit;
  }
  $td = ($TODO == 'EDIT');
  if( !$deadline && !$td )
     $deadline = $zen->getDefaultValue("default_deadline");
  if( !$start_date && !$td )
     $start_date = $zen->getDefaultValue("default_start_date");
?>     

<form method="post" name="newProjectForm" action="<?=($td)? "editProjectSubmit.php" : "$rootUrl/addProjectSubmit.php"?>">
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
    $systems = $zen->getSystems(1);
    if( is_array($systems) ) {
    	foreach($systems as $v) {
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
/*
    if( is_array($users) ) {
        foreach($users as $k=>$v) {
           $check = ( $k == $user_id )? "selected" : "";
           print "<option $check value='$k'>$v[lname], $v[fname]</option>\n";
        }
    }
*/
?>
<?
   /* PTA : 1/25/2003 5:48 PM CST : Bug 673258
    * ----------------------------------------
    * The above logic was assuming that the user_id's were always going to be
    * sequential as the "key" is just going to 0,1,2...N while the user_ids 
    * can be out of order if users are deleted from the Admin interface.
    */
    if( is_array($users) ) {
       asort($users);
       foreach($users as $usr) {
         $check = ( $usr["user_id"] == $login_id )? "selected" : "";
         print "<option $check value='";
         print $usr["user_id"]."'>";
         print $usr["lname"].", ".$usr["fname"];
         print "</option>\n";
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
    	foreach($userBins as $k) {
	   $check = ( $k == $bin_id || (!$bin_id && !$td && $k == $login_bin) )? 
		"selected" : "";
	   print "<option $check value='$k'>".$zen->bins["$k"]."</option>\n";
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
    Start Date
  </td>
  <td class="bars">
    <input type="text" name="start_date" size="12" maxlength="10"
	value="<?=($start_date)?$zen->showDate(strip_tags($start_date)):""?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
	onClick="popUpCalendar(this,document.newProjectForm.start_date, 'mm/dd/yyyy')"
	alt="Select a Date">
    &nbsp;(optional)
  </td>
</tr>
<tr>
  <td class="bars">
    Deadline
  </td>
  <td class="bars">
    <input type="text" name="deadline" size="12" maxlength="10"
value="<?=($deadline)?$zen->showDate(strip_tags($deadline)):""?>">
    <img name="date_button" src='<?=$rootUrl?>/images/cal.gif' 
	onClick="popUpCalendar(this,document.newProjectForm.deadline, 'mm/dd/yyyy')"
	alt="Select a Date">
    &nbsp;(optional)
  </td>
</tr>				   
<tr>
  <td class="bars">
    Testing Required
  </td>
  <td class="bars">
    <input type="checkbox" name="tested" value="1" 
  <?= $zen->getDefaultValue("default_tested_checked"); ?>>
  </td>
</tr>				   
<tr>
  <td class="bars">
    Approval Required
  </td>
  <td class="bars">
    <input type="checkbox" name="approved" value="1" 
    <?= $zen->getDefaultValue("default_aprv_checked"); ?>>
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
