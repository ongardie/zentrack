<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** @package Setup */
class ZenTargets {

  /**
   * CONSTRUCTOR - loads config data files
   *
   * @param array (associative) $ini_array is the ini file parsed by ZenUtils::read_ini()
   * @param boolean $supress_config_dialog prevents confirmation messages from appearing (answers yes to all)
   */
  function ZenTargets( $ini_array, $supress_confirm_dialog = false ) {
    $this->_supress = $supress_confirm_dialog;
    $this->_installdir = dirname(dirname(__FILE__));
    $this->_printHeading();
    $this->_dirs = $this->_parseConfigData("directories");
    $this->_configFiles = $this->_parseConfigData("configFiles");
    $this->_ini = $ini_array;
  }

  /**
   * takes arguments and parses
   *
   * The arguments contain the following format
   *   zen.php [--ini_file=zen.ini] -target arg1 arg2 arg3
   *
   * @param array $args is the user provided arguments
   * @return boolean arguments were valid
   */
  function args( $args ) {
    $this->_targets = array();
    $ini = "zen.ini";
    $n = "";    
    foreach($args as $a) {
      $a = trim($a);
      if( preg_match("/^--/", $a, $matches) ) {
        // ignore these
      }
      else if( preg_match("/^-([^ ]+)/", $a, $matches) ) {
	$n = $matches[1];
	if( !method_exists($this, "_$n") ) {
	  print "Invalid method ($n) specified, exiting.";
	  return false;
	}
	$this->_targets[$n] = array();
      }
      else {
	if( $n == "" ) {
	  print "A valid target must be specified before providing params, exiting.";
	  return false;
	}
	$this->_targets[$n][] = $this->_parseArg($a);
      }      
    }
    if( !is_array($this->_ini) ) {
      print "The ini file ($ini) was not found or not readable, exiting.";
      return false;
    }
    return true;
  }

  /**
   * Parses an argument
   *
   * @param string $arg
   * @return mixed parsed result
   */
  function _parseArg( $arg ) {
    if( $arg == "true" ) {
      return true;
    }
    else if( $arg == "false" ) {
      return false;
    }
    else if( preg_match("/^[0-9]+$/", $arg) ) {
      return intval($arg);
    }
    else if( $arg == "null" ) {
      return null;
    }
    else {
      return $arg;
    }
  }

  /**
   * Validates and executes each target
   *
   * @return boolean all targets succeeded
   */
  function run() {
    if( !count($this->_targets) ) {
      print "\nNo targets found.  Exiting.";
      return false;
    }
    foreach( $this->_targets as $target => $tmp ) {
      $u = strtoupper( $target );
      if( $this->_target( $target ) ) {
	print "$u completed\n\n";
      }
      else {
	$this->_printerr("run", "$u failed.\n");
	return false;
      }
    }
    return true;
  }

  /**
   * Runs a target (if valid)
   *
   * @param string $target name of the target to run
   * @return boolean target succeeded
   */
  function _target( $target ) {
    $u = strtoupper($target);
    $target = strtolower($target);
    print "Initiating $u...\n";
    $p = $this->_getParm($target,0);

    //todo
    //todo
    //todo add a target for test_config that will run tests on config file contents
    //todo make this fxn fairly independant of the config's contents
    //todo

    switch($target) {
    case "backup_all":        return $this->_backup_all();
    case "backup_config":     return $this->_backup_config();
    case "backup_database":   return $this->_backup_database();
    case "changed_config":    return $this->_changed_config();
    case "check_directories": return $this->_check_directories( $p );
    case "check_permissions": return $this->_check_permissions();
    case "clean_cache_data":  return $this->_clean_cache_data();
    case "copy_class_files":  return $this->_copy_class_files( $p );
    case "copy_config_files": return $this->_copy_config_files( $this->_getBooleanParm($target,0,false) );
    case "create_database":   return $this->_create_database();
    case "cvs_update":        return $this->_cvs_update();
    case "extra_secure_mode":
      {
        $p2 = $this->_getParm($target, 1);
        if( !$p || !$p2 ) {
          print "   Usage: zen.php  [--config_file=zen.ini] -$target apache_user apache_group\n";
          print "   You must be super user to run this command\n";
          return false;
        }
        return $this->_extra_secure_mode( $p, $p2 );
      }
    case "full_install":      return $this->_full_install();
    case "merge_template_file":    return $this->_merge_template_file( $p );
    case "prepare_install_files": 
      {
        $p2 = $this->_getParm($target,0);
        if( !$p || !$p2 ) {
          print "   Usage: zen.php [--config_file=zen.ini] -$target source destination\n";
          return false;
        }
        return $this->_prepare_install_files( $p, $p2 );
      }
    case "try_db_connection":
      {
	if( count($this->_targets[$target]) < 5 ) {
          print_r($this->_targets);
          print "   Usage: zen.php [--config_file=zen.ini] -$target type host instance user password\n";
          print "   Where type is the db type, such as mysql, pgsql, oci8po, etc (see zen.ini for details)\n";
          print "   Where host can be localhost or possibly '', and instance is the database name, or TNS file for oracle\n";
	  return false;
	}
	return $this->_try_db_connection( $p, $this->_getParm($target, 1),
                                          $this->_getParm($target, 2), 
                                          $this->_getParm($target, 3),
                                          $this->_getParm($target, 4));
      }
    case "update_db_schema":
      {
        if( !$p ) {
          print "   Usage: zen.php [--config_file=zen.ini] -$target new_schema.xml [true|false]\n";
          print "   Where true|false is 'actually do it' vs. just preview it\n";
          return false;
        }
        return $this->_update_db_schema( $p, $this->_getBooleanParm($target, 1, false) );
      }
    case "upgrade":
      {
        if( !$p ) {
          print "   Usage: zen.php [--config_file=zen.ini] -$target old_version\n";
          print "   Where old_version is the version you want to upgrade from\n";
          return false;
        }
        return $this->_update( $p );
      }
    case "verify_db_connection":
      {
        return $this->_verify_db_connection();
      }
    default:
      {
	print "\n$u was an invalid target: ignored\n";
	return false;
      }
    }
  }

