<?
  $b = dirname(__FILE__);
  include("$b/admin_header.php");
?>

<div class='menubox'>
  <div><?=tr("Where Am I?")?></div>
  <p class='note'>Le manuel utilisateur contient des instructions sur la   fa�on de r�gler les fonctionalit�s avanc�es de  <?=$zen->getSetting('system_name')?>.</p>  S'il vous plait faites des essais gr�ce � <a href='<?=$helpUrl?>/tutorial.php'><?=tr("Tutorial")?></a>!</p>
</div>

<div class='menubox'>
  <div><?=tr("Contents of Administrator's Manual")?></div>
<?
  renderTOC('admin', false);
?>
</div>

<? 
  renderNavbar('admin');
  include("$libDir/footer.php"); 
?>
