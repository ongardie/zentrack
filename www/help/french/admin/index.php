<?
  $b = dirname(__FILE__);
  include("$b/admin_header.php");
?>

<div class='menubox'>
  <div><?=tr("Where Am I?")?></div>
  <p class='note'>Le manuel utilisateur contient des instructions sur la 
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