  /***********************************************
   ****   TARGETS
   **********************************************/

  /**
   * Backs up all config files, attachments, database content, and other relative info
   */
  function _backup_all() {
    // we will retrieve a directory ahead of time,
    // overriding the defaults for each process
    // to cause all of the backups to go to the same
    // directory (for sanity) in case they overlap
    // in minutes/hours

    $success = true;
    // backup config
    if( !$this->_backup_config() ) { $success = false; }

    // backup attachments
    if( !$this->_backup_attachments() ) { $success = false; }

    // backup database
    if( !$this->_backup_database() ) { $success = false; }

    // backup user files
    if( !$this->_backup_userfiles() ) { $success = false; }

    return $success;
  }

  /**
   * Back up all configuration files to includes/backup/YYYY-mm-dd-hh-mm/config
   *
   * Note that this backup will not fail if source files do not exist.  It will only fail if they
   * exist and cannot be copied.
   *
   * @return boolean all backups successful
   */
  function _backup_config() {
    $success = true;

    $dest = "includes/config";
    print "- Backing up config files to ".$this->_getBackupLocation()."/$dest\n";
    foreach( $this->_configFiles as $c) {
      // split the array
      list($sect,$var,$name,$is_tmplt,$permissions) = $c;

      // set up source
      $source = $this->_ini[$sect][$var];
      
      // backup and check for errors
      if( !$this->_backup_file($name, $source, $dest) ) {
        $success = false;
      }
    }
    return $success;
  }

  /**
   * Back up a file.  Will create necessary directories.
   *
   * @param string $name the name of file
   * @param string $source the source directory (without filename)
   * @param string $dest the backup directory (this is the subdirectory under backup only)
   * @return boolean returns false only if source exists and copy failed, otherwise true
   */
  function _backup_file($name, $source, $dest = '') {
    // get base backups directory
    $base = $this->_getBackupLocation();

    // make sure the subdirectory exists
    // by getting each piece and
    // creating if necessary
    $des = preg_split('#[\\\\/]#', $dest);
    $dir = "";
    foreach( $des as $d ) {
      $dir .= $dir? "/$d" : $d;
      if( $dir && !@is_dir("$base/$dir") ) {
        mkdir( "$base/$dir", 0700 );
      }
    }

    // put it together into complete directory
    $dest = $dest? $base."/".$dest : $base;

    // create the destination file
    $dest .= "/$name";
    
    // create the source file
    $source = $source."/$name";
    
    // if no source, return gracefully
    if( !file_exists($source) ) {
      print "   S $source not found: skipped\n";
      return true;
    }
    
    // copy file
    print "   B $dest\n";      
    if( !copy( $source, $dest ) ) {
      $this->_printerr("_backup_file", "Backup of $file failed");
      return false;
    }
    @chmod( $dest, 0600 );
    return true;
  }
  
  /**
   * Back up database files
   */
  function _backup_database() {
    //todo
    print "- Backing up database contents\n";

    // create directory if not done yet
    $dir = $this->_getBackupLocation()."/database";

    print "   NOT YET FUNCTIONAL\n";
    return true;
  }

  /**
   * Back up attachments
   *
   * @return bolean
   */
  function _backup_attachments() {
    print "- Backing up attachments\n";

    $src = $this->_ini['directories']['dir_attachments'];
    return $this->_backup_directory( $src, 'includes/attachments', true );
  }

  /**
   * Back up any files contributed by user
   */
  function _backup_userfiles() {
    print "- Backing up userfiles\n";

    $src = $this->_ini['directories']['dir_user'];
    $dest = "includes/user";
    return $this->_backup_directory( $src, $dest, true );
  }

  /**
   * Validates backup directory (creates if needed) 
   * and returns correct path for backups
   *
   * This is a static var so that multiple directories 
   * will not be created if our target runs over a minute
   */
  function _getBackupLocation() {
    static $dir;
    if( !$dir ) {
      $dir = $this->_ini['directories']['dir_backups']."/".date("Y-m-d-h-m");
      if( !@is_dir($dir) ) { @mkdir($dir, 0700); }
    }
    return $dir;
  }

