<?

$rootDir = dirname(dirname(__FILE__));
include_once( $rootDir."/header.php" );

$js_file = getini('directories','dir_user')."/user_javascript.js";
if( @file_exists($js_file) ) {
  include_once( $js_file );
}

?>