<?{
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
  
  /**
  * ERROR REPORTING (security)
  */
  error_reporting(E_ALL ^ E_NOTICE);
  if( !$Debug_Mode ) {
    ini_set("display_errors", false);
  }
  
  // fix problems with array indices and case of table columns
  define('ADODB_ASSOC_CASE',0);
  
  /*
  ** SESSION MANAGEMENT
  */
  include_once("$libDir/session_start.php");
  
  /*
  **  URL DETERMINATIONS
  */
  
  $templateDir = "$libDir/templates";
  $listDir     = "$libDir/lists";
  $imageUrl    = "$rootUrl/images";
  $ticketUrl   = "$rootUrl/ticket.php";
  $projectUrl  = "$rootUrl/project.php";
  
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
  
  // if these change, they will need to be changed
  // in egate_utils.php as well!
  include_once("$libDir/translator.class");
  include_once("$libDir/zenTrack.class");
  include_once("$libDir/zenTemplate.class");
  
  $zen = new zenTrack( $configFile );
  
  /**
  * Translator Object Initialization (mlively)
  */
  // set language to default if unspecified 
  if( !$login_language ) {
    $login_language = $zen->settings["language_default"];
  }
  
  //Create the initialization array for the translator object
  //this data set also appears in the egate_utils.php script
  $translator_init = array(
  'domain' => 'translator',
  'path' => "$libDir/translations",
  'locale' => $login_language
  );
  $translator_init['zen'] =& $zen;
  tr($translator_init);
  //save a bit on memory
  unset($translator_init);
  
  function uptr($string, $vals = '') {
    return strtoupper(tr($string,$vals));
  }
  
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
      $login_messages = array_slice( $login_messages,0,
      ($system_message_limit - count($msg)) );
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
      $i = 0;
      foreach( $login_messages as $v ) {
        if( $style != "smallGrey" && $v[2] ) {
          $style = "small$v[2]";
        } else if( $style != "smallGrey" ) {
          $style = "smallBold";
        }
        $login_messages[$i][2] = "Grey";
        if( $style == "smallGrey" && $flag )
        break;
        print "<br><span class='$style'>";
        print "[".$zen->showTime($v[1])."] ";
        print $v[0]."</span>\n";
      }  
    } else {
      print "<span class='smallGrey'>No system messages</span>";
    }
  }
  
  function clear_system_messages() {
    // deletes all system messages
    global $login_messages;
    unset($login_messages);
  }
  
  function getVarfieldDataType( $varfieldName ) {
    $varfieldName = strtolower($varfieldName);
    preg_match('/^custom_([a-z]+)[0-9]+$/', $varfieldName, $matches);
    return isset($matches[1])? $matches[1] : null;
  }
  
  function genVarfield( $formName, $varfield, $value = '' ) {
    // generates html form element to represent
    // the variable field array
    global $zen;
    global $rootUrl;
    
    // clean data
    $value = $zen->ffv($value);
    
    // determine the data type
    $type = getVarfieldDataType($varfield['field_name']);
    
    $onblur = "";
    if( $varfield['js_validation'] ) {
      $onblur = " onblur='{$varfield['js_validation']}'";
    }
    
    $key = $varfield['field_name'];
    
    $zen->addDebug('headerInc', "genVarfield( '$formName', "
       +"'$varfield', '$value' ) using type=$type and key=$key", 3);
    
    switch( $type ) {
      case "boolean":
        $inp = "<input type='checkbox' name='{$key}' "
        ." value='1'";
        $inp .= $value? " checked>\n" : ">\n";
        break;
      case "string":
        $inp = "<input type='text' name='{$key}' "
        ." value='{$value}' size='20' maxlength='250'{$onblur}>\n";
        break;
      case "text":
        $inp = "<textarea name='{$key}' cols='50' "
        ." rows='4'{$onblur}>{$value}</textarea>";
        break;
      case "date":
        // format for use in date
        if( $value == 'NULL' ) { $value = ''; }
        if( $value == 0 ) { $value = ""; }
        if( strlen($value) && preg_match("/^[0-9]+$/", $value) ) { 
          $value = $zen->showDateTime($value); 
        }
        // create input field and date picker
        $inp = "<input type='text' name='{$key}' "
          ." value='{$value}' size='20' maxlength='250'{$onblur}>\n"
          ." <img name='date_button' src='{$rootUrl}/images/cal.gif' "
          ."  onClick=\"popUpCalendar(this, document.{$formName}.{$varfield['field_name']}, '"
          .$zen->popupDateFormat()." 00:00')\"\n"
          ."  alt='".tr("Select a Date")."'>\n";
          break;
      case "number":
        if( $value == 'NULL' ) { $value = ''; }
        $inp = "<input type='text' name='{$key}' "
        ." value='{$value}' size='10' maxlength='100'{$onblur}>\n";      
        break;
      case "menu":
        $opts = genDataGroupChoices($varfield['field_value']);
        $inp = "<select name='{$key}'{$onblur}>\n";
        if( !$varfield['is_required'] && (count($opts)!=1 || strlen($opts[0]['field_value'])) ) {
          $inp .= "<option value=''>---</option>\n";
        }
        $val_picked = false;
        foreach($opts as $o) {
          if( strlen($value) && !$val_picked && $o['field_value'] == $value ) {
            $val_picked = true;
            $sel = " selected";
          }
          else { $sel = ""; }
          $inp .= "<option value='{$o['field_value']}'$sel>{$o['label']}</option>\n";
        }
        if( !$val_picked && strlen($value) ) {
          $inp .= "<option value='".$zen->fixJsVal($value)."' selected>$value(invalid)</option>\n";
        }
        $inp .= "</select>\n";
        break;
      default:
        $inp = "-invalid_field_type($type)-";
        break;
    }
    return $inp;
  }
  
  function genDataGroupChoices( $group_id, $use_default = true ) {
    if( isset($_SESSION['data_groups']["$group_id"]) ) {
      // get the fields for our group
      $group = $_SESSION['data_groups']["$group_id"];
      if( $group['eval_type'] == 'Matches' ) {
        if( count($group['fields']) ) {
          return $group['fields'];
        }
      }
    }
    
    // generate a mock field
    if( $use_default ) {
      return array( array('field_value'=>'', 'label'=>'---') );
    }
    else {
      return array();
    }
  }
  
  if( isset($newbin) && $newbin == 'all' ) {
    unset($login_bin);
  } else if( isset($newbin) && $newbin && $zen->bins["$newbin"] && $zen->checkAccess($login_id,$newbin) ) {
    $login_bin = $newbin;
  }
  
  // security
  $onLoad = array();
  $vars = array();
  $msg = array();
  $errs = "";
  $mode = "";
  if( isset($id) ) {
    $id = ereg_replace("[^0-9]", "", $id);
  }
  
  // used to set table cell padding (since netscape cant handle padding-top/bottom)
  $height_num = $zen->settings["font_size"]+4;
  
  // function to retrieve the available languages from the translations/ dir  
  function get_languages_available() { 
    global $libDir;
    $dir = opendir("$libDir/translations");
    $vals = array();
    while( false !== ($file = readdir($dir)) ) {
      if( preg_match("/\.trans$/",$file) ) {
        $vals[] = basename($file, ".trans");
      }
    }
    closedir($dir);
    return $vals;
  }
  
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
    "details"     => tr("Details"),
    "custom"      => tr($zen->settings['varfield_tab_name']),
    "log"         => tr("Log"),
    "notify"      => tr("Notify"),
    "contacts"    => tr("Contacts"),
    "related"     => tr("Related"),     
    "attachments" => tr("Attachments"),
    "system"      => tr("System")
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
  **  USER AUTHENTICATION
  **
  **  determine if a login is required
  */
  
  if( !eregi("(/help/|styles[.]php|behavior_js[.]php)",$SCRIPT_NAME) ) {
    include_once("$libDir/login.php");
  }     
  
  /**
  * Generate group info, since it takes several queries
  * This array is reset when a logoff occurs, so make sure this
  * is after the login include
  */
  if( !array_key_exists('data_groups', $_SESSION) || !$_SESSION['data_groups'] ) {
    $_SESSION['data_groups'] = $zen->generateDataGroupInfo();
  }
  
  /**
  * The list of valid log action types
  */
  $log_actions = $zen->getActivities();
  
  // help links
  // determine which directory contains
  // our current translation (if one exists)
  $helpBase = $rootUrl."/help";
  $helpLang = $_SESSION['login_language'];
  if( !@is_dir("$rootWWW/help/$helpLang") ) {
    // it may be that we have languages which are not
    // translated to the help section yet, so switch
    // these back to english, which is better than nothing
    $helpLang = 'english';
  }
  $helpUrl = "$helpBase/$helpLang";
  $helpDir = "$rootWWW/help/$helpLang";
  
  // you can't have any spaces after this closing tag!
}?>