<?

  include("help_header.php");
  $title = "Development";
  include("$libDir/nav.php");
?>
&nbsp;
  <blockquote>
  <b><a name="top" style="color: <?=$zen->settings["color_alttxt"]?>">Development Assistance</a></b>
  <ul>
    <li><a href="#functions">ecTicket Functions</a>
    <li><a href="#vars">ecTicket Object Variables</a>
    <li><a href="#session">Session Variables</a>
    <li><a href="#common">Common Variables</a>
    <li><a href="#system">System Variables</a>
  </ul>
  <b><a name="vars" style="color: <?=$zen->settings["color_alttxt"]?>">ecTicket Object Variables</a></b>
  <P>
  $zen refers to the ecTicket.class object.  This may be different on your system.
  <ul>
	<li><b>$zen->params</b> - [associative array] the properties of a ticket returned by getTicket(id)
  <ul>
    <li><b>$zen->params["id"]</b> - (int/id) tracking id of the ticket
    <li><b>$zen->params["ttl"]</b> - (string) title of the ticket
    <li><b>$zen->params["pri"]</b> - (int) priority of the ticket (0 is highest), convert with $zen->settings["pri"]
    <li><b>$zen->params["sta"]</b> - (string) status of the object (OPEN, CLOSED, PENDING)
    <li><b>$zen->params["des"]</b> - (string) description of the ticket
    <li><b>$zen->params["pid"]</b> - (int) parent ticket id(project this ticket belongs to)
    <li><b>$zen->params["opt"]</b> - (string/date) opened time
    <li><b>$zen->params["clt"]</b> - (string/date) closed time
    <li><b>$zen->params["crt"]</b> - (string/date) time arrived at current bin
    <li><b>$zen->params["cby"]</b> - (string/username) created by
    <li><b>$zen->params["bin"]</b> - (string) bin ticket is in
    <li><b>$zen->params["typ"]</b> - (string) type of ticket
    <li><b>$zen->params["own"]</b> - (string/username) owner of ticket (n/a is unowned)
    <li><b>$zen->params["sys"]</b> - (string) system ticket is associated with
    <li><b>$zen->params["tst"]</b> - (int) testing: 0-not required, 1-required, 2-completed
    <li><b>$zen->params["app"]</b> - (int) approval: 0-not required, 1-required, 2-completed
    <li><b>$zen->params["ass"]</b> - (array/id) ticket id's of associated cases
  </ul>
	<li><b>$zen->usr</b> - [associative array] contains the properties of the current user (retrieved by getUser($login_name) )
  <ul>
     <li><b>$zen->params["bins"]</b> - (associative array/int) keys are bin names, values are access level
	   <li><b>$zen->params["usr"]</b> - (string/username) username/login name
	   <li><b>$zen->params["lvl"]</b> - (string) user access level
	   <li><b>$zen->params["pass"]</b> - (string) password(encrypted)
	   <li><b>$zen->params["lname"]</b> - (string) last name
	   <li><b>$zen->params["fname"]</b> - (string) first name
	   <li><b>$zen->params["init"]</b> - (string) initials
	   <li><b>$zen->params["email"]</b> - (string) email address
	   <li><b>$zen->params["notes"]</b> - (string) administrators notes about this account
	   <li><b>$zen->params["prefs"]</b> - (string) setup preferences (see prefs.php)
	   <li><b>$zen->params["home"]</b> - (string) users default bin
  </ul>
	<li><b>$zen->params["settings"]</b> - (associative array) - keys are setting names, values represent their current setting.
  Several of these are arrays.
  See <a href='<?=$rootUrl?>/help_config.php'>zenTrack Config</a> for more info.
  <li><a href="#top">Top</a>
  </ul>
  <b><a name="session" style="color:<?=$zen->settings["color_alttxt"]?>">Session Variables</a></b>
  <ul>
    <li><b>$login_level</b> - (string/username) default access level for this logged in user
    <li><b>$login_user</b> - (string/username) username/login name of logged in user
    <li><b>$login_name</b> - (string) "firstname lastname" of logged in user
    <li><b>$page_last</b> - (string) referring page(safely parsed), if $redirect is set in a form or url, the $page_last will match this
     <li><a href="#top">Top</a>
  </ul>
  <b><a name="common" style="color:<?=$zen->settings["color_alttxt"]?>">Common Variables</a></b>
  <ul>
    <li><b>$userBins</b> - (array) bin names this user has sufficient access to view
    <li><b></b> - (string) includes directory
    <li><b>$rootURL</b> - (string) starting url up to zenTrack directory
    <li><b>$id</b> - (int/id) id of processing ticket (avoid using this)
    <li><b>$TODO, $vals, $val, $var, $vars</b> - (various) temporary variables used often on pages, avoid using these
     <li><a href="#top">Top</a>
  </ul>
  <b><a name="functions" style="color:<?=$zen->settings["color_alttxt"]?>">Functions</a></b>
  <ul>
  <li><b>LIST FUNCTIONS</b>
  <ul>
	  <li><b>getUserList( bins )</b>
      <br>bins: array of bin names to include (optional)
		  <br>returns an associative array indexed with the username containing [0]-last name [1]-first name
	  <li><b>getSettingList( type )</b>
      <br>type: name of setting list to return (default = 'bins')
		  <br>returns associative array of names = vals
	  <li><b>searchLogs( conditions, archives )</b>
      <br>conditions: query conditions(optional) (i.e. bin = 'bin_name' and sta = 'OPEN' )
      <br>archives: (optional) integer value indicates search archives instead of active
		  <br>returns indexed arrays of log entries array[][(id, whn, log)]
    <li><b>filterTickets( conditions, order_by )</b>
      <br>conditions: query conditions
      <br>order_by: order by fields(optional)
      <br>returns indexed arrays of tickets (common properties)
	  <li><b>listProjects( bins, usr, limit, sort_method )</b>
      <br>bins: array of bins to include
      <br>usr: username to match tickets against(optional)
      <br>limit: maximum number to return(optional)
      <br>sort_method: sort results by fields listed(optional)
		  <br>returns indexed arrays of project properties
	  <li><b>listTickets( bins, usr, limit, sort_method )</b>
      <br>bins: array of bins to include
      <br>usr: username to match tickets against(optional)
      <br>limit: maximum number to return(optional)
      <br>sort_method: sort results by fields listed(optional)
		  <br>returns indexed arrays of project properties
  </ul>
  <li><b>TICKET FUNCTIONS</b>
  <ul>
	  <li><b>getTicket( id )</b>
      <br>id: the tracking id of the ticket
		  <br>returns number of properties found for this ticket (0 - no ticket found)
    <li><b>getTitle( id )</b>
      <br>id: the tracking id of the ticket
      <br>returns the title (ttl) of the ticket
	  <li><b>getLog( id, order = 'whn DESC', limit = '', conditions = '' )</b>
      <br>id: the tracking id of the ticket
      <br>order: order to sort results (optional, defaults to 'whn DESC')
      <br>limit: maximum number of entries to return (optional)
      <br>conditions: optional conditions to add into the query (optional, i.e. 'bin = 'Engineering')
		  <br>returns indexed arrays of log entries
	  <li><b>logTicket( id, usr, bin, function, log )</b>
      <br>id: the tracking id of the ticket
      <br>usr: the user who committed this action
      <br>bin: the bin the action occurred in
      <br>function: the action taken (optional, defaults to 'ACTION', i.e. 'CLOSED', 'APPROVED', etc)
      <br>log: the entry/data to be logged (optional)
		  <br>returns integer if successful
	  <li><b>getSender( id )</b>
      <br>id: the tracking id of the ticket
		  <br>returns the bin that this ticket was in previous to the current
	  <li><b>addTicket( ttl, pri, sta, des, opt, by, bin, typ, own, sys, tst, app, ass, pid )</b>
      <br>ttl: the title of the new ticket
      <br>pri: the priority of the new ticket (integer)
      <br>sta: the status of the new ticket (should be 'OPEN')
      <br>des: the description of the process this ticket involves
      <br>opt: the time this ticket opened (SYSDATE for Oracle 8i, NOW() for MySql)
      <br>by: the login name of the person who creating the ticket
      <br>bin: the bin to assign the ticket to
      <br>typ: the type of process ticket involves
      <br>own: person to assign the ticket to (optional, defaults to 'n/a')
      <br>sys: system the ticket is associated with
      <br>tst: testing, 0-not required, 1-required, 2-completed (optional, defaults to 0)
      <br>app: approval, 0-not required, 1-required, 2-completed (optional, defaults to 0)
      <br>ass: associated tickets, comma seperated list of ticket ids (optional)
      <br>pid: project id, a tracking id of a project that this ticket belongs to (optional)
		  <br>returns an integer if add is successful
	  <li><b>changeStatus( id, newStatus, usr, notes )</b>
      <br>id: the tracking id of the ticket
      <br>newStatus: the status ticket should be changed to (optional, defaults to 'OPEN')
      <br>usr: the user changing the status
      <br>notes: notes to be logged about this change
		  <br>returns an integer if change is successful
	  <li><b>closeTicket( id, usr, newStatus, notes )</b>
      <br>id: the tracking id of the ticket
      <br>usr: the login name of the user closing the ticket
      <br>newStatus: the status of the ticket (optional, defaults to 'CLOSED', generally 'SOLVED' or 'CANCELLED')
      <br>notes: optional reason for closing (optional)
		  <br>returns an integer if close is successful
	  <li><b>archiveTicket( id, usr )</b>
      <br>id: the tracking id of the ticket
      <br>usr: the user who is archiving the ticket (optional, defaults to 'system')
		  <br>returns an integer if archive is successful
	  <li><b>rejectTicket( id, usr, back_to, reason )</b>
      <br>id: the tracking id of the ticket
      <br>usr: the login name of the user rejecting the ticket
      <br>back_to: where to ship it to, origin-creator of ticket, sender-last owner before shipping to current location (optional, defaults to origin)
      <br>reason: reason for rejecting (optional)
		  <br>returns integer if successful
	  <li><b>assignTicket( id, assign_to, usr, comments )</b>
      <br>id: the tracking id of the ticket
      <br>assign_to: login name of person to recieve ticket (optional, defaults to n/a)
      <br>usr: login name of person assigning ticket  (optional)
      <br>comments: notes (optional)
		  <br>returns integer if successful
	  <li><b>acceptTicket( id, acceptor, comments )</b>
      <br>id: the tracking id of the ticket
      <br>acceptor: login name of person accepting
      <br>comments: notes (optional)
		  <br>returns integer if successful
	  <li><b>yankTicket( id, assign_to, usr, comments )</b>
      <br>id: the tracking id of the ticket
      <br>assign_to: optional person to reassign to (optional, defaults to 'n/a')
      <br>usr: person yanking ticket (optional)
      <br>comments: notes or reason (optional)
		  <br>returns integer if successful
	  <li><b>moveTicket( id, new_bin, usr, comments )</b>
      <br>id: the tracking id of the ticket
      <br>new_bin: bin name to move to
      <br>usr: the person moving (optional)
      <br>comments: notes (optional)
		   <br>returns integer if successful
	  <li><b>editTicket( id, params, usr )</b>
      <br>id: the tracking id of the ticket
      <br>params: indexed array containing field=>newvalue
		  <br>returns result
	  <li><b>testTicket( id, usr, comments )</b>
      <br>id: the tracking id of the ticket
      <br>usr: the login name of person who completed testing
      <br>comments: notes (optional)
		  <br>returns integer if successful
	  <li><b>approveTicket( id, usr, comments )</b>
      <br>id: the tracking id of the ticket
      <br>usr: the login name of person who approved ticket
      <br>comments: notes (optional)
		  <br>returns integer if successful
    <li><b>relateTicket( id, user, tickets, comments )</b>
      <br>id: the tracking id of the ticket
      <br>usr: the login name of person who is adding related tickets
      <br>tickets: array of ticket ids to associate this ticket to
      <br>comments: notes (optional)
		  <br>returns integer if successful
    <li><b>unrelateTicket( id, tickets, user, comments )</b>
      <br>id: the tracking id of the ticket
      <br>tickets: ticket id or array of ticket id's to remove from related tickets
      <br>user: the login name of person who is removing related tickets (optional, defaults to 'system')
      <br>comments: notes (optional)
		  <br>returns integer if successful
  </ul>
  <li><b>USER FUNCTIONS</b></li>
  <ul>
	  <li><b>getUser( usr )</b>
      <br>usr: login name of user
		  <br>returns array of usr properties
    <li><b>getName( user )</b>
      <br>usr: login name of user
      <br>returns 'firstname lastname' of user
	  <li><b>loginUser( username, password )</b>
      <br>sets $zen->usr to this username values
		  <br>returns integer if successful
	  <li><b>addUser( user, lvl, passwd, lname, fname, inits, email, notes, prefs, home )</b>
      <br>user: login name of user
      <br>lvl: default access level (defaults to NULL)
      <br>passwd: login password
      <br>lname: last name of user
      <br>fname: first name of user
      <br>inits: initials of user
      <br>email: email address of user (optional)
      <br>notes: administrative notes about account (optional)
      <br>home: default bin to open for this user (optional)
		  <br>returns integer if successful
	  <li><b>editUser( usr, params )</b>
      <br>usr: login name of user
      <br>params: indexed array of field=>new_value
		  <br>returns integer if successful
	  <li><b>addAccess( user, bins )</b>
      <br>user: login name of user
      <br>bins: indexed array of bin=>level
	    <br>returns integer - number of successful additions
    <li><b>editAccess( user, bins )</b>
      <br>user: login name of user
      <br>bins: indexed array of bin=>new_level
		  <br>returns integer - number of successful edits
    <li><b>deleteAccess( user, bins )</b>
      <br>user: login name of user
      <br>bins: array bins to remove from user access table
		  <br>returns integer - number of successful deletions
  </ul>
  <li><b>ADMIN FUNCTIONS</b>
  <ul>
	  <li><b>sendEmail( recipients, subject, message, cc, headers )</b>
       <br>recipients: string value of recipients (i.e. 'me <me@me.com' or 'me@me.com' or 'me <me@me.com>, you <you@you.com>')
       <br>subject: subject of message
       <br>cc: addresses to cc message to (optional)
       <br>headers: headers for email message (optional, defaults to 'From: zenTrack BOT <system@zenTrack.com>')
       <br>returns integer if successful
	  <li><b>getArchiveTicket( id, limit = '' )</b>
        <br>id: the tracking id of the ticket
        <br>limit: maximum number to return (optional)
			 <br>returns indexed arrays of ticket properties
	  <li><b>switchSetting( field, value, flag )</b>
        <br>field: field / name of setting
        <br>value: new value for setting
        <br>flag: set if this is a multi dimensional array( with the value name )
        <br>no return value
	  <li><b>editSetting( field, value, order, flag )</b>
      <br>field: the name of the field to edit
      <br>value: the new value
      <br>order: integer number of order to assign new value (if multi-dimensional array)
      <br>flag: change the value with the same order as order.
		  <br>returns integer if successful
    <li><b>addSetting( field, value, order )</b>
      <br>field: name to add
      <br>value: value to add
      <br>order: the order of this item (if multi-dimensional array) (optional, defaults to 'NULL' )
		  <br>returns integer if successful
	  <li><b>deleteSetting( field, value )</b>
      <br>field: name of field to delete
      <br>value: optional, match this value too before deleting
		  <br>returns integer if successful
    <li><b>cleanupTickets()</b>
       <br>not installed, optional function to include chron capabilities for monitoring and maintaining system
    </ul>
   <li><a href="#top">Top</a>
  </ul>
  <b><a name="system" style="color:<?=$zen->settings["color_alttxt"]?>">System Variables</a></b>
  <P>
  <ul>
	<li><b>$zen->params["db"]</b> - (string) database name
	<li><b>$zen->params["tb"]</b> - (string) table where tickets are stored
	<li><b>$zen->params["st"]</b> - (string) zenTrack configuration table
	<li><b>$zen->params["ut"]</b> - (string) users table name
	<li><b>$zen->params["lt"]</b> - (string) log table name
	<li><b>$zen->params["at"]</b> - (string) user access table name
	<li><b>$zen->params["atb"]</b> - (string) archived ticket table name
	<li><b>$zen->params["alt"]</b> - (string) archived log table name
  <li><b>$zen->params["login"]</b> - (string) database login
  <li><b>$zen->params["pass"]</b> - (string)  database password
  <li><b>$zen->params["database_instance"]</b> - (string) database instance
  <li><b>$zen->params["host"]</b> - (string)   database host
     <li><a href="#top">Top</a>
  </ul>
  </blockquote>
  &nbsp;
<?
  include("$libDir/footer.php");
?>
