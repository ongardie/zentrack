<?
  $b = dirname(__FILE__);
  include("$b/admin_header.php");
?>

<p><b>Where Am I?</b></p>

<p>The administrator's manual contains instructions on how 
set up advanced features of <?=$zen->settings['system_name']?>.</p>

<p>
First time using <?=$zen->settings['system_name']?>?  
Please try out the 
<a href='<?=$helpUrl?>/users/tutorial.php'>Tutorial</a>!</p>

<p><b>Contents of Administrator's Manual</b></p>
<?
  renderTOC('admin', false);
?>

<? 
  renderNavbar('admin');
  include("$libDir/footer.php"); 
?>
