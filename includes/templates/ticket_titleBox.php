<table width="560" cellpadding="0" cellspacing="0">
  <tr>
   <td class="ticketCell"><table 
     align="center" width='540'>     
     <tr>
       <td valign="top" width="440"><table 
          width="400" cellpadding="2" cellspacing="1">
	  <tr>
	   <td class="smallTitleCell" height="<?=$height_num?>"><?=tr("ID")?></td>
	   <td class="smallTitleCell" colspan="2"><?=uptr("Title")?></td>
	  </tr>
	  <tr>
	   <td class="small"><?=$id?></td>
	   <td class="small" colspan="2"><?=stripslashes($title)?></td>
	  </tr>
	  <tr>
	   <td class="smallTitleCell" height="<?=$height_num?>"><?=uptr("Elapsed")?></td>  
	   <td class="smallTitleCell" width="100"><?=uptr("Opened")?></td>
	   <td class="smallTitleCell" width="100"><?=uptr("Deadline")?></td>
	  </tr>
	  <tr>
	   <td class="small"><?=$zen->showTimeElapsed($otime,$ctime,1,0)?></td>  
	   <td class="small"><?=$zen->showDate($otime)?></td>
	   <td class="small"><?=($deadline)?$zen->showDateTime($deadline):"n/a"?></td>
	  </tr>
	  <tr>
	   <td rowspan="2"><span class="bigBold"><?=strtoupper($status)?></span></td>
	   <td class="smallTitleCell" height="<?=$height_num?>"><?=uptr("Priority")?></td> 
	   <td class="smallTitleCell"><?=uptr("Owner")?></td>
	  </tr>
	  <tr>
            <td class="priority<?=$priority?>"><?=$zen->priorities["$priority"]?></td>
	   <td class="small"><? 
	     if($user_id) { 
	       $user = $zen->get_user($user_id); 
	       print $user["fname"]." ".$user["lname"];
	     } else { 
	       print "-none-"; 
	     }
	           ?></td>
          </tr>	  	  
	  <tr>
	 </table></td>
       <td valign="top" width='100'><?
       $actions = array(
          "accept"  => 1,			
          "assign"  => 0,		     
          "reject"  => 1,
          "yank"    => 0,
          "reopen"  => 0,			
          "print"   => 1,
          "email"   => 1,
          "edit"    => 0
			);
       include("$templateDir/ticket_actionBar.php");
     ?></td>
     </tr>
    </table></td>
  </tr>
</table>

