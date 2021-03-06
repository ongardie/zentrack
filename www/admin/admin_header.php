<?

  define('ZT_SECTION', 'admin');
  include_once("../header.php");
  
  $section = "Admin";
  $page_title = tr("Administration");

  $system_name = $zen->getSetting("system_name");
  if( $zen->checkNum($login_level) < $zen->getSetting("level_settings") ) {
     $page_title = "Access Error";    
     $msg[] = tr("You do not have access to administrate zenTrack."); 
     include("$libDir/nav.php");     
     include("$libDir/footer.php");
     exit;
  }

  /*
  ** USER ADMINISTRATION COMMON FIELDS
  */
  $user_fields = array(
		       "login"    =>   "alphanum",
		       "access_level"   =>   "int",
		       "lname"    =>   "text",
		       "fname"    =>   "text",
		       "initials" =>   "alphanum",
		       "email"    =>   "email",
		       "notes"    =>   "text",
		       "homebin"  =>   "int",
		       "active"   =>   "int"
		       );
  $user_required = array("login","lname","initials");

  $access_fields = array(
			 "user_id"  =>  "int",
			 "bin_id"   =>  "int",
			 "lvl"     =>  "int",
			 "notes"   =>  "text"
			 );
  $access_required = array("user_id","bin_id");

  /*
  ** NUMBER PULLDOWN FUNCTION
  */

  function admin_number_pulldown( $max = '', $sel = '' ) {
    static $cache_pulldown;
    if( is_array($cache_pulldown) 
        && $cache_pulldown[0] == $max
          && $cache_pulldown[1] == $sel ) {
      return $cache_pulldown[2];
    }
    if( !$max )
    $max = 1;
    $text = "<option value=''>---</option>\n";
    for( $i=1; $i<=$max; $i++ ) {
      $s = ($i == $sel)? " selected" : "";
      $text .= "<option$s>$i</option>\n";
    }
    $cache_pulldown = array($max,$sel,$text);
    return $text;
  }
  
  function getPriCount( $current, $lowest ) {
    return 1 + ($current - $lowest);
  }

  /*
  ** SETTINGS ADMINISTRATION COMMON FIELDS
  */

  $settings_fields = array(
                          "name"        => "alphanum",
                          "value"       => "html",
                          "description" => "html"
                          );
  $settings_required = array("name","value");
  
  if( !isset($TODO) ) { $TODO = null; }

?>