<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

   // the global functions to be available to all pages

  /**
   * Loads a global variable, just a wrapper to make this quicker and easier
   *
   * @param string $name is the variable, or if in an array, the array it is in
   * @param string $var if the first value was an array, then this one can specify which value (null=whole array)
   */
  function getGlobal( $name, $var = null ) {
    return ($var)? $GLOBALS[$name][$var] : $GLOBALS[$name];
  }

  /**
   * Retrieves an ini setting from the zen array
   *
   * @param string $section is the section in the ini file
   * @param string $name is the name of the setting, if null, returns entire section array
   * @return string
   */
  function getini( $section, $name = null ) {
    if( !$name && isset($_SESSION['zen'][$section]) ) {
      return $_SESSION['zen'][$section];
    }
    else if( $name && isset($_SESSION['zen'][$section][$name]) ) {
      return $_SESSION['zen'][$section][$name];
    }
    else if( $_SESSION['zen']['debug']['develop_mode'] > 0 ) {
      die("ini setting $section:$name doesn't exist!");        
    }
    else { return null; }
  }

  /**
   * Returns the unix timestamp representing the last config update
   */
  function lastConfigUpdate() {
    return @filemtime( getini('directories','dir_cache').'/last_config_update');
  }

  /**
   * Touched the last_config_update placeholder so that proper cache data will be updated
   */
  function configHasChanged() {
    @touch( getini('directories','dir_cache')."/last_config_upate" );
  }
}?>
