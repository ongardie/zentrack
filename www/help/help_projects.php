<?
   // zenTrack verion 1.0
   // zenTrack is a (c)phpZEN product, protected under the GPL Liscence for free distribution.
   // refer to http://www.phpzen.net for more information.

  include("help_header.php");
  $title = "Help With Projects";
  include("$libDir/nav.php");
?>
&nbsp;
  <blockquote>
  Projects are tickets which contain several sub-processes(other tickets).
  <P>
  Projects require completion of all associated sub-processes before they may be tested, approved or closed.
  <P>
  The purpose of a project is to provide a container and method of organizing several related cases into a central process.
  <P>
  Projects may be assigned to other projects (indicating that the assigned project must be complete before the parent project may be completed).
  <P>
  To open a project, simply open a <a href="<?=$rootUrl?>/help/help_newticket.php">new ticket</a> with a type of "Project".
  <P>
  To assign a ticket to a project, simply choose the project title from the pulldown menu at the top of the new ticket page.
  <P>
  To include an existing ticket in a project, open the project and click on the "TASKS" button to add or remove existing tickets.
  <P>
  Projects are otherwise conducted, tested, approved, and closed like normal tickets.
  </blockquote>
  &nbsp;
<?
  include("$libDir/footer.php");
?>
