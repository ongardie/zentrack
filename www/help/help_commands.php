<?
  include("help_header.php");
  $title = "Ticket Commands and Terms";
  include("$libDir/nav.php");
?>
&nbsp;
  <blockquote><a name="top"></a>
  <b><a href="<?=$rootUrl?>/help/help_newticket.php">Click here</a> for help with creating a new ticket</b>
  <P>
<b>MouseOver or Click on the Image for Quick Help</b>
<blockquote>
  <img src="images/ticket_view.jpg" width="400" height="403" border="0" usemap="#Map">
</blockquote>
<a name="id"><b>ID</b></a>
<blockquote>
  This is then tracking number assigned to this ticket.
<br><a href="#top">Top</a></blockquote>
<a name="ttl"><b>TITLE</b></a>
<blockquote>
  This is the title of the ticket. The title should give a quick descriptive
    name to the process or request.
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
  This is the bin that the ticket is in currently.
<br><a href="#top">Top</a></blockquote>
<a name="own"><b>OWNER</b></a>
<blockquote>
  This is the person who was assigned / accepted the ticket. This is the individual
    responsible for processing of this ticket.
<br><a href="#top">Top</a></blockquote>
<a name="sta"><b>STATUS</b></a>
<blockquote>
  This is the current state of the ticket, indicating it's relation to completion.
  <ul>
    <li>OPEN: Ticket is being processed
    <li>PENDING: Ticket is awaiting testing or approval
    <li>CLOSED: Ticket is completed
  </ul>
<a href="#top">Top</a></blockquote>
<a name="crt"><b>BIN TIME</b></a>
<blockquote>
  This is the time that the ticket arrived in the current bin.
<br><a href="#top">Top</a></blockquote>
<a name="opt"><b>CREATED/OPENED</b></a>
<blockquote>
  This is the time that the ticket was created.
<br><a href="#top">Top</a></blockquote>
<a name="clt"><b>CLOSED</b></a>
<blockquote>
  This is the time that the ticket was closed. Testing and Approval are required
    before the ticket can be completed.
<br><a href="#top">Top</a></blockquote>
<a name="des"><b>DESCRIPTION</b></a>
<blockquote>
  This is a description of the process that will be involved in completing
    the ticket.
<br><a href="#top">Top</a></blockquote>
<a name="log"><b>LOG</b></a>
<blockquote>
  This is a log of actions, requests, and information relative to completion
    of the ticket.
<br><a href="#top">Top</a></blockquote>
<a name="tst"><b>TESTED</b></a>
<blockquote>
  This is the status of testing, whether or not it is complete on the ticket.
    Testing may be required before the ticket can be considered completed.
<br><a href="#top">Top</a></blockquote>
<a name="app"><b>APPROVED</b></a>
<blockquote>
  This is the status of approval, whether or not it is complete on the ticket.
    Approval may be required before the ticket can be considered completed.
<br><a href="#top">Top</a></blockquote>
<a name="ass"><b>RELATED TICKETS</b></a>
<blockquote>
  These are other tickets associated with this process. If the ticket is a
    project, then these tickets will be required to be complete before the project
    may be closed.
<br><a href="#top">Top</a></blockquote>
<a name="yank"><b>YANK</b></a>
<blockquote>
  This is a method to pull a ticket from the current user, so that others may
    access owner-specific functions. Supervisor access is required to yank a ticket.
<br><a href="#top">Top</a></blockquote>
<a name="move"><b>MOVE</b></a>
<blockquote>
  This is a method to send a ticket to a new bin. The owner becomes unassigned
    whenever a ticket is moved.
<br><a href="#top">Top</a></blockquote>
<a name="close"><b>CLOSE</b></a>
<blockquote>
  This is a method to mark the ticket as completed.  If a ticket is closed, but
  requires testing or approval, the status is set to PENDING instead of CLOSED.
<br><a href="#top">Top</a></blockquote>
<a name="relate"><b>RELATE</b></a>
<blockquote>
  This is a method to assign relavence to other tickets. The ticket can be
    associated with other tickets which involve a similar process or procedure.
    In the case of a project, the related cases are considered to be processes
    that must be completed before the project may be closed.
<br><a href="#top">Top</a></blockquote>
<a name="reject"><b>REJECT</b></a>
<blockquote>
  This is a method to return a ticket to the sender or creator due to an error
    or problem with completion.
