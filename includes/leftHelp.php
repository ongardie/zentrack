
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
  <a class='subMenuLink' href="<?=$rootUrl?>/help/support.php"><?=tr("Support")?></a>
  </td>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/help/gpl.php"><?=tr("License")?></a>
  </td>
  </tr>
  </tr>
  </tr>
  
  <? } ?>