  /**
   * Backups up files from $src to $dest, if $recurse = true, do subdirectories too
   */
  function _backup_directory( $src, $dest, $recurse = false ) {
    $success = true;
    $subdirs = array();
    $fulldest = $this->_getBackupLocation().'/'.$dest;
    if( !@is_dir($fulldest) ) {
      if( !@mkdir($fulldest) ) {
        $this->_printerr("_backup_directory", "Unable to create destination: $fulldest");
        return false;
      }
      if( !@chmod( $fulldest, 0700 ) ) {
        $this->_printerr("_backup_directory", "Unable to set permissions on destination: $fulldest");
      }
    }
    // load the files
    $dh = @opendir( $src );
    if( !dh ) {
      $this->_printerr("_backup_directory", "Could not open source directory: $src");
      return false;
    }
    while( ($file = readdir($dh)) == true ) {
      // only backup files which do not start with . and don't try to backup directory names
      if( !(strpos($file, ".") === 0) && !@is_dir($file) ) {
        if( !$this->_backup_file( $file, $src, $dest ) ) {
          $success = false;
        }
      }
      else if( $recurse && !(strpos($file, ".") === 0) && @is_dir($file) ) {
        // save subdirectories for recursion (if enabled)
        // only process one at a time to prevent
        // opening numerous directory handles at once
        // and also to produce tidy output to stdout
        $subdirs[] = $file;
      }
    }
    // recurse if needed
    if( $recurse && count($subdirs) > 0 ) {
      foreach( $subdirs as $s ) {
        if( !$this->_backup_directory( $src."/$s", $dest."/$s", true ) )
          $success = false;
      }
    }
    return $success;
  }


  /**
   * Performs the appropriate updates after config settings are changed
   *
   * This does not move directories... i.e. if you change the location of the 
   * includes directory, you must move the files accordingly, before running this
   * target
   */
  function _changed_config() {
    print "- Validating and updating to match new config settings\n";

    // check directory structure and permissions
    if( !$this->_check_directories( false ) ) {
      $this->_printerr("_changed_config", "Directory structure is not valid.  File structure and config settings must match");
      return false;
    }
    $this->_check_permissions();

    // check database connection
    if( !$this->_verify_db_connection( $this->_ini['db']['db_host'], $this->_ini['db']['db_instance'],
                                       $this->_ini['db']['db_user'], $this->_ini['db']['db_password'] ) ) {
      $this->_printerr("_changed_config", "DB Connection failed, please check your settings");
      return false;
    }

    // parse and update header.php file
    print "   Creating new header.php file\n";
    $f = $this->_ini['paths']['path_www']."/header.php";
    $res = false;
    if( !file_exists($f) || $this->_confirm("Replace header.php file?", null, 'y') == 'y' ) {
      $bulk = ZenUtils::flatten_array($this->_ini);
      $tpl = new ZenTemplate("defaults/header.php.template", true);
      $tpl->values($bulk);
      $fp = @fopen($f,"w");
      if( $fp ) {
        if( !@fputs($fp, $tpl->process()) ) {
          $res = false;
        }
        else {
          $res = @fclose($fp);
        }
      }
      else { $res = false; }
    }
    else {
      print "   WARNING: $f could not be updated, you may need to manually update this file\n";
    }

    // update the last_config_update counter
    touch( $this->_ini['directories']['dir_cache']."/last_config_update" );
    chmod( $this->_ini['directories']['dir_cache']."/last_config_update", 0766 );

    // clean out all cache data
    if( !$this->_clean_cache_data ) {
      print "   The changed_config target has completed successfully; however, cache data could not be cleared.\n";
      print "   Please login as an administrator and run install.php -clean_cache_data\n";
    }

    return true;
  }

  /**
   * Check directory structures and create any missing directories
   *
   * @param boolean $create create any if missing
   * @return boolean structure is validated
   */
  function _check_directories( $create = true ) {
    print "- Checking directory structure\n";
    $success = true;

    // read each directory (from the data file)
    foreach($this->_dirs as $d) {
      // split up the array
      list($sect,$root,$dir,$chmod) = $d;

      // set up the filename
      $file = $this->_ini[$sect][$root];

      // if the $dir portion was blank, just create the ini file directory
      if( strlen($dir) ) { $file .= "/".$dir; }

      // do the work here
      if( !$this->_checkDir( $file, $create, $chmod ) ) {
        $success = false;
      }
    }
    
    return $success;
  }
  
  /**
   * Runs through the directory structure and tries to set the correct permissions on each folder
   *
   * @param boolean $securemode use secure settings (must be logged in as superuser, also next required if this is set)
   * @param string $apachegroup the group to chgrp the files to
   */
  function _check_permissions( $securemode = false, $apachegroup = null ) {
    if( $securemode ) {
      $dirs = $this->_parseConfigData("securedirs");
      print "- Setting strict directory permissions\n";
    }
    else {
      $dirs = $this->_dirs;
      print "- Setting directory permissions\n";
    }
    $success = true;    
    
    // read each file
    foreach($dirs as $d) {
      // split up the params
      list($sect,$root,$dir,$chmod) = $d;

      // get the filename
      $file = $this->_ini[$sect][$root];
      if( strlen($dir) ) { $file .= "/".$dir; }

      // tell the user what is going on
      print "   P $chmod ".($securemode? $apachegroup.' ':'')."$file\n";

      // here we perform the chmod command... 
      // it is necessary to execute it in an eval statement
      // because the chmod value must be an octal... nothing
      // I have tried to convert the string to an octal works.. 
      // so here we are
      if( !eval("return @chmod( '$file', $chmod );") ) {
        $this->_printerr("_check_permissions","Unable to set permissions: $file");
        $success = false;
      }
      if( $securemode && !@chgrp($file, $apachegroup) ) {
        $this->_printerr("_check_permissions", "Unable to chgrp for $file to $apachegroup, are you sure you are superuser?");
        $success = false;
      }
    }
    return $success;
  }

