
  <tr>
  <td <?=($expand_admin)? " class='titleCell'" : $nav_rollover_text?>>
   <a href='<?=$rootUrl?>/admin/' class='menuLink'><?=$zen->prn("Admin")?></a>
  </td>
  </tr>
  
  <? if( $expand_admin ) { ?>
  
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/addUser.php">New User</a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/listUsers.php">Edit Users</a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/editTicket.php">Edit Tickets</a>
  </td>
  </tr>  
  <tr>
  <!--
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/archive.php">Archive Tickets</a>
  </td>
  -->
  </tr>  
  <tr>
  <td <?=$nav_rollover_text?>>
    <a class="subMenuLink" href="<?=$rootUrl?>/admin/config.php">Settings</a>
  </td>
  </tr>  

  <? } ?>
