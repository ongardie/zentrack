
  <tr>
  <td<?=(isset($expand_projects)&&$expand_projects)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/projects.php"><?=$zen->prn("Projects")?></a>
  </td>
  </tr>
<? if( isset($expand_projects)&&$expand_projects ) { ?>     
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/assignedProjects.php">&nbsp;&nbsp;<?=$zen->prn("Assigned to $login_inits")?></a>
  </td>
  </tr>  
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/newProject.php">&nbsp;&nbsp;<?=$zen->prn("Create New")?></a>
  </td>
  </tr>
<? } ?>
  <tr>
  <td<?=(isset($expand_tickets)&&$expand_tickets)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/index.php"><?=$zen->prn("Tickets")?></a>
  </td>
  </tr>
<? if( isset($expand_tickets)&&$expand_tickets ) { ?>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/assignedTickets.php">&nbsp;&nbsp;<?=$zen->prn("Assinged to $login_inits")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/newTicket.php">&nbsp;&nbsp;<?=$zen->prn("Create New")?></a>
  </td>
  </tr>  
<? } ?>
