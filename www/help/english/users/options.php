<?
  $b = dirname(__FILE__);
  include("$b/user_header.php");
?>

Options

<? 
  renderNavbar('users', $usersTOC);
  include("$libDir/footer.php"); 
?>
