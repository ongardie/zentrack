<?

  include("help_header.php");
  $title = "Administrating Access";
  include("$libDir/nav.php");
?>
&nbsp;
  <blockquote>
  <ul>
    <li><a href='<?=$rootUrl?>/help/help_access.php'>Adding / Editing Users</a></li>
  </ul>
  <blockquote><a name="top"></a>
  <b><a href="<?=$rootUrl?>/help/help_newticket.php">Click here</a> for help with creating a new ticket</b>
  <P>
  <b>MouseOver or Click on the Image for Quick Help</b>
  <blockquote>
    <img src="<?=$rootUrl?>/images/access_view.jpg" width="154" height="301" usemap="#Map2" border="0">
  </blockquote>
  <b><a name="add"></a>LEVEL</b>
  <P>
  The level assigned determines the users access priviledges.  Recommended levels are: (these are dependant on what levels are set to in zenTrack_congig file)
  <ul>
    <li>Blank - no access to this bin
    <li>0 - view only
    <li>1 - user access (recieve and process tickets)
    <li>2 - supervisor access (assign, yank, test, close, approve)
    <li>3 - administrator access (add remove users, edit access levels
    <li>10 - master account (for assigning administrators and editing zenTrack config options
  </ul>
  <P>
  <b><a name="edit"></a>DEFAULT LEVEL VS ACCESS LEVEL</b>
  <P>
  If a level is set (even if it is set to blank) it will overrule the default access level assigned to a user.
  </blockquote>
  &nbsp;


<map name="Map2">
<area shape="rect" coords="10,57,132,84" href="#" alt="The bins this user currently has access to" title="The bins this user currently has access to">
<area shape="rect" coords="85,89,129,158" href="#level" alt="Level of Access to this Bin" title="Level of Access to this Bin">
<area shape="rect" coords="11,92,73,155" href="#" alt="The name of the bin to which access (level) is assigned" title="The name of the bin to which access (level) is assigned">
<area shape="rect" coords="10,165,78,189" href="#" alt="Save Changes" title="Save Changes">
<area shape="rect" coords="8,205,125,233" href="#" alt="Add (number) more bins to the list" title="Add (number) more bins to the list">
<area shape="rect" coords="6,253,93,283" href="#" alt="Links back to menus" title="Links back to menus">
</map>


<?
  include("$libDir/footer.php");
?>
