<?

  include_once("../header.php");
  
  $expand_admin = 1;
  $section = "Admin";
  $page_title = "Administration";

  $system_name = $zen->settings["system_name"];
  if( $login_level < $zen->settings["level_settings"] ) {
     $page_tile = "Access Error";    
     $msg = "<p class='hot'>You do not have access to administrate zenTrack.</p>\n"; 
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
  $user_required = array("login","lname","initials","email");

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
    if( !$max )
      $max = 1;
    $text = "<option value=''>---</option>\n";
    for( $i=1; $i<=$max; $i++ ) {
      $s = ($i == $sel)? " selected" : "";
      $text .= "<option$s>$i</option>\n";
    }
    return $text;
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

?>