  /**
   * Removes all cache files, updates the last_config_update file (to clean config caching)
   *
   * Does not remove attachments from the cache
   */
  function _clean_cache_data( $subdir = null ) {
    $success = true;
    print "- Cleaning cache data (you may need a superuser login to do this successfully)\n";

    // get a list of directories
    $dh = @opendir($this->_ini['directories']['dir_cache']);
    if( !$dh ) {
      $this->printerr("_clean_cache_data", "Unable to read cache directory");
      return false;
    }
    $dirs = array();
    while( $d = readdir($dh) ) {
      $dir = $this->_ini['directories']['dir_cache']."/".$d;
      // ignore system directories and files
      // ignore attachments directory
      // ignore file names
      if( strpos($d,".") === 0 || $d == "attachments" || !@is_dir($dir) ) { continue; }
      else { $dirs[] = $dir; }
    }
    closedir($dh);

    // loop directories and process
    foreach($dirs as $d) {
      if( !$this->_clean_recursively($d) ) { $success = false; }
    }

    // update the last_config_update file
    touch( $this->_ini['directories']['dir_cache']."/last_config_update" );

    return $success;
  }

  /**
   * Copies required zen classes to the install directory (for installation packages and cvs setups)
   *
   * @param string $dir is the diretory to copy class files from (optional)
   * @return boolean found and copied
   */
  function _copy_class_files( $dir = null ) {
    print "- Copying class files\n";

    // get the class directory
    if( !$dir ) {
      $dir = $this->_find_classes_directory();
    }
    if( !$dir ) {
      $this->_printerr("_copy_class_files", "Cannot find class files for copy");
      return false;
    }
    else if( !@is_dir($dir) ) {
      $this->_printerr("_copy_class_files", "Supplied directory($dir) is invalid");
      return false;
    }

    $installdir = $this->_installdir;
    print "   Copying from $dir to $thisdir\n";

    // copy the files specified in data file
    $success = true;

    // we don't use _parseConfigData() here because the ZenUtils class may not exist yet(we're copying it)
    $files = file( "$installdir/setup/classFiles" );
    foreach($files as $f) {
      $fn = trim($f);
      if( !strlen($fn) || strpos($fn, '#') === 0 ) { continue; }
      print "   C $fn\n";
      if( !@copy("$dir/$fn", "$installdir/setup/$fn") ) {
        $this->_printerr("_copy_class_files", "Unable to copy: $dir/$fn -> $installdir/$fn");
        return false;
      }
    }

    return $success;
  }

  /**
   * Merges config files with existing settings.. copies config files for all regular files
   * all template files will be parsed and the existing values substituted where possible
   *
   * If replace is set to true, then the current zen.ini file (from this install directory) will
   * be used to fill values as possible, to reduce the user configuration as much as possible.
   *
   * @param string $dest the full path and filename to be created
   * @param string $fallback if provided and $dest doesn't exist, this will be used instead
   * @param boolean $replace if true, then the destination will be replaced instead of merged
   */
  function _merge_template_file( $dest, $replace = false ) {
    //todo
    //todo
    //todo
    //todo change all the templates in defaults/ directory to use default= values
    $file = basename($dest);
    $tmplt = $this->_installdir."/defaults/{$file}.template";
    
    if( !@file_exists($tmplt) ) {
      $this->_printerr('_merge_template_file', "Template file ($tmplt) not found, cannot continue");
      return false;
    }

    // print out what is taking place
    // get our variables from the correct source
    if( file_exists($dest) && !$replace ) {
      print "   M $dest\n";
      $vals = $this->_stripConfigVals($dest);
    }
    else {
      if( file_exists($dest) ) { 
        print "   R $dest\n";
      }
      else {
        print "   C $dest\n";
      }
      $vals = ZenUtils::flatten_array($this->_ini);
    }

    $template = new ZenTemplate( $tmplt, true );
    $template->values($vals);
    $newtext = $template->process();

    $fp = fopen($dest, 'w');
    if( !$fp ) { 
      $this->_printerr('_merge_template_file', "Unable to write to $dest");
      return false;
    }
    fwrite($fp, $newtext);
    fclose($fp);
    @chmod( $dest, 0755 );
    
    return true;
  }

  /**
   * Strips out the values of a config file
   * and makes an array from them
   *
   * @param string $file complete path and filename
   * @return array mapped (String)property->(mixed)value
   */
  function _stripConfigVals( $file ) {
    $contents = file($file);
    $vals = array();
    foreach($contents as $c) {
      if( preg_match("/\\$(a-zA-Z0-9_) *= *[\"']?([^\"';]+)/", $c, $matches) ) {
        $n = $matches[1];
        $vals[$n] = trim($matches[2]);
      }
    }
    return $vals;
  }

