<?

  include("help_header.php");
  $page_title = "Searching Tickets";
  include("$libDir/nav.php");
?>
&nbsp;
  <blockquote><a name="top"></a>
  Select fields which are left blank will return all possible choices for that field.
  <P>
  You may select multiple values from the select menus by holding the <b>shift</b> or <b>control</b> key.
  <P>
  <b>MouseOver or Click on the Image for Quick Help</b>
  <blockquote>
      <img src="<?=$rootUrl?>/images/search_view.jpg" width="400" height="438" usemap="#Map" border="0">
  </blockquote>
  <P>
<a name="containing"><b>CONTAINS</b></a>
<blockquote>
  Any text entered here will be matched against the title and description of tickets available for relavence.
<br><a href="#top">Top</a></blockquote>
<a name="archives"><b>ARCHIVED TICKETS</b></a>
<blockquote>
  Checking this box will match archived tickets rather than those currently processing in the system.
<br><a href="#top">Top</a></blockquote>
<a name="priority"><b>PRIORITY</b></a>
<blockquote>
  This matches the priority assigned to the ticket
<br><a href="#top">Top</a></blockquote>
<a name="time"><b>TIME ELAPSED</b></a>
<blockquote>
  The amount of time that has passed between the conditions chosen.
  <ul>
    <li><a name='ltgt'></a>Less Than: Matches tickets newer than the given condition
       <br>Greater Than: Matches tickets older than the given condition
    <li><a name='time_period'></a>Time Period: Sets the length of time elapsed
    <li><a name='ibso'></a>In Bin: Matches tickets who meet this condition since arriving in their current bin
       <br>Since Opened: Matches tickets who meet this condition since being created.
  </ul>
<br><a href="#top">Top</a></blockquote>
<a name="typ"><b>TYPE</b></a>
<blockquote>
  This is the type of process the ticket involves
<br><a href="#top">Top</a></blockquote>
<a name="sys"><b>SYSTEM</b></a>
<blockquote>
  This is the system or platform that the ticket is associated with.
<br><a href="#top">Top</a></blockquote>
<a name="bin"><b>BIN</b></a>
<blockquote>
  This is the bin or department the ticket belongs to.
<br><a href="#top">Top</a></blockquote>
<a name="sta"><b>STATUS</b></a>
<blockquote>
  This will match the status of the ticket.
  <ul>
    <li>OPEN: Ticket is being processed
    <li>PENDING: Ticket is awaiting testing or approval
    <li>CLOSED: Ticket is completed
    <li>NEW:  Not committed into the database
  </ul>
<a href="#top">Top</a></blockquote>
<a name="start"><b>START BUTTON</b></a>
<blockquote>
  Clicking the start button will begin the database search
<br><a href="#top">Top</a></blockquote>


<map name="Map">
<area shape="rect" coords="27,49,261,78" href="#containing" alt="Text that the title or description of the ticket(s) contain" title="Text that the title or description of the ticket(s) contain">
<area shape="rect" coords="74,89,192,147" href="#bin" alt="Bins that the ticket(s) will be in" title="Bins that the ticket(s) will be in">
<area shape="rect" coords="224,87,346,147" href="#sta" alt="The status of the ticket(s)" title="The status of the ticket(s)">
<area shape="rect" coords="68,159,202,218" href="#typ" alt="The type of ticket(s) to search for" title="The type of ticket(s) to search for">
<area shape="rect" coords="225,156,341,218" href="#sys" alt="The system that the ticket(s) may belong to" title="The system that the ticket(s) may belong to">
<area shape="rect" coords="28,229,105,268" href="#time" alt="The time period to retrieve tickets for " title="The time period to retrieve tickets for ">
<area shape="rect" coords="113,233,180,265" href="#ltgt" alt="Less than - At least as new as (given period) / Greater Than - At least older than (given period)" title="Less than - At least as new as (given period) / Greater Than - At least older than (given period)">
<area shape="rect" coords="192,229,266,265" href="#time_period" alt="The period of time to conduct the search over" title="The period of time to conduct the search over">
<area shape="rect" coords="273,228,358,279" href="#ibso" alt="Time elapsed where ticket currently resides (the bin) or since it was created" title="Time elapsed where ticket currently resides (the bin) or since it was created">
<area shape="rect" coords="158,355,220,382" href="#start" alt="Commence the search process" title="Commence the search process">
<area shape="rect" coords="26,391,138,423" href="#archives" alt="Search the archives instead of the active tickets" title="Search the archives instead of the active tickets">
<area shape="rect" coords="24,281,165,347" href="#priority" alt="The priority of the ticket(s) to be returned" title="The priority of the ticket(s) to be returned">
</map>

<?
  include("$libDir/footer.php");
?>
