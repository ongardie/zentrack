<?

  include("help_header.php");
  $title = "General";
  include("$libDir/nav.php");
?>
&nbsp;
  <blockquote>
  zenTrack is a ticketing system for managing process tracking and completion.
  <P>
  <b>The general tracking process is conducted as follows:</b>
  <ul>
    <li>A problem, project, or other process is determined necessary.</li>
    <li>A user, with permission, <a href='<?=$rootUrl?>/help/help_newticket.php'>creates a new ticket</a></li>
    <li>A user, with permission, <a href='<?=$rootUrl?>/help/help_commands.php#assign'>assigns or accepts the ticket</a></li>
    <li>The owner, who accepted or was assigned the ticket, completes or solves the process and <a href='<?=$rootUrl?>/help/help_commands.php#log'>logs the steps taken</a></li>
    <li>The ticket is <a href='<?=$rootUrl?>/help/help_commands.php#test'>tested</a> or <a href='<?=$rootUrl?>/help/help_commands.php#approve'>approved</a> as necessary by an appropriate person</li>
    <li>The owner or approving person <a href='<?=$rootUrl?>/help/help_commands.php#close'>closes</a> the ticket and it is sent to the ticket <a href='<?=$rootUrl?>/help/help_commands.php#archive'>archives</a></li>
  </ul>
  <P>
  <b>Various help topics</b>
  <ul>
    Information on creating a ticket can be found <a href='<?=$rootUrl?>/help/help_newticket.php'>here</a>
    <P>
    Information on editing tickets, and various options available can be found <a href='<?=$rootUrl?>/help/help_commands.php'>here</a>
    <P>
    Information on administrating users, and configuring zenTrack settings can be found <a href='<?=$rootUrl?>/help/help_admin.php'>here</a>
    <P>
    Information on development and the program level structure of zenTrack can be found <a href='<?=$rootUrl?>/help/help_development.php'>here</a>
   </ul>
   <b>Problems and Requests</b>
   <ul>
     <P>If you need access to zenTrack, need your access updated, have problems or difficulty with the system, contact your <a href="mailto:<?=$ect->settings["admin_email"]?>">Administrator</a>.
   </ul>
  </blockquote>
  &nbsp;
<?
  include("$libDir/footer.php");
?>