  /**
   * Copies config files to the appropriate locations.
   *
   * If copy_config_files finds that the file already exists, one of three options will be presented:
   * <ul>
   *    <li>merge - this will extract any existing values from old file into the new file (recommended)
   *    <li>replace - this will overwrite the old file
   *    <li>skip - this will leave the old file and ignore any updates (if unsure, do not use this)
   * </ul>
   *
   * @param boolean $overwrite if set to true, will automatically merge existing config files (backed up)
   * @return boolean success
   */
  function _copy_config_files( $overwrite = false ) {    
    print "- Copying new config files\n";
    $success = true;    

    // get a single-dimension array from ini vals
    $bulk = ZenUtils::flatten_array($this->_ini);

    // run through these files
    foreach( $this->_configFiles as $c) {
      // split up the array
      list($sect,$var,$file,$is_tmplt,$permissions) = $c;

      // set up destination directory
      $dest = $this->_ini[$sect][$var];

      // get source directory
      $source = $this->_installdir."/defaults";

      // check directory structure
      if( !@is_dir($source) ) {
        $this->_printerr('_copy_config_files', "$source directory does not exist, cannot create config file");
        return false;
      }
      if( !@is_dir($dest) ) {
        $this->_printerr('_copy_config_files', 
                         "$dest directory does not exist, try running 'install.php -check_directories true'");
        return false;
      }

      // set up file names
      $dest .= "/".$file;
      $source .= $is_tmplt? "/$file.template" : "/$file";

      if( file_exists($dest) && !$overwrite ) {
        // if this file exists, we will ask for confirmation
        // if it is a template, we will try to merge it
        // if not we either replace or skip
        $choices = $is_tmplt? array('m','r','s') : array('r','s');
        $choicetext = $is_tmplt? "merge, replace, or skip" : "replace or skip";
        $choice = $this->_confirm("   $file exists, $choicetext?", $choices, 'm');
      }
      else if( file_exists($dest) && $overwrite ) {
        // we will automagically merge or replace
        // if the overwrite flag is set
        $choice = $is_tmplt? "m" : "r";        
      }
      else {
        // if the file doesn't exist then
        // we create it
        $choice = "c";
      }

      // check overwrite
      if( !file_exists($dest) || $overwrite || $choice != 's' ) {
        // create display text
        $choice = strtoupper($choice);
        switch($choice) {
        case 'M':          
          $ctext = 'Merge';
          break;
        case 'R':
          $ctext = 'Replace';
          break;
        default:
          $ctext = 'Create';
        }
        // if the file exists, we back it up
        if( file_exists($dest) ) {
          // figure out where to put the backup
          switch($var) {
          case 'dir_config':
            $to = 'includes/config';
          case 'path_www':
            $to = 'www';
          }
          // perform backup
          $this->_backup_file( $file, $this->_ini[$sect][$var], $to );
        }
        if( !$is_tmplt ) {
          // get new config file
          print "   $choice $file\n";
          // this is a replace or a create
          // there is no option to merge
          if( !@copy( $source, $dest ) ) {
            $this->_printerr("_copy_config_files", "Failed to $ctext config: $dest with $source");
            $success = false;
          }
        }
        else {          
          // if this is a merge, we will try to merge template with
          // the existing config file, then fall back on the default config
          // file values. If it is not a merge, then we will simply create
          // using the defaults.
          // parse templates and write
          if( !$this->_merge_template_file( $dest, ($choice == 'R'? true : false) ) ) {
            $success = false;
          }
        }
        // set permissions
        @chmod( $dest, 0755 );
      }
      else {
        print "   S skipped $file, you must manually update this file!\n";
      }
    }
    // update the last_config_update counter
    touch( $this->_ini['directories']['dir_cache']."/last_config_update" );
    chmod( $this->_ini['directories']['dir_cache']."/last_config_update", 0766 );
    return $success;
  }

  /**
   * Copies files from the installation path to the directory where they will be used
   *
   * Does not copy config files
   *
   * @param boolean $replace replace file if it exists
   */
  function _copy_content_files( $replace = true ) {
    print "- Copying all content files to appropriate destinations\n";
    
    // confirm if replace
    if( $this->_confirm("This will replace all existing files, continue?") != 'y' )
      return false;

    // directories
    $source = "../";
    $inc = $this->_ini['paths']['path_includes'];
    $conf = $this->_ini['directories']['dir_config'];
    $web = $this->_ini['paths']['path_www'];
    
    // includes files
    if( !$this->_copyRecursively( "$source/includes", $inc, 0644, $replace ) ) { return false; }
    
    // web files
    if( !$this->_copyRecursively( "$source/www", $web, 0644, $replace ) ) { return false; }
    
    // install directory
    if( !$this->_copyRecursively( "$source/install", $conf, 0644, $replace) ) { return false; } 

    return true;
  }

