<?
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

Contacts

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
