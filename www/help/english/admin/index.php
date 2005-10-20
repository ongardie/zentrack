<?
  $b = dirname(__FILE__);
  include("$b/admin_header.php");
?>

<table width='80%'><tr><td>

<div class='menubox'>
  <div><?=tr("Where Am I?")?></div>
  <p class='note'>The administrator's manual contains instructions on how 
  set up advanced features of <?=$zen->getSetting('system_name')?>.</p>
  <p class='note'>First time using <?=$zen->getSetting('system_name')?>?  
  Please try out the <a href='<?=$helpUrl?>/tutorial.php'><?=tr("Tutorial")?></a>!</p>
</div>

<div class='menubox'>
  <div><?=tr("Contents of Administrator's Manual")?></div>
<?
  renderTOC('admin', false);
?>
</div>
</table>

<? 
  renderNavbar('admin');
  include("$libDir/footer.php"); 
?>