  /**
   * Updates the directory structure and information from a cvs download
   * 
   * @param boolean $overwrite overwrite config files with new versions (default true)
   * @return boolean success
   */
  function _cvs_update( $overwrite = true ) {
    // check for develop mode
    if( $this->_ini['debug']['develop_mode'] < 1 ) {
      $this->_printerr("_cvs_update", "This method is only available during development [develop_mode=true]");
      return false;
    }

    // backup data
    if( !$this->_backup_all() ) { return false; }

    // test directory structures and permissions
    if( !$this->_check_directories( true ) ) { return false; }
    
    // check the permissions
    if( !$this->_check_permissions() ) { return false; }

    // copy the class files
    if( !$this->_copy_class_files() ) { $success = false; }

    // copy config files if flag set
    if( !$this->_merge_config_files() ) { $success = false; }
    
    // delete cache data and touch cache/last_config_update??
    if( !$this->_clean_cache_data() ) { return false; }

    // compare and update db schema
    if( !$this->_update_db_schema( true ) ) { return false; }

    return true;
  }

  /**
   * Sets directory permissions to most secure available
   *
   * @param string $apache_user is the apache user account
   * @param string $apache_group is the apache group account
   * @return boolean successful
   */
  function _extra_secure_mode( $apache_user, $apache_group ) {
    $success = true;
    return $this->_check_permissions( true, $apache_group );
  }

  /**
   * Performs a complete installation
   *
   * @return boolean success
   */
  function _full_install( ) {
    //todo
    print "- full_install not ready for use yet\n";
    return true;

    // confirm
    $str = "This will completely destroy any existing data in the target directory or database, continue?";
    if( $this->_confirm($str) != 'y') {
      print "   Aborted!\n";
      return false;
    }

    // test directory structures and permissions
    if( !$this->_check_directories( true ) ) { return false; }
    
    // check the permissions
    if( !$this->_check_permissions() ) { return false; }

    // copy config files if flag set
    if( !$this->_copy_config_files() ) { $success = false; }
    
    // check database connection
    if( !$this->_verify_db_connection() ) { return false; }

    // create database
    //todo

    // load initial data
    //todo    

    return $success;
  }
  
  /**
   * Prepares installation package to upload to sourceforge
   *
   * This will DESTROY a build if you run this on a working directory
   * Only run this on a copy of your build, as it will take the directory
   * and make it an "install build" before zipping and tarring
   *
   * @param string $src is the source directory to mutilate and prepare for install
   * @param string $dest is the name of the zip/tar files to create
   * @return boolean succeeded
   */
  function _prepare_install_files( $src, $dest ) {
    // check for develop mode
    if( $this->_ini['debug']['develop_mode'] < 1 ) {
      $this->_printerr("_prepare_install_file", "This target is only used during development [develop_mode=true]");
      return false;
    }

    //todo

    print "- prepare_install_files not ready for use yet\n";
    return true;

    // copy defaults/zen.ini to install directory, set develop_mode = 0

    // check directories

    // copy class files
    
    // remove config files

    // remove dynamic directories
    
    // remove CVS directories

    // get database schema

    // tar and package a .tar.gz and a .zip file

  }

  /**
   * Performs an upgrade from a previous version
   *
   * @param string $version is the previous version we are updating from
   */
  function _upgrade( $version ) {
    print "- Upgrade not ready for use yet\n";
    return true;

    // confirm
    if( $this->_confirm("This will overwrite existing data with new changes,"
                        ." config files will be backed up/merged, database will be backed up/merged,"
                        ." other files will be overwritten... continue?") != 'y' ) {
      print "   Aborted!\n";
      return false;
    }

    // backup data
    if( !$this->_backup_all() ) { return false; }

    // test directory structures and permissions
    if( !$this->_check_directories( true ) ) { return false; }
    
    // check the permissions
    if( !$this->_check_permissions() ) { return false; }

    // copy the class files
    if( !$this->_copy_class_files() ) { $success = false; }

    // copy config files if flag set
    if( !$this->_merge_config_files() ) { $success = false; }
    
    // delete cache data and touch cache/last_config_update??
    if( !$this->_clean_cache_data() ) { return false; }

    // compare and update db schema
    if( !$this->_update_db_schema( true ) ) { return false; }

    // notify user of any manual updates required or config files
    // which were backed up/replaced
    //todo
    //todo

    return $success;

  }

  function _try_db_connection( $type, $host, $instance, $user, $passwd ) {
    $db = $this->_ini['db'];
    print "   Connecting to {$type}//{$user}@{$host}:{$instance}\n";
    // set params
    $this->_ini['db']['db_type'] = $type;
    $this->_ini['db']['db_host'] = $host;
    $this->_ini['db']['db_instance'] = $instance;
    $this->_ini['db']['db_user'] = $user;
    $this->_ini['db']['db_pass'] = $passwd;
    // insure db connection isn't cached
    $GLOBALS['dbConnection'] = null;
    return $this->_verify_db_connection();
  }

  /**
   * Verifies database connectivity
   *
   * @return boolean success
   */
  function _verify_db_connection() {
    print "- Checking database connection\n";
    // set up the params
    $db = $this->_ini['db'];
    print "   Connecting to {$db['db_type']}//{$db['db_user']}@{$db['db_host']}:{$db['db_instance']}\n";
    // establish and test connection
    $GLOBALS['dbConnection'] = null;  //delete any cached connection
    $dbc = $this->_get_db_connection();
    return $dbc->isConnected();
  }

  /** Establish a database connection */
  function _get_db_connection() {
    // find adodb and include
    $dir = $this->_ini['directories']['dir_classes'];
    if( !@is_dir($dir) ) {
      $this->_printerr("_get_db_connection","Cannot find the class files to enable adodb, unable to establish db connection");
      return false;
    }
    include_once("$dir/adodb/adodb.inc.php");
    $GLOBALS['zen'] = $this->_ini;
    return Zen::getDbConnection();    
  }

