<?
  
  include("../header.php");

  $helpUrl = $rootUrl."/help";
  $page_prefix = "zenTrack Help | ";
  $page_section = "Help Menu";

  /**
   * Generates navigation links showing the previous page, next
   * page, and table of contents link.
   */
  function renderNavbar( $section ) {
    // collect the correct data array
    $s = "{$section}TOC";
    global $$s;
    $list = $$s;

    // find out where we are in the list
    $thisPage = basename($_ENV['SCRIPT_NAME']);
    $keys = array_keys($list);
    $lastPage = null;
    $nextPage = null;
    for($i=0; $i<count($keys); $i++) {
      if( $keys[$i] == $thisPage ) {
	if( $i > 0 ) {
	  $lastPage = $keys[$i-1];
	}
	if( $i < count($keys)-1 ) {
	  $nextPage = $keys[$i+1];
	}
      }
    }

    print "<table width='80%' align='center'><tr>\n";

    // previous link
    print "<td align='left' width='15%'>";
    if( $lastPage ) {       
      $v = $list[$lastPage];
      print "<a href='$helpUrl/$section/$lastPage'>&lt;--</a>";
      print "&nbsp;<a href='$helpUrl/$section/$lastPage'>$v</a>";
    }
    else {
      print '&nbsp;';
    }
    print "</td>\n";

    // table of contents link
    print "<td align='center' width='70%'>\n";
    print "<a href='$helpUrl/$section/index.php'>Table of Contents</a>";
    print "</td>\n";

    // next link
    print "<td align='right' width='15%'>";
    if( $nextPage ) {
      $v = $list[$nextPage];
      print "&nbsp;<a href='$helpUrl/$section/$nextPage'>$v</a>";
      print "<a href='$helpUrl/$section/$nextPage'>--&gt;</a>";
    }
    else {
      print '&nbsp;';
    }
    print "</td>\n";

    print "</tr></table>\n";
  }

  function renderTOC( $section, $overview = false ) {
    // collect the correct data array
    $s = "{$section}TOC";
    global $$s;
    $list = $$s;

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

  $usersTOC = array(
		    "tutorial.php"     => "Tutorial",
		    "tickets.php"      => "Tickets",
		    "projects.php"     => "Projects",
		    "options.php"      => "Personal Options",
		    "notify_lists.php" => "Notify Lists",
		    "reports.php"      => "Reports"
		    );

  $adminTOC = array(
		    "behaviors.php"       => "Behaviors",
		    "bins.php"            => "Bins and Permissions",
		    "data_groups.php"     => "Data Groups",
		    "notify_lists.php"    => "Notify Lists",
		    "users.php"           => "User Maintenance",
		    "settings.php"        => "System Settings",
		    "data_types.php"      => "Data Types (standard ticket fields)",
		    "varfields.php"       => "Variable Fields (custom ticket fields)"
		    );

?>