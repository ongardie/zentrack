
  <tr>
  <td <?=($expand_help)? " class='titleCell'" : $nav_rollover_text?>>
    <a href='<?=$rootUrl?>/help/' class='menuLink'><?=$zen->prn("Help")?></a>
  </td>
  </tr>
  
  <? if( $expand_help ) { ?>  
  
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/help_general.php"><?=$zen->prn("General")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/help_about.php"><?=$zen->prn("About").$zen->settings["system_name"]?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/help_commands.php"><?=$zen->prn("Tickets")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/help_projects.php"><?=$zen->prn("Projects")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/help_newticket.php"><?=$zen->prn("New Ticket")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/help_searches.php"><?=$zen->prn("Searches")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/help_admin.php"><?=$zen->prn("Admin")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/help_install.php"><?=$zen->prn("Installation")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/help_developer.php"><?=$zen->prn("Development")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="MAILTO:<?=$zen->settings["admin_email"]?>"><?=$zen->prn("Errors")?></a>
  </td>
  </tr>
  
  <? } ?>