  /**
   * Updates a database schema
   *
   * @param string $source is the xml file to get the new schema from
   * @param boolean $perform false - tells what it will update, true - performs the update 
   */
  function _update_db_schema( $source, $perform = true ) {
    print "- update_db_schema is not ready for use\n";
    return false;

    //todo

    // confirm

    // establish db connection (remember to include adodb)
    
    // backup the data

    // parse the new schema
    
    // collect the old schema

    // perform the update (or preview)
    
    // determine if there is new data to be uploaded

  }

  /*****************************************************
   ****   UTILITIES
   ****************************************************/

  /**
   * Attempts to locate the directory where the classes are
   * located
   */
  function _find_classes_directory() {
    $dir = null;
    if( @is_dir( $this->_ini['directories']['dir_classes'] ) ) {
      $dir = $this->_ini['directories']['dir_classes'];
    }
    else if( @is_dir("../includes/lib/classes") ) {
      $dir = "../includes/lib/classes";
    }
    else if( @is_dir("../lib/classes") ) {
      $dir = "../lib/classes";
    }
    return $dir;
  }

  /**
   * Prints the zen.php file header when a target is run
   *
   */
  function _printHeading() {
    print join("",file($this->_installdir."/setup/headingInfo"));
  }

  /**
   * retrieves an input parameter (insures that it exists, etc)
   *
   * @param string $target is the target the param is for
   * @param integer $key is the index of the var to get
   * @param mixed $default is the value to substitute if not found
   * @return mixed the resulting value
   */
  function _getParm( $target, $key, $default = null ) {
    if( isset($this->_targets[$target]) && isset($this->_targets[$target][$key]) ) {
      return $this->_targets[$target][$key];
    }
    else {
      return $default;
    }
  }

  /**
   * retrieves a boolean input parameter (if a value is entered that is not boolean, will be parsed as one)
   *
   * @param string $target is the target the param is for
   * @param integer $key is the index of the var to get
   * @param mixed $default is the value to substitute if not found
   * @return boolean true or false
   */
  function _getBooleanParm( $target, $index, $default = false ) {
    $p = $this->_getParm($target,$index);
    if( !$p ) { return $default; }
    if( is_bool($p) ) { return $p; }
    switch( strtolower(substr($p, 0, 1)) ) {
    case "t":
    case "y":
    case 1:
      return true;
    case "f":
    case "n":
    case 0:
      return false;
    default:
      return $default;
    }
  }


  /**
   * Checks a specific directory, creates if specified
   *
   * @param string $dir is the path to the directory to create
   * @param boolean $create tells whether to check directory or not
   * @param integer $permissions unix permission string... run if $create = true, even if not created
   * @return true if directory exists (or was created)
   */
  function _checkDir( $dir, $create ) {
    //$permissions = decoct( ()$permissions );
    if( !@is_dir($dir) && !$create ) {
      // doesn't exist & $create = false
      $this->_printerr("_checkDir", "A required directory is missing: $dir");
      return false;
    }    
    else if( !@is_dir($dir) ) {
      $res = mkdir($dir);
      if( $res ) {
        print "   C $dir\n";
        return true;
      }
      $this->_printerr("_checkDir", "A required directory could not be created: $dir");
      return false;
    }
    return true;
  }

  /**
   * Recursively reads directories and drops files.. for use with clean_cache_data
   * @param string $dir is the directory to recurse through
   */
  function _clean_recursively( $dir ) {
    $success = true;
    print "   cleaning $dir\n";

    $files = array();
    $dirs = array();

    // loop through files in directory
    $dh = @opendir( $dir );
    if( !$dh ) {
      $this->_printerr("_clean_recursively", "Unable to read $dir");
      return false;
    }
    while( $f = readdir($dh) ) {
      $file = $dir."/".$f;
      // ignore system files
      if( strpos($f,".") === 0 ) { continue; }
      // store directories
      else if( @is_dir($file) ) { $dirs[] = $file; }
      // store files
      else { $files[] = $file; }
    }
    closedir($dh);
    
    // purge files
    $purged = 0;
    $failed = 0;
    foreach( $files as $f ) { 
      if( !@unlink($f) ) {
        printerr("_clean_recursively", "Unable to purge file: $f");
        $success = false;
        $failed++;
      }
      else { $purged++; }
    }
    print "   ..$purged purged, $failed failed\n";
    
    // clean subdirectories
    foreach( $dirs as $d ) { 
      if( !$this->_clean_recursively( $d ) ) $success = false;
    }

    return $success;
  }
  
