<?
   // zenTrack verion 1.0
   // zenTrack is a (c)phpZEN product, protected under the GPL Liscence for free distribution.
   // refer to http://www.phpzen.net for more information.

  include("help_header.php");
  $title = "New Tickets";
  include("$libDir/nav.php");
?>
&nbsp;
  <blockquote><a name="top"></a>
  This help menu discusses the process of creating a ticket.
  <P>
  <b>MouseOver or Click on the Image for Quick Help</b>
  <blockquote>
    <img src="<?=$rootUrl?>/images/newticket_view.jpg" width="433" height="500" border="0" usemap="#Map">
  </blockquote>
  <P>
<a name="pid"><b>PROJECT</b></a>
<blockquote>
  Choosing a project from this menu will assign this new ticket to the existing <a href='<?=$rootUrl?>/help/help_projects.php'>project</a>.
<br><a href="#top">Top</a></blockquote>
<a name="id"><b>ID</b></a>
<blockquote>
  This denotes the assigned tracking number of the ticket.  It will be assigned automatically by the system when the ticket is committed to the database.
<br><a href="#top">Top</a></blockquote>
<a name="ttl"><b>TITLE</b></a>
<blockquote>
  This is the name of the project or process that this ticket will be referred to as.
<br><a href="#top">Top</a></blockquote>
<a name="pri"><b>PRIORITY</b></a>
<blockquote>
  The priority of this ticket.  This denotes it's importance and relevance in relation to the other open tickets, and it's necessity of completion.
<br><a href="#top">Top</a></blockquote>
<a name="typ"><b>TYPE</b></a>
<blockquote>
  This is the type of process that the ticket will involve.
  <P>
  A ticket with a type "Project" will be created as a project.
<br><a href="#top">Top</a></blockquote>
<a name="sys"><b>SYSTEM</b></a>
<blockquote>
  This is the system or platform that the ticket is associated with.
<br><a href="#top">Top</a></blockquote>
<a name="bin"><b>BIN</b></a>
<blockquote>
  This is the bin or department that the ticket will begin in.
<br><a href="#top">Top</a></blockquote>
<a name="own"><b>OWNER</b></a>
<blockquote>
  This is a user who will be assigned ownership of this ticket. This is the primary individual
    responsible for processing and completion of the ticket.
<br><a href="#top">Top</a></blockquote>
<a name="sta"><b>STATUS</b></a>
<blockquote>
  This is the current state of the ticket, indicating it's relation to completion.
  <ul>
    <li>OPEN: Ticket is being processed
    <li>PENDING: Ticket is awaiting testing or approval
    <li>CLOSED: Ticket is completed
    <li>NEW:  Not committed into the database
  </ul>
<a href="#top">Top</a></blockquote>
<a name="crt"><b>BIN TIME</b></a>
<blockquote>
  This is n/a until the ticket is added to a bin.
<br><a href="#top">Top</a></blockquote>
<a name="opt"><b>CREATED/OPENED</b></a>
<blockquote>
  This is the time that the ticket is created.  It is automatically set by the system when the ticket is committed.
<br><a href="#top">Top</a></blockquote>
<a name="clt"><b>CLOSED</b></a>
<blockquote>
  This is set when the ticket is completed.
<br><a href="#top">Top</a></blockquote>
<blockquote>
  This is a description of the process that will be involved in completing
    the ticket.
<br><a href="#top">Top</a></blockquote>
<a name="log"><b>LOG</b></a>
<blockquote>
  This is a log of actions, requests, and information relative to completion
    of the ticket.  This will be empty until the ticket is opened.
<br><a href="#top">Top</a></blockquote>
<a name="tst"><b>TESTED</b></a>
<blockquote>
  Checking or unchecking this box specifies whether testing will be required for this project.
<br><a href="#top">Top</a></blockquote>
<a name="app"><b>APPROVED</b></a>
<blockquote>
  Checking or unchecking this box specifies whether supervisor approval will be required for completion of this project.
<br><a href="#top">Top</a></blockquote>
<a name="ass"><b>RELATED TICKETS</b></a>
<blockquote>
  This is a comma separated list that denotes that other tickets contain relevant information or processes to this ticket.
<br><a href="#top">Top</a></blockquote>
  </blockquote>
  &nbsp;
<map name="Map">
<area shape="rect" coords="83,3,384,32" href="#pid" alt="Choosing a project from this menu will assign the new ticket to that project" title="Choosing a project from this menu will assign the new ticket to that project">
<area shape="rect" coords="6,39,72,68" href="#id" alt="The tracking ID will be assigned when the ticket is saved" title="The tracking ID will be assigned when the ticket is saved">
<area shape="rect" coords="83,40,386,69" href="#ttl" alt="The title of the new ticket" title="The title of the new ticket">
<area shape="rect" coords="6,76,72,103" href="#pri" alt="The importance of this ticket" title="The importance of this ticket">
<area shape="rect" coords="84,75,182,103" href="#typ" alt="The type of process this ticket involves" title="The type of process this ticket involves">
<area shape="rect" coords="193,76,278,104" href="#sys" alt="The system associated with this ticket" title="The system associated with this ticket">
<area shape="rect" coords="6,111,72,136" href="#bin" alt="The bin to place this ticket in when created" title="The bin to place this ticket in when created">
<area shape="rect" coords="83,111,181,136" href="#own" alt="A User to assign this ticket to" title="A User to assign this ticket to">
<area shape="rect" coords="5,143,73,170" href="#sta" alt="The status of the ticket, will be updated to OPEN when the ticket is commited" title="The status of the ticket, will be updated to OPEN when the ticket is commited">
<area shape="rect" coords="85,143,182,168" href="#crt" alt="The time in the current bin (obviously N/A for now)" title="The time in the current bin (obviously N/A for now)">
<area shape="rect" coords="193,143,278,169" href="#opt" alt="The creation time of the ticket, assigned when the ticket is committed to the database" title="The creation time of the ticket, assigned when the ticket is committed to the database">
<area shape="rect" coords="294,141,385,168" href="#clt" alt="The time the ticket is closed (obviously N/A for now)" title="The time the ticket is closed (obviously N/A for now)">
<area shape="rect" coords="2,180,223,298" href="#des" alt="Description of the process involved in this ticket" title="Description of the process involved in this ticket">
<area shape="rect" coords="0,314,225,370" href="#log" alt="The log window ( there will be no entries until the ticket is opened)" title="The log window ( there will be no entries until the ticket is opened)">
<area shape="rect" coords="84,384,180,410" href="#tst" alt="If this is checked, then testing is required before completion of this ticket" title="If this is checked, then testing is required before completion of this ticket">
<area shape="rect" coords="191,382,278,410" href="#app" alt="If this is checked, then approval (from a supervisor) is required before this ticket is complete" title="If this is checked, then approval (from a supervisor) is required before this ticket is complete">
<area shape="rect" coords="85,412,308,472" href="#ass" alt="A comma seperated list of ticket id's that are relavent to this process" title="A comma seperated list of ticket id's that are relavent to this process">
<area shape="rect" coords="203,473,236,490" href="#" alt="Clicking the Save Button will commit this ticket to the database and assign it an id" title="Clicking the Save Button will commit this ticket to the database and assign it an id">
</map>
<?
  include("$libDir/footer.php");
?>
