
  <tr>
  <td <?=($expand_admin)? " class='titleCell'" : $nav_rollover_text?>>
   <a href='<?=$rootUrl?>/admin/' class='menuLink'><?=tr("Admin")?></a>
  </td>
  </tr>
  
  <? if( $expand_admin ) { ?>
  
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/addUser.php"><?=tr("New User")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/listUsers.php"><?=tr("Edit Users")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/editTicket.php"><?=tr("Edit Tickets")?></a>
  </td>
  </tr>  
  <tr>
  <!--
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/archive.php"><?=tr("Archive Tickets")?></a>
  </td>
  -->
  </tr>  
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/config.php"><?=tr("Settings")?></a>
  </td>
  </tr>  

  <? } ?>