  /**
   * Performs a recursive copy from one directory to another
   *
   * @param string $source the directory to copy from
   * @param string $dest the directory to copy to
   * @param integer $chmod is the permissions to create any needed directories with
   * @param boolean $replace tells whether files should be replaced if found
   * @return boolean succeeded
   */
  function _copyRecursively( $source, $dest, $chmod, $replace = true ) {
    print "   populating $dest [+ added, S skipped, R replaced]\n";
    $success = true;

    // make sure the directory exists
    if( !@is_dir( $dest ) && !@mkdir($des) ) {
      $this->_printerr("_copyRecursively", "Unable to create directory: $dest");
      return false;
    }
    
    // copy files in this directory
    $dirs = array();
    $dh = opendir( $source );
    while( ($f = readdir($dh)) === true ) {
      $oldfile = $source."/".$file;
      $newfile = $dest."/".$f;
      if( strpos($f,".") === 0 || preg_match("/([-~]|\.old)$/", $f) ) {
        // skip backups and system entries
        continue;
      }
      else if( @is_dir($oldfile) ) {
        // take note of subdirectories
        $dirs[] = array($oldfile, $newfile);
        continue;
      }
      if( file_exists($newfile) && !$replace) {
        // skipped
        print "   S $f\n";
        continue;
      }
      
      // replace or add
      if( file_exists($newfile) ) { print "   R $f\n"; }
      else { print "   + $f\n"; }

      // do the copy
      if( !@copy( $file, $dest."/".$f ) ) {
        $this->_printerr("_copyRecursively", "Unable to create: $newfile");
        return false;
      }
    }
    closedir($source);

    // copy files in all subdirectories    
    foreach( $dirs as $d ) {
      if( !$this->_copyRecursively($d[0], $d[1], $chmod, $replace) )
        $success = false;
    }

    // return results
    return $success;
  }

  /**
   * Parses a setup data file and sets results
   *
   * @param string $filename
   * @return boolean loaded successfully
   */
  function _parseConfigData( $filename ) {
    $filename = $this->_installdir."/setup/$filename";
    if( !@file_exists($filename) ) {
      print "ERROR: $filename could not be loaded.  Setup will not run correctly!";
      return false;
    }
    if( !class_exists('ZenUtils') ) {
      $this->_copy_class_files();
      require_once( $this->_installdir."/setup/ZenUtils.php" );
    }
    return ZenUtils::parse_datafile($filename);
  }

  /**
   * Prints an error message
   *
   * @param string $method is the method where error occurred
   * @param string $msg is the error to print
   */
  function _printerr( $method, $msg ) {
    print "<<<ERROR>>> $msg\n";
  }

  /**
   * Confirms that the user wants to perform an action (y/n)
   *
   * Note that if the --supress_confirm option was passed, then this function will simply return the default
   * or the first element in the list.
   *
   * @param string $msg message to user
   * @param array $choices if provided, whatever is here is a valid choice, otherwise y/n
   * @return string returns char typed
   */
  function _confirm( $msg, $choices = null, $default = null ) {
    $res = null;
    // default choices
    if( !$choices ) { $choices = array('y','n'); }
    // check for --supress, return first element or default
    if( $this->_supress ) {
      return $default? $default : $choices[0];
    }
    // get the users reply (keep trying until it is valid
    while( !in_array($res, $choices) ) {
      // print an error message if retry
      if( $res ) { print "Please choose one: ".join(", ",$choices)."\n"; }
      // print message
      print "$msg [".join("/",$choices)."]";
      print ($default)? " <$default>:" : ":";
      // read from stdin
      $fp = @fopen("php://stdin", "r");
      if( $fp ) {
        $res = trim(strtolower(substr(fread($fp, 1),0,1)));
        fclose( $fp );
      }
      else {
        $this->_printerr("_confirm", "Unable to read STDIN");
        return false;
      }
      // set value to default if it is blank and one was provided
      if( !$res && $default ) { $res = $default; }
    }
    return $res;
  }

  /**
   * Returns a list of valid targets
   */
  function getValidTargets() {
    return array(
                 "backup_all" => "Run all backup targets",
                 "backup_config" => "Backup config files",
                 "backup_database" => "Backup database",
                 "changed_config" => "Backup config files",
                 "check_directories" => "Check directory structure(and edit as necessary)",
                 "check_permissions" => "Check permissions on directories (and edit)",
                 "clean_cache_data" => "Delete all cached data",
                 "copy_class_files" => "Copy class files needed by installer(development tool)",
                 "copy_config_files" => "Copy config files to working directory",
                 "create_database" => "Create a new database(install tool)",
                 "cvs_update" => "Update code from cvs repository(development tool)",
                 "extra_secure_mode" => "Tighten directory permissions(for unix, need to know unix)",
                 "full_install" => "Install a new zentrack version",
                 "merge_ini_file" => "Merge ini params with template(development tool)",
                 "prepare_install_files" => "Prepare install file(development tool)",
                 "try_db_connection" => "Test db connectivity",
                 "update_db_schema" => "Update db schema to new release(ran by upgrade)",
                 "upgrade" => "Upgrade to new release",
                 "verify_db_connection" => "Test db connection" );
  }
  

  /***********************************
   ****  VARIABLES
   **********************************/

  /** @var array $_configFiles is a list of config files to copy, locations, and permissions */
  var $_configFiles;

  /** @var array $_dirs is a list of required directories */
  var $_dirs;

  /** @var array $_args is the arguments provided by user at command line */
  var $_args;

  /** @var array $_targets is a key-value pair of targets(keys) and their params(values) */
  var $_targets;

  /** @var string $_ini is the parsed contents of the specified ini file for use */
  var $_ini;

  /** @var string the setup directory */
  var $_installdir;

}

?>