<br><a href="#top">Top</a></blockquote>
<a name="assign"><b>ASSIGN</b></a>
<blockquote>
  This is a method to transfer ownership of a ticket to another user.
<br><a href="#top">Top</a></blockquote>
<a name="accept"><b>ACCEPT</b></a>
<blockquote>
  This is a method to assign ownership of a ticket to the logged in user.
<br><a href="#top">Top</a></blockquote>
  </blockquote>
  &nbsp;

<map name="Map">
<area shape="rect" coords="4,6,64,29" href="#id" alt="Tracking Number of the Ticket" title="Tracking Number of the Ticket">
<area shape="rect" coords="75,5,355,30" href="#ttl" alt="Title of the Ticket" title="Title of the Ticket">
<area shape="rect" coords="4,36,66,59" href="#pri" alt="Priority of the ticket" title="Priority of the ticket">
<area shape="rect" coords="75,36,165,59" href="#typ" alt="Type of process the ticket involves" title="Type of process the ticket involves">
<area shape="rect" coords="176,36,256,59" href="#sys" alt="System the ticket is associated with" title="System the ticket is associated with">
<area shape="rect" coords="4,66,65,88" href="#bin" alt="Bin ticket resides in currently" title="Bin ticket resides in currently">
<area shape="rect" coords="76,66,165,89" href="#own" alt="Person the ticket is assigned to" title="Person the ticket is assigned to">
<area shape="rect" coords="4,95,66,118" href="#sta" alt="Status of the ticket (Open, closed, archived, etc)" title="Status of the ticket (Open, closed, archived, etc)">
<area shape="rect" coords="75,95,165,118" href="#crt" alt="Time ticket arrived in current bin" title="Time ticket arrived in current bin">
<area shape="rect" coords="175,95,255,118" href="#opt" alt="Time Ticket was created" title="Time ticket was created">
<area shape="rect" coords="269,95,353,118" href="#clt" alt="Time this ticket was closed" title="Time this ticket was closed">
<area shape="rect" coords="1,127,354,151" href="#des" alt="Description of the process this ticket requires" title="Description of the process this ticket requires">
<area shape="rect" coords="-1,162,207,283" href="#log" alt="Log of actions and information pertinent to this ticket" title="Log of actions and information pertinent to this ticket">
<area shape="rect" coords="175,289,258,313" href="#app" alt="Whether or not this ticket has been approved as completed" title="Whether or not this ticket has been approved as completed">
<area shape="rect" coords="80,289,165,313" href="#tst" alt="Whether or not testing has been completed for this ticket" title="Whether or not testing has been completed for this ticket">
<area shape="rect" coords="80,316,399,375" href="#ass" alt="Tickets related to this ticket in nature or purpose.  For a project, these will be tickets that must be closed before this project can be completed" title="Tickets related to this ticket in nature or purpose.  For a project, these will be tickets that must be closed before this project can be completed">
<area shape="rect" coords="32,376,64,393" href="#yank" alt="Pull a ticket from it's current owner and assign it to a new user" title="Pull a ticket from it's current owner and assign it to a new user">
<area shape="rect" coords="85,377,116,392" href="#move" alt="Move a ticket to a different bin" title="Move a ticket to a different bin">
<area shape="rect" coords="119,377,143,391" href="#log" alt="Log notes, actions, or questions to this ticket" title="Log notes, actions, or questions to this ticket">
<area shape="rect" coords="145,377,183,391" href="#close" alt="Close this ticket which has been solved or cancelled" title="Close this ticket which has been solved or cancelled">
<area shape="rect" coords="186,377,229,391" href="#relate" alt="Relate this ticket to other similar tickets, or for projects, assign tasks to this project" title="Relate this ticket to other similar tickets, or for projects, assign tasks to this project">
<area shape="rect" coords="230,377,276,390" href="#reject" alt="Return this ticket to the sender or creator for modification" title="Return this ticket to the sender or creator for modification">
<area shape="rect" coords="280,377,320,390" href="#assign" alt="Assign ownership of this ticket to a user" title="Assign ownership of this ticket to a user">
<area shape="rect" coords="323,377,368,391" href="#accept" alt="Accept ownership of this ticket" title="Accept ownership of this ticket">
</map>

<?
  include("$libDir/footer.php");
?>
