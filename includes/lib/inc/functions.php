<?{ /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

   // the global functions to be available to all pages

  /**
   * Loads a global variable, just a wrapper to make this quicker and easier
   *
   * @param string $name is the variable, or if in an array, the array it is in
   * @param string $var if the first value was an array, then this one can specify which value (null=whole array)
   */
  function getGlobal( $name, $var = null ) {
    return ($var)? $_GLOBALS["$name"]["$var"] : $_GLOBALS["$name"];
  }

  /**
   * Sets a global variable, just a wrapper to make this quicker and easier
   *
   * @param string $name is the variable, or if in an array, the array it is in
   * @param mixed $val is the value to be assigned
   * @param string $var if the first value was an array, then this one can specify which value (null=whole array)
   */
  function setGlobal( $name, $val, $var = null ) {
    return ($var)? $_GLOBALS["$name"]["$var"] = $val : $_GLOBALS["$name"] = $val;
  }

  /**
   * Touched the last_config_update placeholder so that proper cache data will be updated
   */
  function updateConfigDate() {
    @touch( $_GLOBALS['zen']['cacheDir']."/last_config_upate" );
  }
}?>
