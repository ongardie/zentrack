
  <tr>
  <td<?=($expand_search)? " class='titleCell'" : " ".$nav_rollover_text?>>
  <a class='menuLink' href="<?=$rootUrl?>/search.php"><?=$zen->prn("Search")?></a>
  </td>
  </tr>
  
  <? if( $expand_search ) { ?>
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/search.php">&nbsp;&nbsp;<?=$zen->prn("Advanced Search")?></a>
  </td>
  </tr>  
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/search.php">&nbsp;&nbsp;<?=$zen->prn("Search Logs")?></a>
  </td>
  </tr>  
  <tr>
  <td <?=$nav_rollover_text?>>
  <a class='subMenuLink' href="<?=$rootUrl?>/search.php">&nbsp;&nbsp;<?=$zen->prn("Search Archives")?></a>
  </td>
  </tr>         
       
  <? } ?>
