<?
  
if( is_array($users) && count($users) ) {
 
   $c = count($users);
      ?>
        <table width="100%" cellspacing='1' cellpadding='2' bgcolor='<?=$zen->settings["color_alt_background"]?>'>
        <tr><td class='titleCell' colspan="8" align='center'><?=($c>1)? "$c Matches" : "1 Match";?></td></tr>
	<tr bgcolor="<?=$zen->settings["color_title_background"]?>">
	<td width="32" height="25" valign="middle" title="Users System ID">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("ID")?></span></b></span></div>
	</td>
	<td height="25" valign="middle" title="The name of the user">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
	     <b><span class="small"><?=$zen->prn("Name")?></span></b></span></div>
	</td>
	<td height="25" valign="middle" title="Users Initials">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
	     <b><span class="small"><?=$zen->prn("Initials")?></span></b></span></div>
	</td>
	<td width="32" height="25" valign="middle" title="Default Access Level">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>"><b><span class="small"><?=$zen->prn("Access")?></span></b></span></div>
	</td>
	<td height="25" valign="middle" title="The name of the user">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
	     <b><span class="small"><?=$zen->prn("Email")?></span></b></span></div>
	</td>
	  <td width="32" height="25" valign="middle" title="Account is Active">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
             <b><span class="small"><?=$zen->prn("Active")?></span></b></span></div>
	  </td>
	  <td width="32" height="25" valign="middle" title="Users Default Bin">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
             <b><span class="small"><?=$zen->prn("Home")?></span></b></span></div>
	  </td>
	  <td width="32" height="25" valign="middle" title="Administrative Options">
	  <div align="center"><span style="color:<?=$zen->settings["color_title_txt"]?>">
             <b><span class="small"><?=$zen->prn("Options")?></span></b></span></div>
	  </td>
	</tr>
      <?      

   $text = $zen->settings["color_bar_text"];
   $elnk = "$rootUrl/admin/editUser.php";
   $dlnk = "$rootUrl/admin/deleteUser.php";
   $alnk = "$rootUrl/admin/access.php";
   $plnk = "$rootUrl/admin/resetPassword.php";

   foreach($users as $u) {
      unset($txt);
      unset($tx);
      unset($est);
      $row = ($row == $zen->settings["color_bars"])?
	$zen->settings["color_background"] : $zen->settings["color_bars"];
      $name = $zen->formatName($u,1);
      if( $search_text && ($search_fields["lname"] || $search_fields["fname"] ) ) {
	$name = $zen->highlight($name,$search_text);
      }
      $inits = $zen->formatName($u,2);
      if( $search_text && $search_fields["initials"] )
         $inits = $zen->highlight($inits,$search_text);
      if( $u["notes"] && $search_text && $search_fields["notes"] )
         $u["notes"] = $zen->highlight($u["notes"],$search_text);
      ?>

	<tr style="background:<?=$row?>;color:<?=$text?>">
	<td height="25" valign="middle">
	  <?=$u["uid"]?>
	</td>
	<td height="25" valign="middle">
	  <?=$name?>
	</td>
	<td height="25" valign="middle">
	  <?=$inits?>
        </td>
	<td height="25" valign="middle">
	  <?=$u["access"]?>
        </td>
	<td height="25" valign="middle">
	  <?=$u["email"]?>
        </td>
	<td height="25" valign="middle">
	  <?=($u["active"])? "Yes" : "No"?>
        </td>
	<td height="25" valign="middle">
	  <?=$zen->bins["$u[homebin]"]?>
        </td>	
	<td <?=($u["notes"])? "rowspan='2'" : ""?> valign="middle">
	  <span class="small">
	  [<a href='<?=$elnk?>?uid=<?=$u["uid"]?>'>EDIT</a>]
	  <br>
	  [<a href='<?=$alnk?>?uid=<?=$u["uid"]?>'>ACCESS</a>]
	  <br>
          [<a href='<?=$plnk?>?uid=<?=$u["uid"]?>'
	   onClick='return confirm("RESET THE PASSWORD for user <?=$u["uid"]?>?");'
           >PASSWORD</a>]
	  <br>
          [<a href='<?=$dlnk?>?uid=<?=$u["uid"]?>'
	   onClick='return confirm("PERMANENTLY remove user <?=$u["uid"]?>?");'
           ><span class='error'>DELETE</span></a>]
        </td>
        </tr>
	<? 
	if( $u["notes"] ) {
	?>
	<tr style="background:<?=$row?>;color:<?=$text?>">
        <td colspan="7" class="small">
	   <?=$u["notes"]?>
	</td>
        </tr>
        <?
	   }
   }
   ?>
    <tr>
     <form method="post" action="<?=$SCRIPT_NAME?>">
     <td colspan="8" class="titleCell">
	<input type="submit" class="smallSubmit" value="Modify Search">
	<input type="hidden" name="search_text" value="<?=strip_tags($search_text)?>">
	<input type="hidden" name="search_fields[lname]" 
           value="<?=strip_tags($search_fields["lname"])?>">
	<input type="hidden" name="search_fields[fname]" 
           value="<?=strip_tags($search_fields["fname"])?>">
	<input type="hidden" name="search_fields[initials]" 
           value="<?=strip_tags($search_fields["initials"])?>">
	<input type="hidden" name="search_fields[notes]" 
           value="<?=strip_tags($search_fields["notes"])?>">
	<input type="hidden" name="search_access_method" 
           value="<?=strip_tags($search_access_method)?>">      
        <?
	  foreach($search_params as $k=>$v) {
	    print "<input type='hidden' name='search_params[$k]' value='".strip_tags($v)."'>\n";
          }
        ?>
     </td>
     </form>
    </tr>
    </table>
   <?   
}
?>
