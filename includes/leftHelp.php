
  <tr>
  <td <?=((isset($expand_help)&&$expand_help))? " class='titleCell'" : $nav_rollover_text?>>
    <a href='<?=$rootUrl?>/help/' class='menuLink'><?=$zen->prn("Help")?></a>
  </td>
  </tr>
  
  <? if( (isset($expand_help)&&$expand_help) ) { ?>  
  
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/about.php"><?=$zen->prn("About")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/install.php"><?=$zen->prn("Installation")?></a>
  </td>
  </tr>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/api.php"><?=$zen->prn("API")?></a>
  </td>
  </tr>
  
  <? } ?>
