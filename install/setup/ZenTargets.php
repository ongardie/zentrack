<? /* -*- Mode: C; c-basic-indent: 3; indent-tabs-mode: nil -*- ex: set tabstop=3 expandtab: */ 

/** @package Setup */
class ZenTargets {

  /**
   * CONSTRUCTOR - loads config data files
   *
   * @param array (associative) $ini_array is the ini file parsed by ZenUtils::read_ini()
   * @param boolean $supress_config_dialog prevents confirmation messages from appearing (answers yes to all)
   * @param string $compression null-do not compress, zip-use zip compression, gzip-use gzip compression
   */
  function ZenTargets( $ini_array, $supress_confirm_dialog = false, $compression = null ) {
    $this->_supress = $supress_confirm_dialog;
    $this->_installdir = dirname(dirname(__FILE__));
    $this->_printHeading();
    $this->_compress = $compression;
    $this->_dirs = $this->_parseConfigData("directories");
    $this->_configFiles = $this->_parseConfigData("configFiles");
    $this->_ini = $ini_array;
    $paths = array($this->_installdir);
    foreach($this->_ini['paths'] as $val) { $paths[] = $val; }
    foreach( $paths as $key=>$val ) {
      $val = preg_replace('|[\\\\/]|', '[\\\\\\\\/]', $val);
      $this->_pathExps[] = '|^'.$val.'|';
    }    
    $GLOBALS['templateDir'] = $this->_ini['directories']['dir_templates']."/".$this->_ini['layout']['template_set'];
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
	if( !count($this->_targets) ) {
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

    if( strlen($p) && preg_match('#^(-\?|-h|--help|/\?|/h)$#', $p) ) {
      $p = $target;
      $target = 'help';
    }

    //todo
    //todo
    //todo add a target for test_config that will run tests on config file contents
    //todo make this fxn fairly independant of the config's contents
    //todo

    switch($target) {
    case "backup_all":        return $this->_backup_all();
    case "backup_config":     return $this->_backup_config();
    case "backup_database":   return $this->_backup_database( $p, $this->_getParm($target,1) );
    case "changed_config":    return $this->_changed_config();
    case "check_directories": return $this->_check_directories( $p );
    case "check_permissions": return $this->_check_permissions();
    case "clean_cache_data":  return $this->_clean_cache_data();
    case "copy_class_files":  return $this->_copy_class_files( $p );
    case "copy_config_files": return $this->_copy_config_files( $this->_getBooleanParm($target,0,false) );
    case "create_database":
      {
        if( !$p ) {
          $this->_help($target);
          return false;
        }
        return $this->_create_database($p, $this->_getParm($target,1));
      }
    case "cvs_update":        return $this->_cvs_update();
    case "drop_database":     return $this->_drop_database( $p, $this->_getParm($target,1) );
    case "extra_secure_mode":
      {
        $p2 = $this->_getParm($target, 1);
        if( !$p || !$p2 ) {
          $this->_help($target);
          return false;
        }
        return $this->_extra_secure_mode( $p, $p2 );
      }
    case "install":
    case "full_install":      return $this->_full_install();
    case "gen_schema_docs":
      {
        if( !$this->_ini['debug']['develop_mode'] ) {
          $this->_printerr("target", "The gen_schema_docs method is only available in develop_mode");
          return false;
        }
        $p2 = $this->_getParm($target, 1);
        if( !$p || !$p2 ) {
          $this->_help($target);
          return false;
        }
        return $this->_gen_schema_docs($p, $p2);
      }
    case "load_data":
      {
        if( !$p ) {
          $this->_help($target);
          return false;          
        }
        return $this->_load_data( $p, $this->_getParm($target,1), 
                                  $this->_getBooleanParm($target,2,true) );
      }
    case "merge_template_file":    
      {
        if( !$this->_ini['debug']['develop_mode'] ) {
          $this->_printerr("target", "The merge_template_file method is only available in develop_mode");
          return false;
        }
        $p2 = $this->_getParm($target,1);
        $p3 = $this->_getParm($target,2);
        if( !$p || !$p2 || !$p3 ) {
          $this->_help($target);
          return false;
        }
        return $this->_merge_template_file( $p, 
                                            $p2,
                                            $p3,
                                            $this->_getBooleanParm($target,2,false) );
      }
    case "prepare_install_files": 
      {
        $p2 = $this->_getParm($target,0);
        if( !$p || !$p2 ) {
          $this->_help($target);
          return false;
        }
        return $this->_prepare_install_files( $p, $p2 );
      }
    case "try_db_connection":
      {
	if( count($this->_targets[$target]) < 5 ) {
          $this->_help($target);
	  return false;
	}
	return $this->_try_db_connection( $p, $this->_getParm($target, 1),
                                          $this->_getParm($target, 2), 
                                          $this->_getParm($target, 3),
                                          $this->_getParm($target, 4),
                                          $this->_getBooleanParm($target, 5, false));
      }
    case "update_db_schema":
      {
        if( !$p ) {
          $this->_help($target);
          return false;
        }
        return $this->_update_db_schema( $p, $this->_getBooleanParm($target, 1, false) );
      }
    case "upgrade":
      {
        if( !$p ) {
          $this->_help($target);
          return false;
        }
        return $this->_update( $p );
      }
    case "verify_db_connection":
      {
        return $this->_verify_db_connection();
      }
    case "help":
      {
        $this->_help($p);
        return true;
      }
    default:
      {
	print "\n$u was an invalid target: ignored\n";
	return false;
      }
    }
  }

  /**
   * Displays usage and brief help for a command
   *
   * @params string $target
   */
  function _help( $target ) {
    $targets = $this->getValidTargets();
    $description = isset($targets[$target])? $targets[$target] : "";
    if( $target ) { print "\n".strtoupper($target).": $description\n"; }
    switch( $target ) {
    case "backup_database":
      {
        print "   Usage: install.php [modifiers] -$target [tables]\n";
        print "   - tables: a comma separated list of tables (default is to backup all tables)\n";
        print "   - the backup is stored in includes/backups/yyyy-mm-dd-HH-mm directory\n";
        break;
      }
    case "create_database":
      {
        print "   Usage: install.php [modifiers] -$target data_dir\n";
        print "   - data_dir: the source directory containing db schema and data\n";
        print "   - you must create the database instance before running this command\n";
        print "   - you must create the database user and priviledges before running this command\n";
        break;
      }
    case "drop_database":  
      {
        print "   Usage: install.php [modifiers] -$target [table]\n";
        print "   - tables: a comma separated list of tables (default is to drop all tables)\n";
        break;
      }
    case "extra_secure_mode":
      {
        print "   Usage: install.php [modifiers] -$target apache_user apache_group\n";
        print "   - apache_user: the name the apache web process runs as\n";
        print "   - apache_group: the group the apache web process runs as\n";
        print "   - you must be a superuser to run this command\n";
        print "   - this command means nothing to windows\n";
        break;
      }
    case "gen_schema_docs":
      {
        print "   Usage: install.php [modifiers] -$target source_file output_dir\n";
        print "   - source_file: the xml file containing db schema\n";
        print "   - output_dir: where the html files will be created\n";
        print "   - this will create html docs describing the db schema\n";
      }
    case "load_data":
      {
        print "   Usage: install.php [modifiers] -$target data_directory [delete_first]\n";
        print "   - data_directory: the source directory containing xml data to upload\n";
        print "   - delete_first: [default=true] is whether or not to delete existing data before uploading\n";
        print "   - this command can read zip or gzip compressed data files\n";
        break;
      }
    case "merge_template_file": 
      {
        print "   Usage: install.php [modifiers] -$target file source dest [replace]\n";
        print "   - file: the template or file to be copied (do not append .template suffix)\n";
        print "   - source: directory to copy from\n";
        print "   - dest: directory to copy to\n";
        print "   - replace: merge with existing file (false) or replace existing(true) [default=false]\n";
        break;
      }
    case "prepare_install_files": 
      {
        print "   Usage: install.php [modifiers] -$target source destination\n";
        break;
      }
    case "try_db_connection":
      {
        print "   Usage: install.php [modifiers] -$target type host instance user password\n";
        print "   - type: the db type, such as mysql, pgsql, oci8po, etc (see zen.ini for details)\n";
        print "   - host: can be localhost or possibly '', and instance is the database name, or TNS file for oracle\n";
        break;
      }
    case "update_db_schema":
      {
        print "   Usage: install.php [modifiers] -$target new_schema.xml [true|false]\n";
        print "   - true|false: 'actually do it' vs. just preview it [default=true]\n";
        break;
      }
    case "upgrade":
      {
        print "   Usage: install.php [modifiers] -$target old_version\n";
        print "   - old_version: the version you want to upgrade from\n";
        break;
      }
    case "full_install": 
    case "verify_db_connection":
    case "backup_all":       
    case "backup_config":    
    case "changed_config":   
    case "check_directories":
    case "check_permissions":
    case "clean_cache_data": 
    case "copy_class_files": 
    case "copy_config_files":
    case "cvs_update":       
      {
        print "   Usage: install.php [modifiers] -$target\n";
        break;
      }
    case "":
    case "help":
      {
        print "   Usage: install.php [modifiers] -help target\n";
        print "   - command: the command to display help for\n";
        print "\n   Available targets:\n";
        foreach( $targets as $key=>$val ) {
          print "   -$key ($val)\n";
        }
        break;
      }
    default:
      {
	print "   No help found for specified target\n";        
      }
    }
    print "\nThe following special modifiers are allowed:\n";
    print "   --ini_file=file, specify an alternate zen.ini (config) file to use (defaults to ./zen.ini)\n";
    print "   --supress_confirm, supresses confirm dialog (answers yes(or default) to all, needed for cron jobs)\n";
    print "   --verbose, increases message output\n";
    print "   --compress=type, set data compression:"
      ."\n       null - do not compress(default)"
      ."\n       zip  - use zip compression"
      ."\n       gzip - use gzip compression\n";
    print "\t--classdir=dir, specify location of class files (for development)\n";
    return true;
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

    print "- Backing up config files to ".$this->_getBackupLocation()."/$dest\n";
    foreach( $this->_configFiles as $c) {
      // split the array
      list($sect,$var,$name,$is_tmplt,$permissions,$default) = $c;

      // set up source
      $source = $this->_ini[$sect][$var];
      
      // create the destination
      $dest = preg_replace( $this->_pathExps, "", $source );
      
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
   * @access private
   * @param string $name the name of file
   * @param string $source the source directory (without filename)
   * @param string $dest the backup directory (this is the subdirectory under backup only)
   * @param string $newname if provided, the backup will be created with this name
   * @param boolean $required if true, then the file must exist or operation fails
   * @return boolean returns false only if source exists and copy failed, otherwise true
   */
  function _backup_file($name, $source, $dest = '', $newname = '', $required = false) {
    // get base backups directory
    $base = $this->_getBackupLocation();

    // create directory tree and 
    // remove windows root references(i.e. c:)
    if( strpos($dest,'\\') === 0 || strpos($dest,'/') === 0 ) {
      $dest = substr($dest,1);
    }
    $des = preg_split('#[\\\\/]#', preg_replace("#^$base#", "", $dest));
    if( preg_match('#[a-zA-Z]:#', $des[0]) ) { array_shift($des); }

    // make sure the subdirectory exists
    // by getting each piece and
    // creating if necessary
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
    if( !$newname ) { $newname = $name; }
    $dest .= "/$newname";
    
    // create the source file
    $source = $source."/$name";
    
    // if no source, return gracefully
    if( !file_exists($source) ) {
      print "   S $source not found: backup skipped\n";
      return $required? false : true;
    }
    
    // copy file
    print "   B $dest\n";      
    if( !copy( $source, $dest ) ) {
      $this->_printerr("_backup_file", "Backup of $name failed ({$source}->{$dest})");
      return false;
    }
    @chmod( $dest, 0600 );
    return true;
  }
  
  /**
   * Back up database files
   *
   * @param string $table if provided, only tables listed here will be backed up (separate names with a comma)
   * @param boolean $supress (system use only)if true, then errors will be ignored
   */
  function _backup_database( $table = null, $supress = false ) {
    print "- Backing up database contents\n";

    // determine which tables to backup
    if( $table ) { $tables = explode(',',$table); }
    else { $tables = null; }

    // create directory if not done yet
    $dir = "database";
    $source = $this->_ini['directories']['dir_config'];
    
    // backup the database schema
    if( !$this->_backup_file('database.xml', $source, $dir, '', true) ) {
      if( !$supress ) {
        $this->_printerr("_backup_database", "Could not backup schema file");
      }
      return false;
    }

    // turn off error reporting for now
    if( $supress ) {
      $lvl = $GLOBALS['installMode'];
      $GLOBALS['installMode'] = 0;
    }

    // perform backups
    $dbc =& $this->getDbConnection();
    $dbx = new ZenDBXML( $dbc, $source.'/database.xml', $this->_ini['debug']['develop_mode'] );
    $res = $dbx->dumpDatabaseData( $this->_getBackupLocation()."/".$dir, 
                                   $tables, $this->_compress );

    print "   {$res[1]} of {$res[0]} statements processed successfully\n";
    if( $res[0] != $res[1] && !$supress ) {
      $diff = $res[0] - $res[1];
      $this->_printerr("_backup_database", "Backup error: $diff statements failed");
      return false;
    }

    // return error reporting to normal
    if( $supress ) {
      $GLOBALS['installMode'] = $lvl;
    }

    return $res[0] == $res[1];
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
    if( !$this->_bdir ) {
      $this->_bdir = $this->_ini['directories']['dir_backups']."/".date("Y-m-d-H-i");
      if( !@is_dir($this->_bdir) ) { @mkdir($this->_bdir, 0700); }
    }
    return $this->_bdir;
  }

  var $_bdir;

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
    if( file_exists($f) ) {
      $conf = $this->_confirm("Updating header.php file: merge, replace, or skip?", array('m','r','s'));
    }
    if( !file_exists($f) || $conf != 's' ) {
      if( !file_exists($f) ) { $conf = 'r'; }
      else {
        $this->_backup_file( 'header.php', $this->_ini['paths']['path_www'], 'www' );
      }
      if( !$this->_merge_template_file( "header.php",
                                        $this->_installdir."/defaults",
                                        $this->_ini['paths']['path_www'],
                                        ($conf == 'r'? true : false) ) ) {
        $res = false;
      }
    }
    else {
      print "   WARNING!! $f was not updated, you may need to manually update this file\n";
    }

    // clean out all cache data
    if( !$this->_clean_cache_data ) {
      print "   The changed_config target has completed successfully; however, cache data could not be cleared.\n";
      print "   Please login as an administrator and run install.php [modifiers] -clean_cache_data\n";
    }

    // update the last_config_update counter
    touch( $this->_ini['directories']['dir_cache']."/last_config_update" );
    chmod( $this->_ini['directories']['dir_cache']."/last_config_update", 0766 );

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
      print "- Setting STRICT directory permissions\n";
    }
    else {
      $dirs = $this->_dirs;
      print "- Setting directory permissions\n";
    }
    $success = true;    
    
    // read each file
    foreach($dirs as $d) {
      // split up the params
      list($sect,$root,$dir,$chmod,$sourcedir) = $d;

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

    ZenMetaDb::clearCacheInfo();

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
    print "   Copying from $dir to $installdir/setup\n";

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
   * Creates html documentation for the provided schema
   *
   * @param string $source is the file containing xml database schema
   * @param string $dest is the directory where html files will be generated
   * @return boolean
   */
  function _gen_schema_docs( $source, $dest ) {
    // validate our input parms
    if( !file_exists($source) ) {
      $this->_printerr("_gen_schema_docs", "DB Schema not found: $source");
      return false;
    }
    if( !is_dir($dest) ) {
      $basedir = dirname($dest);
      if( !is_dir($basedir) || !mkdir($dest, 0755) ) {
        $this->_printerr("_gen_schema_docs", "Could not create/find output directory: $dest");        
      }
    }
    
    // parse the xml data
    $dbo =& $this->getDbConnection();
    // we pretend develop mode is true here since we want to load
    // the test tables too.
    $dbSchema = new ZenDbSchema($source, false, true);

    // generate the list of tables
    // and the abstract tables
    $tables = $dbSchema->listTables();    
    natsort($tables);
    $tableData = array();
    $navList = array('a'=>array(),'t'=>array());
    foreach($tables as $t) {
      // get the tables values
      $table = $dbSchema->getMetaTable($t);
      $vals = array('is_abstract'=>false);
      foreach($table->listProperties() as $p) {
        if( $p == 'inherits' ) {
          // inherited fields are handled seperately
          $vals['inherits'] = $table->getProp($p);
        }
        else if( $p == 'name' ) {
          $vals['name'] = $table->getProp($p);
        }
        else if( $p == 'fields' ) {
          continue;
        }
        else {
          $v = $table->getProp($p);
          if( $p == 'is_abstract' && $v ) { 
            $vals['is_abstract'] = true;
          }
          if( $p == 'description' ) {
            $vals['description'] = $v;
          }
          if( in_array($p, array('is_abstract','has_custom_fields')) ) {
            $v = $v? "Yes" : "No";
          }
          $p = ucwords(strtolower(str_replace("_", " ",$p)));
          $vals['properties'][$p] = $v;          
        }
      }

      // set style
      $vals['cellS2tyle'] = $vals['is_abstract']? 'abstractRow' : '';

      // get the field values
      $color = 'rowA';
      $vals['fields'] = array();
      // inherited
      foreach($dbSchema->getInheritedFields($t) as $field) {
        $f = $field['name'];
        if( is_array($field['criteria']) ) {
          $field['criteria'] = "[".$field['criteria'][0]."]".$field['criteria'][1];
        }
        $field['style'] = $color;
        $field['cell'] = 'cellAbstract';
        $vals['fields'][$f] = $field;
        $color = $color == 'rowB'? 'rowA' : 'rowB';
      }
      // normal fields
      foreach($table->listFields() as $f) {
        $mf = $table->getMetaField($f);        
        $field = $mf->getFieldArray();
        if( is_array($field['criteria']) ) {
          $field['criteria'] = "[".$field['criteria'][0]."]".$field['criteria'][1];
        }
        $field['style'] = $color;
        $field['cell'] = 'cellNormal';
        $vals['fields'][$f] = $field;
        $color = $color == 'rowB'? 'rowA' : 'rowB';
      }

      // set up nav tables
      // separating abstract and regular tables
      if( $vals['is_abstract'] ) {
        $vals['children'] = array();
        $navList['a'][] = $t;
      }
      else {
        $navList['t'][] = $t;
      }

      $tableData[$t] = $vals;
    }    

    // generate abstract table children
    // by looking to see who each table
    // inherits and setting children in
    // that table.
    foreach( $tables as $t ) {
      $inherits = $tableData[$t]['inherits'];
      if( is_array($inherits) && count($inherits) ) {
        foreach($inherits as $i) {
          $tableData[$i]['children'][] = $t;
        }
      }
    }

    // text describing the db
    $titleText = $this->_ini['layout']['system_name']." Database Schema";
    // the date/time text was generated
    $gentime = date("Y-m-d H:i");

    // generate frame page
    $template = new ZenTemplate("schema/frameset.template");
    $template->values( array('title'=>$titleText,'gentime'=>$gentime) );
    $fp = fopen("$dest/index.html", 'w');
    if( !$fp ) {
      $this->_printerr("_gen_schema_docs", "Unable to create index.html in $dest");
      return false;
    }
    fputs($fp, $template->process());
    fclose($fp);
    print "   C index.html\n";

    // generate navigation bar
    $template = new ZenTemplate("schema/nav.template");
    $template->values( array('abstract' => $navList['a'],
                             'tables'   => $navList['t'],
                             'gentime'  => $gentime,
                             'source'   => $source));
    $fp = fopen("$dest/nav.html", 'w');
    if( !$fp ) {
      $this->_printerr("_gen_schema_docs", "Unable to create nav.html in $dest");
      return false;
    }
    fputs($fp, $template->process());
    fclose($fp);
    print "   C nav.html\n";

    // generate menu page
    $vals = array('title'   => $titleText,
                  'source'  => $source,
                  'count'   => count($tables),
                  'gentime' => $gentime,
                  'tables'  => $tableData);
    $template = new ZenTemplate("schema/menu.template");
    $template->values($vals);
    $fp = fopen("$dest/menu.html", 'w');
    if( !$fp ) {
      $this->_printerr("_gen_schema_docs", "Unable to create main.html in $dest");
      return false;
    }
    fputs($fp, $template->process());
    fclose($fp);
    print "   C menu.html\n";

    // generate tables
    foreach($tables as $t) {
      $vals = $tableData[$t];
      $vals['source'] = $source;
      $vals['gentime'] = $gentime;
      // create the template
      $tmp = $vals['is_abstract']? "abstract" : "table";
      $template = new ZenTemplate("schema/$tmp.template");
      $template->values( $vals );
      // write to file
      $fp = fopen("$dest/$t.html", 'w');
      if( !$fp ) {
        $this->_printerr("_gen_schema_docs", "Unable to create $t.html in $dest");
        return false;
      }
      fputs($fp, $template->process());
      fclose($fp);
      print "   C $t.html\n";
    }
    return true;
  }

  /**
   * Merges config files with existing settings.. copies config files for all regular files
   * all template files will be parsed and the existing values substituted where possible
   *
   * If replace is set to true, then the current zen.ini file (from this install directory) will
   * be used to fill values as possible, to reduce the user configuration as much as possible.
   *
   * @param string $file is the filename (without .template extension)
   * @param string $source is the path for the source file ($filename.template will be appended)
   * @param string $dest the full path for output file ($filename will be appended)
   * @param boolean $replace if true, then the destination will be replaced instead of merged
   */
  function _merge_template_file( $file, $source, $dest, $replace = false ) {
    $source = $source . "/$file.template";
    $dest = $dest ."/$file";
    
    if( !@file_exists($source) ) {
      $this->_printerr('_merge_template_file', "Template file ($source) not found, cannot continue");
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

    if( basename($dest) == "zen.ini" ) {
      // for our zen.ini file
      // this will parse the directories and substitue %varname% for any values which
      // correspond with another variable for scalability
      foreach($vals as $k1=>$v1) {
        foreach($vals as $k2=>$v2) {
          // we only want to do directories, and we
          // don't want to replace a var with its own val
          if( $k1 == $k2 || !preg_match("/^(path|url|dir)/", $k1)
              || !preg_match("/^dir/", $k2) ) { continue; }
          $v1 = $vals[$k1];
          $vals[$k2] = preg_replace("|^$v1|", "%$k1%", $vals[$k2]);
        }
      }
    }    

    $template = new ZenTemplate( $source );
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
    $vals = ZenUtils::flatten_array($this->_ini);
    foreach($contents as $c) {
      if( preg_match("/^[ \t]*[$]?([a-zA-Z0-9_]+) *= *[\"']?([^\"';]+)/", $c, $matches) ) {
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
   * @param boolean $overwrite if set to true, will automatically merge or replace existing config files (backed up)
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
      list($sect,$var,$file,$is_tmplt,$permissions,$source,$default) = $c;

      // set up destination directory
      $dest = $this->_ini[$sect][$var];

      // get source directory
      // this will be installs/defaults unless
      // this is a directory or the install.php
      // file itself, in either of those cases
      // it will be installs/
      $source = $this->_installdir.($source? "/$source" : "");
      $file = preg_replace('#/$#', '', $file);

      // check directory structure
      if( !@is_dir($source) ) {
        $this->_printerr('_copy_config_files', "$source directory does not exist, cannot process $file");
        return false;
      }
      if( !@is_dir($dest) ) {
        $this->_printerr('_copy_config_files', 
                         "$dest directory does not exist, try running 'install.php [modifiers] -check_directories true'");
        return false;
      }

      // generate full pathnames
      $sourcefile = ($is_tmplt)? $source."/$file.template" : $source."/$file";
      $destfile = $dest."/$file";

      if( $sect == 'directories' && $var == 'dir_user' && file_exists($destfile) ) {
        print "   S $file (files in user directory are not overwritten)\n";
        continue;
      }

      // we will deal with directories seperately, since they require
      // some special procedures
      if( @is_dir($sourcefile) ) {
        if( @is_dir($destfile) && !$overwrite && $this->_confirm("Replace directory $destfile?") != 'y' ) {
          print "   S $file\n";
        }
        else {
          print @is_dir($destfile)? "   R $file\n" : "   C $file\n";
          $this->_copyRecursively($sourcefile, $destfile, $permissions, true);
        }
        continue;
      }

      if( file_exists($destfile) && !$overwrite ) {
        // if this file exists, we will ask for confirmation
        // if it is a template, we will try to merge it
        // if not we either replace or skip
        $choices = $is_tmplt? array('m','r','s') : array('r','s');
        $choicetext = $is_tmplt? "merge, replace, or skip" : "replace or skip";
        $choice = $this->_confirm("   $file exists, $choicetext?", $choices, $default);
      }
      else if( file_exists($destfile) && $overwrite ) {
        // we will automagically merge or replace
        // if the overwrite flag is set
        $choice = $default;
      }
      else {
        // if the file doesn't exist then
        // we create it
        $choice = "c";
      }      

      // check overwrite
      if( !file_exists($destfile) || $overwrite || $choice != 's' ) {
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
        if( file_exists($destfile) ) {
          // figure out where to put the backup
          $to = preg_replace( $this->_pathExps, "", $dest );
          // perform backup
          $this->_backup_file( $file, $dest, $to );
        }
        if( !$is_tmplt ) {
          // get new config file
          print "   $choice $file\n";
          // this is a replace or a create
          // there is no option to merge
          if( !@copy( $sourcefile, $destfile ) ) {
            $this->_printerr("_copy_config_files", "Failed to $ctext config: $destfile with $sourcefile");
            $success = false;
          }
        }
        else {          
          // if this is a merge, we will try to merge template with
          // the existing config file, then fall back on the default config
          // file values. If it is not a merge, then we will simply create
          // using the defaults.
          // parse templates and write
          if( !$this->_merge_template_file( $file, $source, $dest, ($choice == 'R'? true : false) ) ) {
            $success = false;
          }
        }
        // set permissions
        eval("@chmod( '$destfile', $permissions );");
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
    $source = dirname($this->_installdir);
    $inc = $this->_ini['paths']['path_includes'];
    $conf = $this->_ini['directories']['dir_config'];
    $web = $this->_ini['paths']['path_www'];

    // includes files
    if( "$source/includes" != realpath($inc) ) {
      if( !$this->_copyRecursively( "$source/includes", $inc, '0755', $replace ) ) { return false; }
    }
    else { print "   S includes/, source and dest are the same\n"; }
    
    // web files
    if( "$source/www" != realpath($web) ) {
      if( !$this->_copyRecursively( "$source/www", $web, '0755', $replace ) ) { return false; }
    }
    else { print "   S www/, source and dest are the same\n"; }
    
    // install directory
    if( $this->_installdir != realpath($conf) ) {
      if( !$this->_copyRecursively( $this->_installdir, $conf, '0755', $replace) ) { return false; } 
    }
    else { print "   S install/, source and dest are the same\n"; }

    return true;
  }

  /**
   * Updates the directory structure and information from a cvs download
   * 
   * @param boolean $overwrite overwrite config files with new versions (default true)
   * @return boolean success
   */
  function _cvs_update( $overwrite = true ) {
    $success = true;
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
    if( !$this->_copy_config_files() ) { $success = false; }
    
    // delete cache data and touch cache/last_config_update??
    if( !$this->_clean_cache_data() ) { $success = false; }

    // compare and update db schema
    if( !$this->_update_db_schema( true ) ) { return false; }

    return $success;
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
    print "PERFORMING FULL INSTALLATION\n\n";

    // confirm
    $str = "This could destroy data in the target directories and database, continue?";
    if( $this->_confirm($str) != 'y') {
      print "   Aborted!\n";
      return false;
    }

    // copy content files to destination
    if( !$this->_copy_content_files( true ) ) { return false; }

    // test directory structures and permissions
    if( !$this->_check_directories( true ) ) { return false; }
    
    // check the permissions
    if( !$this->_check_permissions() ) { return false; }

    // copy config files if flag set
    if( !$this->_copy_config_files() ) { $success = false; }
    
    // check database connection
    if( !$this->_verify_db_connection() ) { return false; }

    // create database
    if( !$this->_create_database($this->_ini['directories']['dir_config']."/sampledata") ) { return false; }

    // load initial data
    if( !$this->_load_data($this->_ini['directories']['dir_config']."/sampledata") ) { return false; }

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

    // prompt developer to update the sql queries for database.xml (for upgrades)
    // and to update documentation

    // can we make this submit news and mailing list articles?

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

    // copy content files to destinations
    if( !$this->_copy_content_files( true ) ) { return false; }

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

    //todo
    //todo
    // notify user of any manual updates required or config files
    // which were backed up/replaced
    //todo
    //todo

    return $success;

  }

  /**
   * Manually specify the database settings and attempt a connection for testing
   *
   * @param string $type is the database type as specified here: {@link http://phplens.com/lens/adodb/docs-adodb.htm#drivers}
   * @param string $host is the server hostname (localhost, 192.168.1.100, db.mysite.com, etc)
   * @param string $instance is the name of the database instance (zentrack perhaps?)
   * @param string $user is the user login
   * @param string $passwd is the user password
   * @param boolean $persist if true, use a persistent connection
   * @return boolean true on success
   */
  function _try_db_connection( $type, $host, $instance, $user, $passwd, $persist = false) {
    $db = $this->_ini['db'];
    // set params
    $this->_ini['db']['db_type'] = $type;
    $this->_ini['db']['db_host'] = $host;
    $this->_ini['db']['db_instance'] = $instance;
    $this->_ini['db']['db_user'] = $user;
    $this->_ini['db']['db_pass'] = $passwd;
    $this->_ini['db']['db_persistent'] = $persist;
    // insure db connection isn't cached
    $GLOBALS['dbConnection'] = null;
    return $this->_verify_db_connection();
  }

  /**
   * Verifies database connectivity.  This uses the current ini settings
   *
   * @return boolean success
   */
  function _verify_db_connection() {
    print "- Checking database connection\n";
    // set up the params
    $db = $this->_ini['db'];
    // establish and test connection
    $GLOBALS['dbConnection'] = null;  //delete any cached connection
    $dbc = $this->getDbConnection();
    return $dbc && $dbc->isConnected();
  }

  /** 
   * Establish a database connection 
   *
   * @return ZenDbConnection
   */
  function &getDbConnection() {
    // find adodb and include
    $dir = $this->_ini['directories']['dir_classes'];
    if( !@is_dir($dir) ) {
      $this->_printerr("getDbConnection","Cannot find the class files to enable adodb, unable to establish db connection");
      return false;
    }
    include_once("$dir/adodb/adodb.inc.php");
    $GLOBALS['zen'] = $this->_ini;
    return Zen::getDbConnection();
  }

  /**
   * Create a database schema.  If the schema already exists, it will be deleted before starting!
   *
   * Note that this will not create the database instance.  Users must manually create the
   * database instance, user and password.
   *
   * @param string $dataDirectory is the directory which contains the database.xml schema
   * @return boolean
   */
  function _create_database( $dataDirectory ) {
    if( !$this->_verify_db_connection() ) {
      $this->_printerr("_create_database", "Could not connect to database");
      return false;
    }

    // backup first, supress all errors (there may not even be a db to backup)
    $this->_backup_database(null, true);
    
    // add new schema
    print "- Create database schema\n";
    $dbc =& $this->getDbConnection();
    $dbx = new ZenDBXML( $dbc, $dataDirectory.'/database.xml', $this->_ini['debug']['develop_mode'] );
    $res = $dbx->createDbSchema( true );
    print "   {$res[1]} of {$res[0]} tables created successfully\n";
    if( $res[0] != $res[1] ) {
      $diff = $res[0] - $res[1];
      $this->_printerr("_create_database", "Create error: $diff statements failed");
      return false;
    }
    return true;
  }

  /**
   * Drop a database schema.  Be very careful using this!
   *
   * @param string $table if provided, only tables listed here(separated with comma) will be dropped
   * @return boolean
   */
  function _drop_database( $table = null ) {
    // decide which tables to do
    if( $table ) { $tables = explode(',',$table); }
    else { $tables = null; }

    // backup schema and data
    if( !$this->_backup_database($tables, true) ) {
      $this->_printerr("_drop_database", "Unable to backup db tables, aborting");
      return false;
    }

    // confirm before dropping
    $msg = "This will destroy any existing data(it will be backed up first), continue?";
    if( $this->_confirm($msg, array('y','n'), 'y') != 'y' ) {
      print "   Cancelled\n";
      return false;
    }

    // drop tables
    print "- Dropping existing database schema\n";
    $dbc =& $this->getDbConnection();
    $dbx = new ZenDBXML( $dbc, 
                         $this->_ini['directories']['dir_config'].'/database.xml', 
                         $this->_ini['debug']['develop_mode'] );
    $res = $dbx->dropDbSchema( $tables );
    print "   {$res[1]} of {$res[0]} tables dropped successfully\n";
    if( $res[0] != $res[1] ) {
      $diff = $res[0] - $res[1];
      $this->_printerr("_drop_database", "Drop error: $diff statements failed");
      return false;
    }

    return $res[0] > 0 && $res[0] == $res[1];
  }

  /**
   * Loads data from xml dump into the database.  Use with care!
   *
   * <b>NOTE</b>: the default behavior is to drop all existing data.  You must override this to load data
   * without deleting old data first.
   * 
   * @param string $dir the directory containing xml files that data is to be loaded from
   * @param string $table if provided, is a list of tables(comma separated) to load, otherwise all tables are loaded
   * @param boolean $dropOldData if true, all data in database will be dropped before loading new data
   */
  function _load_data( $dir, $table = null, $dropOldData = true ) {
    // confirm data directory
    if( !@dir($dir) ) {
      $this->_printerr("_load_data", "$dir does not exist! Aborting");
      return false;
    }

    // backup existing data
    if( !$this->_backup_database() ) {
      return false;
    }

    print "- Loading Data from $dir\n";

    // parse table param
    if( $table && !is_array($table) ) { $table = explode(',', $table); }

    // load the new data
    $source = $this->_ini['directories']['dir_config']."/database.xml";
    $dbc =& $this->getDbConnection();
    $dbx = new ZenDBXML( $dbc, $source, $this->_ini['debug']['develop_mode'] );
    $res = $dbx->loadDatabaseData( $dir, $table, $dropOldData );
    print "   {$res[1]} of {$res[0]} tables loaded successfully\n";
    if( $res[0] != $res[1] ) {
      $diff = $res[0] - $res[1];
      $this->_printerr("_load_data", "Load error: $diff tables failed to load correctly");
      return false;
    }
    return true;
  }

  /**
   * Updates a database schema.  This is a dangerous operation if you don't know what you are doing.
   *
   * @param string $newschema is the xml file to get the new schema from
   * @param boolean $perform if false, then it will simply display what would have happened during an update
   * @param boolean $skip used to skip backups (only available to install program) when they are already completed
   * @return boolean
   */
  function _update_db_schema( $newschema, $perform = true, $skip = false ) {
    // backup the data
    if( !$skip ) {
      if( $perform && !$this->_backup_database() ) {
        return false;
      }
    }

    print $perform? "- Updating database schema\n" : "- (simulated)Updating database schema\n";

    // get the backup folder
    $dir = $this->_getBackupLocation()."/database";

    // create schema parser and backup utility
    $source = $this->_ini['directories']['dir_config']."/database.xml";
    $dbc =& $this->getDbConnection();
    $dbx = new ZenDBXML( $dbc, $source, $this->_ini['debug']['develop_mode'] );                 

    // perform the update (or preview)
    if( $perform ) {
      $res = $dbx->updateDbSchema($newschema);
      print "   {$res[1]} of {$res[0]} updates processed successfully\n";
      if( $res[0] != $res[1] ) {
        $diff = $res[0] - $res[1];
        $this->_printerr('_update_db_schema', "DB Update failed: $diff statements failed");
        return false;
      }
    }
    else {
      $updates = $dbx->compareXMLSchemas($newschema);
      foreach( $updates as $u ) {
        print "   A {$u['action']}: ";
        $sep = "";
        foreach( $u as $key=>$val ) {
          if( $key == action ) { continue; }
          print "{$sep}[{$key}]{$val}";
          $sep = ", ";          
        }
      }
    }
    
    return $this->_synchronize_db_data($newschema, $dbx, $perform);
  }

  /*****************************************************
   ****   UTILITIES
   ****************************************************/

  /**
   * Synchronized data in a newly upgraded database, performing any queries needed to insure
   * data will work with new schema format.
   *
   * <b>NOTE</b>: this function does not backup data before running!  Use with care.
   *
   * @access private
   * @param string $newxml xml file to examine and run updates from
   * @param ZenDBXML $dbx the dbxml schema object to use
   * @param boolean $perform if false, simulates running this method
   */
  function _synchronize_db_data($newxml, $dbx, $perform) {
    // synchronize data by performing any upgrade sql statements
    print "- Synchronizing data\n";
    if( $perform ) {
      $res = $dbx->synchronizeUpgradedDbData($newxml);
      print "   {$res[1]} of {$res[0]} queries processed successfully\n";
      if( $res[0] != $res[1] ) {
        $diff = $res[0] - $res[1];
        $this->_printerr('_update_db_schema', "Synchronize data failed: $diff queries failed");
        return false;
      }
    }
    else {
      $queries = $dbx->getUpgradeQueries($newxml);
      foreach($queries as $q) {
        print "   Q ($q[0])$q[1]\n";
      }
    }
    return true;
  }

  /**
   * Attempts to locate the directory where the classes are
   * located
   *
   * @access private
   */
  function _find_classes_directory() {
    $dir = null;
    if( isset($this->_ini['directories']['dir_classes']) && @is_dir( $this->_ini['directories']['dir_classes'] ) ) {
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
   * Prints the install.php file header when a target is run
   *
   * @access private
   */
  function _printHeading() {
    print join("",file($this->_installdir."/setup/headingInfo"));
  }

  /**
   * retrieves an input parameter (insures that it exists, etc)
   *
   * @access private
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
   * @access private
   * @param string $target is the target the param is for
   * @param integer $key is the index of the var to get
   * @param mixed $default is the value to substitute if not found
   * @return boolean true or false
   */
  function _getBooleanParm( $target, $index, $default = null ) {
    return ZenUtils::parseBoolean($this->_getParm($target,$index), $default);
  }


  /**
   * Checks a specific directory, creates if specified
   *
   * @access private
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
   *
   * @access private
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
   * @access private
   * @param string $source the directory to copy from
   * @param string $dest the directory to copy to
   * @param string $chmod is the permissions to create any needed directories with (this is a string representing octal value, such as '0755')
   * @param boolean $replace tells whether files should be replaced if found
   * @return boolean succeeded
   */
  function _copyRecursively( $source, $dest, $chmod, $replace = true ) {
    print "   populating $dest [+ added, S skipped, R replaced]\n";
    $success = true;

    // make sure the directory exists
    if( !@is_dir( $dest ) && !eval("return @mkdir('$des', $chmod);") ) {
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
      if( !@copy( $file, $newfile ) ) {
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
   * @access private
   * @param string $filename
   * @return boolean loaded successfully
   */
  function _parseConfigData( $filename ) {
    $filename = $this->_installdir."/setup/$filename";
    if( !@file_exists($filename) ) {
      print "ERROR: $filename could not be loaded.  Setup will not run correctly!";
      return false;
    }
    return ZenUtils::parse_datafile($filename);
  }

  /**
   * Prints an error message
   *
   * @access private
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
   * @access private
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
   *
   * @access private
   */
  function getValidTargets() {
    return array(
                 "help" => "Brief help/usage info for targets",
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
                 "drop_database" => "Delete a database (use with caution!!)",
                 "extra_secure_mode" => "Tighten directory permissions(for unix, experimental)",
                 "full_install" => "Install a new zentrack version",
                 "merge_template_file" => "Merge existing config file into template(development tool)",
                 "prepare_install_files" => "Prepare install file(development tool)",
                 "try_db_connection" => "Test db connectivity by manually specifying connection info",
                 "update_db_schema" => "Upgrade a database schema by comparing current to a new xml schema(use with caution!!)",
                 "upgrade" => "Upgrade to new release",
                 "verify_db_connection" => "Test db connection using ini settings" );
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

  /** @var string compression type: null-do not zip, zip-use zip compression, gzip-use gzip compression */
  var $_compress = null;

}

?>
