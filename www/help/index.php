<?

  include("help_header.php");
  $title = "zenTrack Help Menu";
  include("$libDir/nav.php");

?>&nbsp;
  <blockquote>
  <P>
   <b>MouseOver or Click on the Image for Quick Help</b>
   <ul>
    <img src="/images/index_view.jpg" width="551" height="350" usemap="#index_map" border="0">
   </ul>
  Welcome to zenTrack help.
  <br>If you aren't sure what
  <br>you are looking for, start
  <br>with <b>General Help.
  </i>
  <P>
  <a href="<?=$rootUrl?>/help/help_general.php">General Help</a>
  <br><a href="<?=$rootUrl?>/help/help_about.php">About zenTrack</a>
  <P>
  <a href="<?=$rootUrl?>/help/help_commands.php">Ticket Commands</a>
  <br><a href="<?=$rootUrl?>/help/help_newticket.php">Creating Tickets</a>
  <br><a href="<?=$rootUrl?>/help/help_searches.php">Searching Tickets</a>
  <P>
  <a href="<?=$rootUrl?>/help/help_admin.php">Administration Help</a>
  <br><a href="<?=$rootUrl?>/help/help_install.php">Installation Help</a>
  <br><a href="<?=$rootUrl?>/help/help_developer.php">Developer's Help</a>
  <P>
  <a href="MAILTO:<?=$ect->settings["admin_email"]?>">Report Errors</a>
  </blockquote>

<map name="index_map">
<area shape="rect" coords="109,103,296,287" href="<?=$rootUrl?>/help/help_commands.php" alt="Tickets, Clicking Here will take a user to the ticket window" title="Tickets, Clicking Here will take a user to the ticket window">
<area shape="rect" coords="296,104,549,287" href="#" alt="Ticket Information" title="Ticket Information">
<area shape="rect" coords="110,81,140,101" href="<?=$rootUrl?>/help/help_commands.php#id" alt="The id number of the ticket" title="The id number of the ticket">
<area shape="rect" coords="140,81,294,100" href="<?=$rootUrl?>/help/help_commands.php#ttl" alt="The  title of the ticket" title="The  title of the ticket">
<area shape="rect" coords="295,81,329,101" href="<?=$rootUrl?>/help/help_commands.php#pri" alt="The priority of the ticket" title="The priority of the ticket">
<area shape="rect" coords="332,82,386,102" href="<?=$rootUrl?>/help/help_commands.php#typ" alt="The type of process the ticket involves" title="The type of process the ticket involves">
<area shape="rect" coords="389,81,423,101" href="<?=$rootUrl?>/help/help_commands.php#opt" alt="The time this ticket was created" title="The time this ticket was created">
<area shape="rect" coords="424,81,466,101" href="<?=$rootUrl?>/help/help_commands.php#own" alt="The owner of the ticket" title="The owner of the ticket">
<area shape="rect" coords="468,81,517,101" href="<?=$rootUrl?>/help/help_commands.php#bin" alt="The bin this ticket resides in" title="The bin this ticket resides in">
<area shape="rect" coords="518,81,547,101" href="<?=$rootUrl?>/help/help_commands.php#crt" alt="The time this ticket entered the current bin" title="The time this ticket entered the current bin">
<area shape="rect" coords="286,35,401,59" href="#" alt="Title of the current view" title="Title of the current view">
<area shape="rect" coords="76,1,140,13" href="#" alt="Logged in user's initials, clicking here will log user off" title="Logged in user's initials, clicking here will log user off">
<area shape="rect" coords="76,16,138,28" href="#" alt="Takes user to the open tickets screen" title="Takes user to the open tickets screen">
<area shape="rect" coords="75,30,138,41" href="<?=$rootUrl?>/help.php" alt="Opens the help screens" title="Opens the help screens">
<area shape="rect" coords="74,43,138,56" href="<?=$rootUrl?>/help/help_admin.php" alt="Options for configuration and user access (only available to administrators)" title="Options for configuration and user access (only available to administrators)">
<area shape="rect" coords="4,81,71,94" href="#" alt="Displays all tickets assigned to the logged in user" title="Displays all tickets assigned to the logged in user">
<area shape="rect" coords="5,96,69,108" href="#" alt="Displays all tickets in bins that the logged in user can access" title="Displays all tickets in bins that the logged in user can access">
<area shape="rect" coords="3,111,70,121" href="<?=$rootUrl?>/help/help_newticket.php" alt="Open a new ticket" title="Open a new ticket">
<area shape="rect" coords="3,124,69,135" href="<?=$rootUrl?>/help/help_searches.php" alt="Opens the advanced search screen" title="Opens the advanced search screen">
<area shape="rect" coords="3,183,72,304" href="<?=$rootUrl?>/help/help_searches.php" alt="Quick menus to filter tickets by bin, type, priority, system, and/or status" title="Quick menus to filter tickets by bin, type, priority, system, and/or status">
<area shape="rect" coords="3,144,70,175" href="#" alt="Displays the number of bins and tickets currently being viewed" title="Displays the number of bins and tickets currently being viewed">
<area shape="rect" coords="0,0,72,57" href="#" alt="zenTrack Logo" title="zenTrack Logo">
<area shape="rect" coords="428,59,543,78" href="#" alt="Input a ticket id and hit enter to jump to that ticket view" title="Input a ticket id and hit enter to jump to that ticket"></map>
</map>

<?
   include("$libDir/footer.php");
?>
