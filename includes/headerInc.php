<?
  /*
  ** headerInc.php
  **
  ** THIS PAGE SHOULD NOT BE EDITED
  **
  ** THE ONLY CONFIGURATION SET THAT SHOULD BE EDITED BY USERS
  ** IS THE header.php FILE IN THE www VIEWABLE DIRECTORY
  ** AND THE configVars.php FILE IN THE includes DIRECTORY
  **
  ** abstracts advanced header functions from the 
  ** configuration portion, for easier upgrades and
  ** less headaches
  **
  ** This page contains functions and variables which are universal
  ** to the site
  */
  
  
  /*
  **  URL DETERMINATIONS
  */
  
  $templateDir = "$libDir/templates";
  $listDir     = "$libDir/lists";
  $imageUrl    = "$rootUrl/images";
  $ticketUrl   = "$rootUrl/ticket.php";


  /*
  **  BROWSER DETERMINATIONS
  */

  if( eregi("(\[en\]|netscape)", $HTTP_USER_AGENT) ) {
     $page_browser = "ns";
  } else if( eregi("(Gecko)", $HTTP_USER_AGENT) ) {
     $page_browser = "mz";
  } else if( eregi("ie", $HTTP_USER_AGENT) ){
     $page_browser = "ie";
  }


  /*
  **  CLASS OBJECTS
  */

  include("$libDir/zenTrack.class");
  $zen = new zenTrack( $configFile, $login_id );


  /*
  **  SESSION TRACKING AND MANAGEMENT
  */

  function start_session() {
     // initiates the session, then
     // checks for the existence of
     // all the session variables to
     // be used and registers them as
     // required
		 global $PHPSESSID;
     session_start();     
     $session_vars = array(
			   "login_level",
			   "login_id",
			   "login_name",
			   "login_inits",
			   "login_bin",
			   "login_mode",
			   "login_messages"
			   );
     foreach($session_vars as $s) {
			global $$s;
			if( !session_is_registered("$s") )
	  		session_register("$s");
     }
  }
  start_session();

  /*
  **  SOME FUNCTIONS FOR USE IN
  **  PAGE CONTENT
  **  
  **  These are functions for tracking
  **  sessions and for system screen
  **  in the ticket viewing mode
  */

  function add_system_messages( $msg, $code = 'Bold' ) {
     // stores the system messages
     // in a session variable so that they
     // can be viewed later
     // $msg can be an array
     // if $code is set to Error, Highlight, or Bold
     // then the message will be formatted
     // according to the stylesheet .small[Error|Highlight|Bold] entries
     
     if( !is_array($msg) )
       $msg = array($msg);
     
     global $login_messages;
     global $system_message_limit;
     
     if( count($msg) >= $system_message_limit ) {
	unset($login_messages);
     }
     if( !is_array($login_messages) )
       $login_messages = array();
     if( count($login_messages)+count($msg) > $system_message_limit ) {
	$login_messages = array_slice( $login_messages,0,($system_message_limit - count($msg)) );
     }
     foreach( $msg as $m ) {	
	array_unshift($login_messages, array($m,time(),$code) );
     }
  }

  function print_system_messages($flag = '') {
     // prints all the system messages to
     // the screen
     // if $flag is given, then it only prints
     // up until the first greyed entry (only print new entries)
     global $login_messages;
     global $zen;
     
     if( is_array($login_messages) ) {
	foreach( $login_messages as $v ) {
	   if( $style != "smallGrey" && $v[2] ) {
	      $style = "small$v[2]";
	   } else if( $style != "smallGrey" ) {
	      $style = "smallBold";
	   }
	   if( $style == "smallGrey" && $flag )
	     break;
	   print "<br><span class='$style'>";
	   print "[".$zen->showTime($v[1])."] ";
	   print $v[0]."</span>\n";
	}
	$login_messages[0][2] = "Grey";
     } else {
	print "<span class='smallGrey'>No system messages</span>";
     }
  }

  function clear_system_messages() {
     // deletes all system messages
     global $login_messages;
     unset($login_messages);
  }

  if( $newbin == 'all' ) {
     unset($login_bin);
  } else if( $newbin && $zen->bins["$newbin"] && $zen->checkAccess($login_id,$newbin) ) {
     $login_bin = $newbin;
  }

  // security
     
  unset($vars);
  unset($msg);
  unset($errs);
  unset($mode);
  $id = ereg_replace("[^0-9]", "", $id);

  // set the page mode, for viewing tickets
  // set it to tasks, assuming that it will be
  // a project... if this is incorrect, then
  // a check in ticket_box.php will correct
  // this and make it default to 'details'
  if( $setmode ) {
     $login_mode = strtolower($setmode);
  } else if( !$login_mode ) {
     $login_mode = "tasks";
  }


  /*
  **  USER AUTHENTICATION
  **
  **  determine if a login is required
  */

  if( !eregi("(/help/|styles[.]php)",$SCRIPT_NAME) ) {
     include("$libDir/login.php");
  }     


  // used to set table cell padding (since netscape can't handle padding-top/bottom)
  $height_num = $zen->settings["font_size"]+4;
  
  
  /*
  **  TICKET NAVIGATION TABS
  */

  // these are for the ticket_box.php page.  They appear here so that
  // individual pages may alter the specific tabs displayed by editing
  // this array of values before running ticket_box.php
  //
  // $tabs are the nav boxes that will appear, and must correspond
  // to a file called ticket_[name]Box.php which is included in
  // includes/templates dir
  $tabs = array(
		"Details",
		"Log",
		"Related",		
		"Attachments",
		"System"
		);  
  
   
  /*
  **  ROLLOVER EFFECTS
  */

   $rollover_text = " onclick=\"mClk(this);\" onmouseout=\"mOut(this,'"
     .$zen->settings["color_background"]."', '');\" "
     ."onmouseover=\"mOvr(this,'"
     .$zen->settings["color_bars"]."', '');\"";

   $rollover_greytext = " onclick=\"mClk(this);\" onmouseout=\"mOut(this,'"
     .$zen->settings["color_bars"]."', '');\" "
     ."onmouseover=\"mOvr(this,'"
     .$zen->settings["color_background"]."', '');\"";

   $hotrollover_greytext = " onclick=\"mClk(this);\" onmouseout=\"mOut(this,'"
     .$zen->settings["color_bars"]."', '');\" "
     ."onmouseover=\"mOvr(this,'"
     .$zen->settings["color_highlight"]."', '');\"";
   
   $hotrollover_text = "onclick=\"mClk(this);\" onmouseout=\"mOut(this,'"
     .$zen->settings["color_background"]."', '');\" "
     ."onmouseover=\"mOvr(this,'"
     .$zen->settings["color_highlight"]."', '');\"";
   
   $nav_rollover_text = " onclick=\"mClk(this);\" onmouseout=\"mOut(this,'"
     .$zen->settings["color_title_background"]."','"
     .$zen->settings["color_title_txt"]."');\" onmouseover=\"mOvr(this,'"
     .$zen->settings["color_alt_background"]."','"
     .$zen->settings["color_alt_text"]."');\"";


  /*
  **  LISTS THAT SHOULD PROBABLY BE DYNAMIC, BUT AREN'T
  */

  $log_actions = array(
		       "ACTION",
		       "LABOR",
		       "NOTE",
		       "QUESTION",
		       "SOLUTION"
		     );


?>