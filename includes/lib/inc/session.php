<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

  /**
   * @package Libs
   *
   * Initializes session and prepares common session variables
   */

  // benchmarking
  startPTime( "session.php" );

  // initialize all session data
  session_start();

  // set the zen variable
  if( !isset($_SESSION['zen']) ) { $_SESSION['zen'] = null; }

  // set the config update time
  if( !isset($_SESSION['configLastUpdated']) )
    $_SESSION['configLastUpdated'] = 0;

  /** Clears and initializes the session data */
  function clearZenSessionCache() {
    /** @global array $_SESSION['cache'] stores data types and settings to be used by all pages */
    $_SESSION['cache'] = array();
    
    // set up the type data
    $_SESSION['cache']['data_types'] = null;
    
    // store the common settings used by most pages
    $_SESSION['cache']['common_settings'] = null;    
    
    // store the MessageListConfig (parsed from debug.xml)
    $_SESSION['cache']['messageListConfig'] = null;
  }

  if( !isset($_SESSION['cache']) || $_SESSION['cache'] == null ) clearZenSessionCache();

  // set up the login data
  if( !isset($_SESSION['login']) ) {
    $_SESSION['login'] = array(
                               "name" => "",
                               "inits" => "",
                               "level" => null,
                               "id" => null,
                               "email" => "",
                               "bins"=> array(),
                               "access" => array()
                               );
  }

  endPTime('session.php');

}?>
