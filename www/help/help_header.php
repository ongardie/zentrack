<?
  
  $b = dirname(__FILE__);
  include(dirname($b)."/header.php");

  $page_prefix = tr("zenTrack Help | ");
  $page_section = tr("Help Menu");
  
  // determine which directory contains
  // our current translation (if one exists)
  $helpBase = $rootUrl."/help";
  $l = $_SESSION['login_language'];
  if( @is_dir("$b/$l") ) {
    $helpUrl = $helpBase."/$l";
    $helpDir = $b."/$l";
  }
  else {
    $helpUrl = $helpBase."/english";
    $helpDir = $b."/english";
  }
  // store our directory links in the global scope
  // for functions and pages
  $GLOBALS['helpDir'] = $helpDir;
  $GLOBALS['helpBase'] = $helpBase;
  $GLOBALS['helpUrl'] = $helpUrl;
  
  /**
   * Generates navigation links showing the previous page, next
   * page, and table of contents link.
   */
  function renderNavbar( $section ) {
    // make a pretty label for the section
    $sectionName = tr( ucwords($section)." Index" );
    
    // collect the correct data array
    $s = "{$section}TOC";
    $list = $GLOBALS[$s];
    $helpUrl = $GLOBALS['helpUrl'];
    $helpBase = $GLOBALS['helpBase'];

    // find out where we are in the list
    $thisPage = basename($_ENV['SCRIPT_NAME']);
    $keys = array_keys($list);
    $lastPage = null;
    $nextPage = null;
    if( $thisPage == 'index.php' ) {
      // if we are on the index page, the first
      // key is the next to view
      $nextPage = $keys[0];
    }
    else {
      // otherwise, we will look through the keys,
      // find ours, then create our elements from there
      for($i=0; $i<count($keys); $i++) {
        if( $keys[$i] == $thisPage ) {
          // this is our guy
          if( $i > 0 ) {
            // only if we aren't on the first page
            // the index is already shown as a menu choice
            $lastPage = $keys[$i-1];
          }
          if( $i < count($keys)-1 ) {
            // only if this isn't the last page
            $nextPage = $keys[$i+1];
          }
        }
      }
    }

    print "<table width='80%' align='center'><tr>\n";

    // previous link
    print "<td align='left' width='25%'>";
    if( $lastPage ) {       
      $v = $list[$lastPage];
      print "<b><a href='$helpUrl/$section/$lastPage'>&lt;&lt;</a></b>";
      print "&nbsp;<a href='$helpUrl/$section/$lastPage'>$v</a>";
    }
    else {
      print '&nbsp;';
    }
    print "</td>\n";

    // table of contents link
    print "<td align='center' width='50%'>\n";
    print "<a href='$helpUrl/$section/index.php'>$sectionName</a>&nbsp;|&nbsp;";
    print "<a href='$helpBase/index.php'>Help Index</a>";
    print "</td>\n";

    // next link
    print "<td align='right' width='25%'>";
    if( $nextPage ) {
      $v = $list[$nextPage];
      print "<a href='$helpUrl/$section/$nextPage'>$v</a>";
      print "&nbsp;<b><a href='$helpUrl/$section/$nextPage'>&gt;&gt;</a></b>";
    }
    else {
      print '&nbsp;';
    }
    print "</td>\n";

    print "</tr></table>\n";
  }

  function renderTOC( $section, $overview = false ) {
    // determine what language we are speaking and if
    // a translation exists
    $helpUrl = $GLOBALS['helpUrl'];
    
    // collect the correct data array
    $s = "{$section}TOC";
    $list = $GLOBALS[$s];

    // output the list
    print "<ul>\n";
    $b = '';
    if( $overview ) {
      print "<a href='$helpUrl/$section/index.php'>Overview</a>\n";
      $b = '<br>';
    }
    foreach($list as $page=>$name) {
      print "$b<a href='$helpUrl/$section/$page'>$name</a>\n";
      if( !$b ) { $b = '<br>'; }
    }
    print "</ul>\n";
  }

  /**
   * Do not edit these values for translation.  Simply edit the appropriate
   * language files instead.
   */
  $usersTOC = array(
		    "tutorial.php"     => tr("Tutorial"),
		    "tickets.php"      => tr("Tickets"),
		    "projects.php"     => tr("Projects"),
		    "options.php"      => tr("Personal Options"),
		    "notify_lists.php" => tr("Notify Lists"),
        "contacts.php"     => tr("Contacts"),
		    "reports.php"      => tr("Reports")
		    );

  $adminTOC = array(
		    "behaviors.php"       => tr("Behaviors"),
		    "bins.php"            => tr("Bins and Permissions"),
		    "data_groups.php"     => tr("Data Groups"),
		    "data_types.php"      => tr("Data Types (standard ticket fields)"),
		    "varfields.php"       => tr("Variable Fields (custom ticket fields)"),
		    "notify_lists.php"    => tr("Notify Lists"),
		    "users.php"           => tr("User Maintenance"),
		    "settings.php"        => tr("System Settings")
		    );

   $GLOBALS['usersTOC'] = $usersTOC;
   $GLOBALS['adminTOC'] = $adminTOC;
        
?>