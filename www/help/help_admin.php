<?
  include("help_header.php");
  $title = "Administration";
  include("$libDir/nav.php");
?>
&nbsp;
  <blockquote>
  <b>Only users with admin level access may use the admin menu</b>
  <br>Click on the Admin topic with which you would like assistance.
  <ul>
    <li><a href='<?=$rootUrl?>/help/help_users.php'>Help Adding and Editing User Accounts</a></li>
    <li><a href='<?=$rootUrl?>/help/help_access.php'>Help Editing User Access</a></li>
    <li><a href='<?=$rootUrl?>/help/help_archive.php'>Help Editing and Archiving Tickets</a></li>
    <li><a href='<?=$rootUrl?>/help/help_config.php'>Help Editing zenTrack Configuration and Settings</a></li>
  </ul>
  </blockquote>
  &nbsp;
<?
  include("$libDir/footer.php");
?>
