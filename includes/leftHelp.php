
  <tr>
  <td <?=((isset($expand_help)&&$expand_help))? " class='titleCell'" : $nav_rollover_text?>>
    <a href='<?=$rootUrl?>/help/' class='menuLink'><?=tr("Help")?></a>
  </td>
  </tr>
  
  <? if( (isset($expand_help)&&$expand_help) ) { ?>  
  
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/about.php"><?=tr("About")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/install.php"><?=tr("Installation")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/api.php"><?=tr("API")?></a>
  </td>
  </tr>
  
  <? } ?>
